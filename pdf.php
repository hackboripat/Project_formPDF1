<?php

function Convert($amount_number)
{
    $amount_number = number_format($amount_number, 2, ".","");
    $pt = strpos($amount_number , ".");
    $number = $fraction = "";
    if ($pt === false) 
        $number = $amount_number;
    else
    {
        $number = substr($amount_number, 0, $pt);
        $fraction = substr($amount_number, $pt + 1);
    }
    
    $ret = "";
    $baht = ReadNumber ($number);
    if ($baht != "")
        $ret .= $baht . "บาท";
    
    $satang = ReadNumber($fraction);
    if ($satang != "")
        $ret .=  $satang . "สตางค์";
    else 
        $ret .= "ถ้วน";
    return $ret;
}
 
function ReadNumber($number)
{
    $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
    $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
    $number = $number + 0;
    $ret = "";
    if ($number == 0) return $ret;
    if ($number > 1000000)
    {
        $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
        $number = intval(fmod($number, 1000000));
    }
    
    $divider = 100000;
    $pos = 0;
    while($number > 0)
    {
        $d = intval($number / $divider);
        $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : 
            ((($divider == 10) && ($d == 1)) ? "" :
            ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
        $ret .= ($d ? $position_call[$pos] : "");
        $number = $number % $divider;
        $divider = $divider / 10;
        $pos++;
    }
    return $ret;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // $company = $_POST['company'];
    // $address = $_POST['address'];
    // $quotation_id = $_POST['quotation_id'];
    // $date = $_POST['date'];

    // // customer
    // $customer_name = $_POST['customer_name'];
    // $customer_tel = $_POST['customer_tel'];
    // $customer_company = $_POST['customer_company'];
    // $customer_agency = $_POST['customer_agency'];

    // // date
    // $date_send = $_POST['date_send'];
    // $date_price = $_POST['date_price'];
    // $date_credit = $_POST['date_credit'];

    $customer_name = $_POST['customer_name'];
    $taxpayer_identification_number = $_POST['taxpayer_identification_number'];
    $telephone_number = $_POST['telephone_number'];
    $address = $_POST['address'];

    
    $volume = $_POST['volume'];
    $receipt_number = $_POST['receipt_number'];

    // $date = $_POST['date'];
    $date = new DateTimeImmutable($_POST['date']);
    $date = $date->format('d/m/Y');

    $order_number = $_POST['order_number'];
    $quotation_number = $_POST['quotation_number'];
    $make_payment = $_POST['make_payment'];
    
    // $note = $_POST['note'];

    $payment_cash = $_POST['payment_cash'] ?? "false";
    $payment_check = $_POST['payment_check'] ?? "false";
    $bank = $_POST['bank'];
    $branch = $_POST['branch'];
    $check_number = $_POST['check_number'];
    $check_date = $_POST['check_date'];

    $check_date = new DateTimeImmutable($_POST['check_date']);
    $check_date = $check_date->format('d/m/Y');
    

    // $branch = $_POST['branch'];
    // $check_number = $_POST['check_number'];
    // $check_date = $_POST['check_date'];




    // products
    $products = [];

    for ($i = 1; $i <= 10; $i++) {

        $product_price = null;
        $product_total = null;

        if (isset($_POST['product_price' . $i]) &&  $_POST['product_price' . $i] != ''){
            $product_price = number_format((float) $_POST['product_price' . $i], 2);
        }else{
            $product_price = null;
        }

        if (isset($_POST['product_total' . $i]) &&  $_POST['product_total' . $i] != ''){
            $product_total = number_format((float) $_POST['product_total' . $i], 2);
        }else{
            $product_total = null;
        }

        $product = [
            'product_number' => $i,
            'product_name' => $_POST['product_name' . $i] ?? null,
            'product_unit' => $_POST['product_unit' . $i] ?? null,
            'product_amount' => $_POST['product_amount' . $i] ?? null,
            'product_price' => $product_price,
            'product_total' => $product_total,
        ];
        $products[] = $product;
    }

    // discount
    $subtotal = $_POST['subtotal'];
    $vat = $_POST['vat'];
    $grand_total = $_POST['grand_total'];


    //{========================================================================start PDF
    // PDF Create
    require('fpdf.php');
    define('FPDF_FONTPATH', 'font/');

    // $pdf = new FPDF('P', 'mm', 'A4');

    $pdf = new FPDF('L', 'mm', array( 228.6,139.7 ));
    $pdf->SetMargins( 5,5,5);
    $pdf->SetAutoPageBreak(false);
    $pdf->AddPage();
    $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
    $pdf->AddFont('THSarabunNew', 'B', 'THSarabunNew.php');

    // $pdf->Rect(5, 5, 220, 120, 'D');
    $pdf->SetFont('THSarabunNew', '', 12);
    $pdf->SetTextColor(22, 64, 135);

    function addText($pdf, $text, $fontSize = 12, $align = "C")
    {
        $pdf->SetFont('THSarabunNew', '', $fontSize);
        $text = iconv('UTF-8', 'TIS-620//IGNORE', $text);
        $pdf->Cell(0, 8, $text, 0, 1, $align);
    }

    function createTableTitle($pdf,$customer_name,$date,$address,$order_number,$taxpayer_identification_number,$quotation_number,$telephone_number,$make_payment) {
        $pdf->Cell(143, 4, iconv('UTF-8', 'TIS-620//IGNORE', 'ชื่อลูกค้า ' . $customer_name),'LTR', 0, 'L');
        $pdf->Cell(75, 4, iconv('UTF-8', 'TIS-620//IGNORE', 'วันที่ ' . $date),'TR', 1, 'L');
        $pdf->Cell(143, 4, iconv('UTF-8', 'TIS-620//IGNORE', 'ที่อยู่ ' . $address), 'LR', 0, 'L');
        $pdf->Cell(75, 4, iconv('UTF-8', 'TIS-620//IGNORE', 'เลขที่ใบสั่งซื้อ ' . $order_number),'LR', 1, 'L');
        $pdf->Cell(143, 4, iconv('UTF-8', 'TIS-620//IGNORE', 'เลขที่ประจำตัวผู้เสียภาษี ' . $taxpayer_identification_number ), 'LR', 0, 'L');
        $pdf->Cell(75, 4, iconv('UTF-8', 'TIS-620//IGNORE', 'เลขที่ใบเสนอราคา ' . $quotation_number),'LR', 1, 'L');
        $pdf->Cell(143, 4, iconv('UTF-8', 'TIS-620//IGNORE', 'เบอร์โทรศัพท์ ' . $telephone_number), 'LR', 0, 'L');
        $pdf->Cell(75, 4, iconv('UTF-8', 'TIS-620//IGNORE', 'การชำระเงิน ' . $make_payment),'LR', 1, 'L');

    }

    function createTableProduct($pdf, $products)
    {
        $pdf->SetFont('THSarabunNew', '', 12);
        
        $pdf->Cell(13, 5, iconv('UTF-8', 'TIS-620//IGNORE', 'ลำดับ'), 1, 0, 'C');
        $pdf->Cell(110, 5, iconv('UTF-8', 'TIS-620//IGNORE', 'รายการ'), 1, 0, 'C');
        $pdf->Cell(20, 5, iconv('UTF-8', 'TIS-620//IGNORE', 'หน่วย'), 1, 0, 'C');
        $pdf->Cell(20, 5, iconv('UTF-8', 'TIS-620//IGNORE', 'จำนวน'), 1, 0, 'C');
        $pdf->Cell(22, 5, iconv('UTF-8', 'TIS-620//IGNORE', 'หน่วยละ'), 1, 0, 'C');
        $pdf->Cell(33, 5, iconv('UTF-8', 'TIS-620//IGNORE', 'จำนวนเงิน'), 1, 1, 'C');

        foreach ($products as $index => $product) {

            $pdf->Cell(13, 4, iconv('UTF-8', 'TIS-620//IGNORE', $product['product_number']), 'LR', 0, 'C');
            $pdf->Cell(110, 4, iconv('UTF-8', 'TIS-620//IGNORE', $product['product_name']), 'LR', 0, 'L');
            $pdf->Cell(20, 4, iconv('UTF-8', 'TIS-620//IGNORE', $product['product_unit']), 'LR', 0, 'C');
            $pdf->Cell(20, 4, iconv('UTF-8', 'TIS-620//IGNORE', $product['product_amount']), 'LR', 0, 'C');
            $pdf->Cell(22, 4, iconv('UTF-8', 'TIS-620//IGNORE', $product['product_price']), 'LR', 0, 'C');
            $pdf->Cell(33, 4, iconv('UTF-8', 'TIS-620//IGNORE', $product['product_total']), 'LR', 1, 'C');
        }
        $pdf->Cell(13, 4, iconv('UTF-8', 'TIS-620//IGNORE', ''), 'LBR');
        $pdf->Cell(110, 4, iconv('UTF-8', 'TIS-620//IGNORE', ''), 'LBR', 0, 'R');
        $pdf->Cell(20, 4, iconv('UTF-8', 'TIS-620//IGNORE', ''), 'LBR', 0, 'R');
        $pdf->Cell(20, 4, iconv('UTF-8', 'TIS-620//IGNORE', ''), 'LBR', 0, 'R');
        $pdf->Cell(22, 4, iconv('UTF-8', 'TIS-620//IGNORE', ''), 'LBR', 0, 'R');
        $pdf->Cell(33, 4, iconv('UTF-8', 'TIS-620//IGNORE', ''), 'LBR', 1, 'R');
    }

    

    function createTablePrice($pdf, $subtotal, $vat, $grand_total)
    {
        $pdf->SetFont('THSarabunNew', '', 10);

        $pdf->setFillColor(231,235,246); 
        $pdf->Cell(143, 4, iconv('UTF-8', 'TIS-620//IGNORE', 'ตัวอักษร      ' .Convert($grand_total)), 'LB', 0, 'L',1);

        $pdf->SetFont('THSarabunNew', '', 12);

        $pdf->Cell(42, 4, iconv('UTF-8', 'TIS-620//IGNORE', 'รวมเงิน'), 'LR', 0, 'L');
        $pdf->Cell(33, 4, iconv('UTF-8', 'TIS-620//IGNORE', number_format($subtotal, 2)), 'LR', 1, 'C');

        $pdf->Cell(143, 6, iconv('UTF-8', 'TIS-620//IGNORE', 'หมายเหตุ : 1.กรุณาแจ้งภายใน 7 วัน หากสินค้าหรือเอกสารผิดพลาด'), 0, 0, 'L');
        $pdf->Cell(42, 4, iconv('UTF-8', 'TIS-620//IGNORE', 'ภาษีมูลค่าเพิ่ม'), 'LR', 0, 'L');
        $pdf->Cell(33, 4, iconv('UTF-8', 'TIS-620//IGNORE', number_format($vat, 2)), 'LR', 1, 'C');

        $pdf->SetX(18);
        $pdf->Cell(123, 6, iconv('UTF-8', 'TIS-620//IGNORE', '2.สั่งจ่ายเช็คในนาม บริษัท ฟิตติ้ง เคเบิ้ล (ประเทศไทย) จำกัด เท่านั้น หรือโอนชำระเป็นเงินสด'), 0, 0, 'L');
        // $pdf->SetFont('THSarabunNew', 'B', 12);
        // $pdf->Cell(20, 6, iconv('UTF-8', 'TIS-620//IGNORE', 'หรือโอนชำระเป็นเงินสด'), 0, 0, 'L');

        $pdf->SetX(148);
        $pdf->Cell(42, 4, iconv('UTF-8', 'TIS-620//IGNORE', 'จำนวนเงินทั้งสิ้น'), 'LBR', 0, 'L');
        $pdf->Cell(33, 4, iconv('UTF-8', 'TIS-620//IGNORE', number_format($grand_total, 2)), 'LBR', 1, 'C');
    }

    $pageWidth = $pdf->GetPageWidth();
    $margin = 10;
    $leftCellWidth = ($pageWidth / 2) - $margin;
    $rightCellWidth = ($pageWidth / 2) - $margin;
 
    // header
    // addText($pdf, 'บริษัท ฟิตติ้ง เคเบิ้ล (ประเทศไทย) จำกัด ', 14);
    // $logo = "logo.png";
    // $pdf->Cell( 40, 40, $pdf->Image($logo, $pdf->GetX(), $pdf->GetY(), 33.78), 0, 0, 'L', false );
    // $pdf->Call(40,40,$pdf->Image('logo.png', 10, 10, 30),0,0,'L',false );
    // $pdf->Cell(0,30 , iconv('UTF-8', 'TIS-620//IGNORE', 'ต้นฉบับ'), 0,0 ,'C');
    // $pdf->Cell(0,30 , iconv('UTF-8', 'TIS-620//IGNORE', 'ใบส่งของ/ใบเสร็จรับเงิน/ใบกำกับภาษี'), 0,1 ,'L');
    $pdf->SetFillColor(22, 64, 135);
    $pdf->SetDrawColor(22, 64, 135);
    
    $pdf->Image('logo.png', 10, 10, 25);
    // $pdf->SetFont('THSarabunNew', 'B', 20);
    
    // addText($pdf,'ต้นฉบับ',20);
    $pdf->SetFont('THSarabunNew', 'B', 20);
    $pdf->Text(87,20,iconv('UTF-8', 'TIS-620//IGNORE', 'ต้นฉบับ'));

    $pdf->SetFont('THSarabunNew', 'B', 18);
    $pdf->Text(64,27,iconv('UTF-8', 'TIS-620//IGNORE', 'ใบส่งของ/ใบเสร็จรับเงิน/ใบกำกับภาษี'));
    $pdf->Rect(61.5, 21.5, 68, 7.5);
    
    $pdf->SetFont('THSarabunNew', '', 20);
    $pdf->Cell(0,8 , iconv('UTF-8', 'TIS-620//IGNORE', 'บริษัท ฟิตติ้ง เคเบิ้ล (ประเทศไทย) จำกัด'), 0,1 ,'R');
    $pdf->SetFont('THSarabunNew', '', 12);
    $pdf->Cell(0,5 , iconv('UTF-8', 'TIS-620//IGNORE', '75/148 ซอยร่มเกล้า 1 แขวงแสนแสบ'), 0,1 ,'R');
    $pdf->Cell(0,5 , iconv('UTF-8', 'TIS-620//IGNORE', 'เขตมีนบุรี กรุงเทพมหานคร 10510 โทร 082-681-6691'), 0,1 ,'R');
    $pdf->Cell(0,5 , iconv('UTF-8', 'TIS-620//IGNORE', 'เลขประจำตัวผู้เสียภาษี 0105567237820'), 0,1 ,'R');

    $pdf->SetFont('THSarabunNew', '', 12);
    $pdf->Text(150,33,iconv('UTF-8', 'TIS-620//IGNORE', 'เล่มที่ ' . $volume));
    $pdf->Text(185,33,iconv('UTF-8', 'TIS-620//IGNORE', 'เลขที่ ' . $receipt_number));

    $pdf->Cell(0,7,'',0,1);
    // $pdf->Cell(0,0,'',0,1);


    createTableTitle($pdf,$customer_name,$date,$address,$order_number,$taxpayer_identification_number,$quotation_number,$telephone_number,$make_payment);
    createTableProduct($pdf, $products);
    createTablePrice($pdf, $subtotal, $vat, $grand_total);

    // payment
    if (isset($_POST['payment_cash']) && $_POST['payment_cash'] === 'true') {
        $payment_cash = true;
    } else {
        $payment_cash = false;
    }
    if (isset($_POST['payment_check']) && $_POST['payment_check'] === 'true') {
        $payment_check = true;
    } else {
        $payment_check = false;
    }

    $checkboxSize = 3;
    $spacing = 5;
    $lineHeight = 3;

    $pdf->SetFont('THSarabunNew', '', 12);
    $pdf->Cell(0, 3, iconv('UTF-8', 'TIS-620//IGNORE', ''), 0, 1, 'L');

    $pdf->Cell(0, $checkboxSize, iconv('UTF-8', 'TIS-620//IGNORE', 'ชำระโดย'), 0, 0, 'L');

    $pdf->Rect(20, $pdf->GetY(), $checkboxSize, $checkboxSize);

    $pdf->SetFont('ZapfDingbats','', 10);
    if ($payment_cash) {
        $pdf->Text(20.3, $pdf->GetY() + 3, iconv('UTF-8', 'TIS-620//IGNORE', '3')); //เครื่องหมายถูก
    }
    // $pdf->Text(20.3, $pdf->GetY() + 3, iconv('UTF-8', 'TIS-620//IGNORE', '3'));

    $pdf->SetFont('THSarabunNew', '', 12);
    $pdf->SetX(15 + $checkboxSize + $spacing);
    $pdf->Cell(30, $checkboxSize, iconv('UTF-8', 'TIS-620//IGNORE', 'เงินสด'), 0, 0, 'L');
    // $pdf->Ln($lineHeight);

    $pdf->Rect(35, $pdf->GetY(), $checkboxSize, $checkboxSize);

    // $pdf->SetFont('THSarabunNew', '', 16);
    $pdf->SetFont('ZapfDingbats','', 10);
    if ($payment_check) {
        $pdf->Text(35.5, $pdf->GetY() + 3, iconv('UTF-8', 'TIS-620//IGNORE', '3')); //เครื่องหมายถูก
    }
    // $pdf->Text(35.5, $pdf->GetY() + 3, iconv('UTF-8', 'TIS-620//IGNORE', '3')); //เครื่องหมายถูก

    $pdf->SetFont('THSarabunNew', '', 12);
    $pdf->SetX(30 + $checkboxSize + $spacing);
    $pdf->Cell(10, $checkboxSize, iconv('UTF-8', 'TIS-620//IGNORE', 'เช็ค'), 0, 0, 'L');
    // addText($pdf, '');

    $pdf->SetFont('THSarabunNew', '', 10);
    if ($payment_check) {
       
        $pdf->Text(61,$pdf->GetY()+2,iconv('UTF-8', 'TIS-620//IGNORE', $bank));
        $pdf->Text(108,$pdf->GetY()+2,iconv('UTF-8', 'TIS-620//IGNORE', $branch));
    }

    $pdf->SetFont('THSarabunNew', '', 12);
    $pdf->Cell(50, $checkboxSize, iconv('UTF-8', 'TIS-620//IGNORE', 'ธนาคาร..........................................................'), 0, 0, 'L');
    $pdf->Cell(30, $checkboxSize, iconv('UTF-8', 'TIS-620//IGNORE', 'สาขา............................................................'), 0, 1, 'L');
    
    $pdf->SetX(48);

    $pdf->SetFont('THSarabunNew', '', 10);
    if ($payment_check) {
        $pdf->Text(62,$pdf->GetY()+3.4,iconv('UTF-8', 'TIS-620//IGNORE', $check_number));
        $pdf->Text(110,$pdf->GetY()+3.4,iconv('UTF-8', 'TIS-620//IGNORE', $check_date));
    }
        

    $pdf->SetFont('THSarabunNew', '', 12);
    $pdf->Cell(50, 6, iconv('UTF-8', 'TIS-620//IGNORE', 'เช็คเลขที่.........................................................'), 0, 0, 'L');
    $pdf->Cell(30, 6, iconv('UTF-8', 'TIS-620//IGNORE', 'ลงวันที่.........................................................'), 0, 1, 'L');



    $pdf->Cell(55, 1, iconv('UTF-8', 'TIS-620//IGNORE', ''), '', 1, 'C');

    //ลายเช็น
    $pdf->SetFont('THSarabunNew', '', 14);
    // $pdf->Cell(90, 5, iconv('UTF-8', 'TIS-620//IGNORE', ''), 0, 1, 'L');
    // $pdf->Cell(10, 5, iconv('UTF-8', 'TIS-620//IGNORE', ''), 0, 0, 'C');
    $pdf->Cell(55, 5, iconv('UTF-8', 'TIS-620//IGNORE', '...........................................................'), '', 0, 'C');
    $pdf->Cell(55, 5, iconv('UTF-8', 'TIS-620//IGNORE', '...........................................................'), '', 0, 'C');
    $pdf->Cell(55, 5, iconv('UTF-8', 'TIS-620//IGNORE', '...........................................................'), '', 0, 'C');
    $pdf->Cell(55, 5, iconv('UTF-8', 'TIS-620//IGNORE', '...........................................................'), '', 1, 'C');

    
    $pdf->Cell(55, 3, iconv('UTF-8', 'TIS-620//IGNORE', '(                                          )'), '', 0, 'C');
    $pdf->Cell(55, 3, iconv('UTF-8', 'TIS-620//IGNORE', '(                                          )'), '', 0, 'C');
    $pdf->Cell(55, 3, iconv('UTF-8', 'TIS-620//IGNORE', '(                                          )'), '', 0, 'C');
    $pdf->Cell(55, 3, iconv('UTF-8', 'TIS-620//IGNORE', '(                                          )'), '', 1, 'C');
    $pdf->SetFont('THSarabunNew', '', 12);
    // $pdf->Cell(90, 5, iconv('UTF-8', 'TIS-620//IGNORE', ''), 0, 1, 'L');
    // $pdf->Cell(10, 5, iconv('UTF-8', 'TIS-620//IGNORE', ''), 0, 0, 'C');
    $pdf->Cell(55, 5, iconv('UTF-8', 'TIS-620//IGNORE', 'ผู้ส่งสินค้า'), 0, 0, 'C');
    $pdf->Cell(55, 5, iconv('UTF-8', 'TIS-620//IGNORE', 'ผู้รับสินค้า'), 0, 0, 'C');
    $pdf->Cell(55, 5, iconv('UTF-8', 'TIS-620//IGNORE', 'ผู้รับเงิน'), 0, 0, 'C');
    $pdf->Cell(55, 5, iconv('UTF-8', 'TIS-620//IGNORE', 'ผู้มีอำนาจนาม'), 0, 1, 'C');


    if (!file_exists('purchase_order')) {
        mkdir('purchase_order', 0755, true);
    }

    //}stop PDF

    require('config.php');

    try {
        $bank = $_POST['bank'] ?? ' (ไม่ได้ระบุ)';
        if (($_POST['payment_cash'] ?? 'false') === 'true' && ($_POST['payment_check'] ?? 'false') === 'true') {

            $payment = 'การชำระเงินผ่านเงินสด';

        } else if ($_POST['payment_cash'] === 'true') {

            $payment = 'การชำระเงินผ่านเงินสด ';

        } else if ($_POST['payment_check'] === 'true') {

            $payment = 'เช็ค';

        } else {

            $payment = '-';

        }

        $conn->beginTransaction(); // Start a transaction

        // Insert into the orders table
        $stmt = $conn->prepare('INSERT INTO orders (
            date,
            customer_name,
            taxpayer_identification_number, 
            telephone_number,
            address,
            volume,
            receipt_number,
            order_number,
            quotation_number,
            make_payment,
            subtotal, 
            vat, 
            grand_total, 
            payment,
            payment_cash,
            payment_check,
            bank,
            branch,
            check_number,
            check_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)') ;
        
        $stmt->execute([
            $date, 
            $customer_name,  
            $taxpayer_identification_number, 
            $telephone_number,
            $address,
            $volume,
            $receipt_number,
            $order_number,
            $quotation_number,
            $make_payment,
            $subtotal, 
            $vat, 
            $grand_total, 
            $payment,
            $payment_cash, 
            $payment_check,
            $bank,
            $branch,
            $check_number,
            $check_date
        ]);

        // Get the last inserted order_id
        // $order_id = $conn->lastInsertId();

        // Insert into the order_detail table
        $productDetails = [];

        for ($i = 1; $i <= 10; $i++) {

            $product_number = $i;
            $product_name = $_POST['product_name' . $i] ?? null;
            $product_unit = $_POST['product_unit' . $i] ?? null;
            $product_price = isset($_POST['product_price' . $i]) ? (float) $_POST['product_price' . $i] : null;
            $product_amount = isset($_POST['product_amount' . $i]) ? (int) $_POST['product_amount' . $i] : null;

            if ($product_name && $product_price && $product_amount) {
                $productDetails[] = [
                    'number' => $product_number,
                    'name' => $product_name,
                    'unit' => $product_unit,
                    'price' => $product_price,
                    'amount' => $product_amount,
                ];
            }
        }

        $stmtDetail = $conn->prepare('INSERT INTO order_detail (product_number, product_name, product_unit, product_price, product_amount) VALUES (?, ?, ?, ?,?)');
        foreach ($productDetails as $product) {
            $stmtDetail->execute([ 
                $product['number'],
                $product['name'],
                $product['unit'], 
                $product['price'], 
                $product['amount']
            ]);
        }

        $conn->commit(); // Commit the transaction
        echo "Order and details inserted successfully!";
    } catch (Exception $e) {
        $conn->rollBack(); // Rollback the transaction on error
        echo "Error: " . $e->getMessage();
    }


    $pdf->Output("purchase_order/purchase_order.pdf", "F");
    $uploadDir = "uploads";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $newFileName = date('dmY_His') . ".pdf";

    $sourceFile = "purchase_order/purchase_order.pdf";
    $destinationFile = $uploadDir . "/" . $newFileName;
    if (!copy($sourceFile, $destinationFile)) {
        die("ไม่สามารถคัดลอกไฟล์ไปยังโฟลเดอร์ upload ได้");
    }

    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="purchase_order.pdf"');
    readfile($sourceFile);
    exit;
}
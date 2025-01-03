<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {



    $id = uniqid(time());

    $reason_purchase = $_POST['reason_purchase'];
    $department = $_POST['department'];
    $volume = $_POST['volume'];
    $receipt_number = $_POST['receipt_number'];

    $date = new DateTimeImmutable($_POST['date']);
    $date = $date->format('d/m/Y');

    $agency = $_POST['agency'];

    $delivery_date = new DateTimeImmutable($_POST['delivery_date']);
    $delivery_date = $delivery_date->format('d/m/Y');

    $purchasing_department = $_POST['purchasing_department'];

    $date_get_job = new DateTimeImmutable($_POST['date_get_job']);
    $date_get_job = $date_get_job->format('d/m/Y');


    $journalist = $_POST['journalist'];




    // products
    $list_purchase_orders = [];

    for ($i = 1; $i <= 10; $i++) {

        // $product_price = null;
        // $product_total = null;
        $price_per_unit = null;
        $quantity = null;

        if (isset($_POST['price_per_unit' . $i]) &&  $_POST['price_per_unit' . $i] != ''){
            $price_per_unit = number_format((float) $_POST['price_per_unit' . $i], 2);
        }else{
            $price_per_unit = null;
        }

        if (isset($_POST['quantity' . $i]) &&  $_POST['quantity' . $i] != ''){
            $quantity = number_format((float) $_POST['quantity' . $i], 2);
        }else{
            $quantity = null;
        }

        $list_purchase_order = [
            'number' => $i,
            'name_and_detail' => $_POST['name_and_detail' . $i] ?? null,
            'price_per_unit' => $price_per_unit,
            'quantity' => $quantity,
            'note' => $_POST['note' . $i] ?? null

        ];

        $list_purchase_orders[] = $list_purchase_order;
    }



    //{========================================================================start PDF
    // PDF Create
    require('fpdf.php');
    define('FPDF_FONTPATH', 'font/');

    $pdf = new FPDF('L', 'mm', 'A4');

    // $pdf = new FPDF('L', 'mm', array( 228.6,139.7 ));
    $pdf->SetMargins( 10,10,10);
    $pdf->SetAutoPageBreak(false);
    $pdf->AddPage();
    $pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
    $pdf->AddFont('THSarabunNew', 'B', 'THSarabunNew.php');

    // $pdf->Rect(5, 5, 220, 120, 'D');
    $pdf->SetFont('THSarabunNew', '', 12);
    $pdf->SetTextColor(0, 0, 0);

    function createTable($pdf, $list_purchase_orders)
    {
        $pdf->SetFont('THSarabunNew', '', 16);


        $pdf->Cell(20, 16, iconv('UTF-8', 'TIS-620//IGNORE', 'รายการที่'), 1, 0, 'C');
        $pdf->Cell(20, 16, iconv('UTF-8', 'TIS-620//IGNORE', 'จำนวน'), 1, 0, 'C');
        $pdf->Cell(130, 16, iconv('UTF-8', 'TIS-620//IGNORE', 'ชื่อและรายละเอียดส่งที่ต้องการ'), 1, 0, 'C');
        // $pdf->Cell(50, 16, $pdf->MultiCell(50,10 ,iconv('UTF-8', 'TIS-620//IGNORE', "ราคาต่อหน่วย \n (ถ้าทราบ)") ,1,'C',0), 1, 0, 'C');
        $y = $pdf->GetY();
        $x = $pdf->GetX()+35;
        $pdf->MultiCell(35,8 ,iconv('UTF-8', 'TIS-620//IGNORE', "ราคาต่อหน่วย \n (ถ้าทราบ)") ,1,'C',0);

        $pdf->SetXY($x, $y);
        $pdf->Cell(70, 16, iconv('UTF-8', 'TIS-620//IGNORE', 'หมายเหตุร้านที่เคยหรือต้องการสั่งซื้อ'), 1, 1, 'C');

        foreach ($list_purchase_orders as $index => $list_purchase_order) {
            $pdf->Cell(20, 8, iconv('UTF-8', 'TIS-620//IGNORE', $list_purchase_order['number']), '1', 0, 'C');
            $pdf->Cell(20, 8, iconv('UTF-8', 'TIS-620//IGNORE', $list_purchase_order['quantity']), '1', 0, 'C');
            $pdf->Cell(130, 8, iconv('UTF-8', 'TIS-620//IGNORE', $list_purchase_order['name_and_detail']), '1', 0, 'L');
            $pdf->Cell(35, 8, iconv('UTF-8', 'TIS-620//IGNORE', $list_purchase_order['price_per_unit']), '1', 0, 'C');
            $pdf->Cell(70, 8, iconv('UTF-8', 'TIS-620//IGNORE', $list_purchase_order['note']), '1', 1, 'L');
        }

        // $pdf->Cell(20, 4, iconv('UTF-8', 'TIS-620//IGNORE', ''), 'LBR');
        // $pdf->Cell(20, 4, iconv('UTF-8', 'TIS-620//IGNORE', ''), 'LBR', 0, 'R');
        // $pdf->Cell(130, 4, iconv('UTF-8', 'TIS-620//IGNORE', ''), 'LBR', 0, 'R');
        // $pdf->Cell(35, 4, iconv('UTF-8', 'TIS-620//IGNORE', ''), 'LBR', 0, 'R');
        // $pdf->Cell(70, 4, iconv('UTF-8', 'TIS-620//IGNORE', ''), 'LBR', 1, 'R');

    }

    $pageWidth = $pdf->GetPageWidth();
    $margin = 10;
    $leftCellWidth = ($pageWidth / 2) - $margin;
    $rightCellWidth = ($pageWidth / 2) - $margin;
 
    $pdf->SetFillColor(0, 0, 0); //สีตัวอักษร
    $pdf->SetDrawColor(0, 0, 0); //สีตาราง

    //header
    
    // $pdf->Image('logo.png', 10, 10, 25);
    $pdf->SetFont('THSarabunNew', 'B', 16);
    
    
    $pdf->Text(10,15,iconv('UTF-8', 'TIS-620//IGNORE', 'เล่มที่ ' . $volume));
    $pdf->Text(19,16,iconv('UTF-8', 'TIS-620//IGNORE', '..................'));


    $pdf->Text(215,15,iconv('UTF-8', 'TIS-620//IGNORE', 'เลขที่ ' . $receipt_number));
    $pdf->Text(224,16,iconv('UTF-8', 'TIS-620//IGNORE', '..................'));


    $pdf->SetFont('THSarabunNew', 'B', 20);

    $pdf->Cell(0, 8 ,iconv('UTF-8', 'TIS-620//IGNORE', 'ใบขอซื้อ ') ,0,1, 'C');

    $pdf->Cell(0, 10 ,iconv('UTF-8', 'TIS-620//IGNORE', 'PURCHASE REQUEST') ,0,1, 'C');

    $pdf->SetXY($pdf->GetX(), $pdf->GetY()+5);


    $pdf->SetFont('THSarabunNew', 'B', 16);

    $pdf->Text(40,50,iconv('UTF-8', 'TIS-620//IGNORE', 'เหตุผลในการขอซื้อ ' . $reason_purchase));
    $pdf->Text(70,51,iconv('UTF-8', 'TIS-620//IGNORE', '_______________________ ' ));


    $pdf->Text(125,50,iconv('UTF-8', 'TIS-620//IGNORE', 'แผนก '. $department));
    $pdf->Text(135,51,iconv('UTF-8', 'TIS-620//IGNORE', '______________________________ '));




    $pdf->Cell(205, 10 ,iconv('UTF-8', 'TIS-620//IGNORE', '') ,0,0, 'C');
    $pdf->Cell(70, 10 ,iconv('UTF-8', 'TIS-620//IGNORE', 'วันที่/เดือน/ปี  ' . $date) ,0,1, 'L');
    $pdf->Text(239,40,iconv('UTF-8', 'TIS-620//IGNORE', '_______________________'));



    $pdf->Cell(205, 10 ,iconv('UTF-8', 'TIS-620//IGNORE', '') ,0,0, 'C');
    $pdf->Cell(70, 10 ,iconv('UTF-8', 'TIS-620//IGNORE', 'หน่วยงาน  ' . $agency) ,0,1, 'L');
    $pdf->Text(233,50,iconv('UTF-8', 'TIS-620//IGNORE', '__________________________ '));


    $pdf->Cell(205, 10 ,iconv('UTF-8', 'TIS-620//IGNORE', '') ,0,0, 'C');
    $pdf->Cell(70, 10 ,iconv('UTF-8', 'TIS-620//IGNORE', 'วันที่ส่งมอบ ' . $delivery_date) ,0,1, 'L');
    $pdf->Text(235,60,iconv('UTF-8', 'TIS-620//IGNORE', '_________________________ '));

    $pdf->SetXY($pdf->GetX(), $pdf->GetY()+3);

    createTable($pdf, $list_purchase_orders);

    $pdf->SetXY($pdf->GetX() , $pdf->GetY()+3);
    $pdf->Cell(70, 10, iconv('UTF-8', 'TIS-620//IGNORE', 'จัดทำโดย'), "LTR", 0, 'C');
    $pdf->Cell(70, 10, iconv('UTF-8', 'TIS-620//IGNORE', 'อนุมัติโดย'), "LTR", 0, 'C');
    $pdf->Cell(65, 10, iconv('UTF-8', 'TIS-620//IGNORE', ''), "LTR", 0, 'C');
    $pdf->Cell(70, 10, iconv('UTF-8', 'TIS-620//IGNORE', 'แผนกจัดซื้อ ' . $purchasing_department), "LTR", 1, 'L');

    // $pdf->SetXY($pdf->GetX(), $pdf->GetY()+3);
    
    // $pdf->SetXY(0, $pdf->GetY());
    
    $pdf->Cell(70, 10, iconv('UTF-8', 'TIS-620//IGNORE', ''), "LR", 0, 'C');
    $pdf->Cell(70, 10, iconv('UTF-8', 'TIS-620//IGNORE', ''), "LR", 0, 'C');
    $pdf->Cell(65, 10, iconv('UTF-8', 'TIS-620//IGNORE', ''), "LR", 0, 'C');
    $pdf->Cell(70, 10, iconv('UTF-8', 'TIS-620//IGNORE', 'รับงานวันที่  ' . $date_get_job), "LR", 1, 'L');

    $pdf->Cell(70, 10, iconv('UTF-8', 'TIS-620//IGNORE', ''), "LR", 0, 'C');
    $pdf->Cell(70, 10, iconv('UTF-8', 'TIS-620//IGNORE', ''), "LR", 0, 'C');
    $pdf->Cell(65, 10, iconv('UTF-8', 'TIS-620//IGNORE', ''), "LR", 0, 'C');
    $pdf->Cell(70, 10, iconv('UTF-8', 'TIS-620//IGNORE', 'ผู้บันทึก  ' . $journalist), "LR", 1, 'L');

    $pdf->Cell(70, 5, iconv('UTF-8', 'TIS-620//IGNORE', ''), "LBR", 0, 'C');
    $pdf->Cell(70, 5, iconv('UTF-8', 'TIS-620//IGNORE', ''), "LBR", 0, 'C');
    $pdf->Cell(65, 5, iconv('UTF-8', 'TIS-620//IGNORE', ''), "LBR", 0, 'C');
    $pdf->Cell(70, 5, iconv('UTF-8', 'TIS-620//IGNORE', ''), "LBR", 1, 'L');
    
    
    $pdf->Text($pdf->GetX()+225,$pdf->GetY()-27,iconv('UTF-8', 'TIS-620//IGNORE', '..................................................'));
    $pdf->Text($pdf->GetX()+225,$pdf->GetY()-17,iconv('UTF-8', 'TIS-620//IGNORE', '..................................................'));
    $pdf->Text($pdf->GetX()+220,$pdf->GetY()-7,iconv('UTF-8', 'TIS-620//IGNORE', '.......................................................'));

    $x_ = $pdf->GetX();
    $y_ = $pdf->GetY();

    $pdf->SetXY($x_,$y_-23);

    $pdf->MultiCell(70,10 ,iconv('UTF-8', 'TIS-620//IGNORE', "...............................................................\n(................../................../..................)") ,0,'C',0);

    $pdf->SetXY($x_+70, $y_-23);
    $pdf->MultiCell(70,10 ,iconv('UTF-8', 'TIS-620//IGNORE', "...............................................................\n(................../................../..................)") ,0,'C',0);

    $pdf->SetXY($x_+140, $y_-27);
    $pdf->MultiCell(65,10 ,iconv('UTF-8', 'TIS-620//IGNORE', "ต้นฉบับส่งที่แผนกจัดซื้อ\nสำเนาเก็บที่ผู้จัดทำ") ,0,'C',0);


    if (!file_exists('purchase_order')) {
        mkdir('purchase_order', 0755, true);
    }

    //}stop PDF

    require('config.php');

    try {

        $conn->beginTransaction(); // Start a transaction

        // Insert into the orders table
        $stmt = $conn->prepare('INSERT INTO detail_purchase_order (
            id,
            reason_purchase,
            department, 
            volume,
            receipt_number,
            date,
            agency,
            delivery_date,
            purchasing_department,
            date_get_job,
            journalist) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)') ;
        
        $stmt->execute([
            $id, 
            $reason_purchase,  
            $department, 
            $volume,
            $receipt_number,
            $_POST['date'] ?? null,
            $agency,
            $_POST['delivery_date'] ?? null,
            $purchasing_department,
            $_POST['date_get_job'] ?? null,
            $journalist
        ]);

        // Get the last inserted order_id
        // $order_id = $conn->lastInsertId();

        // Insert into the order_detail table
        $list_orders = [];

        for ($i = 1; $i <= 10; $i++) {

            $number = $i;
            $quantity = (float) $_POST['quantity' .$i] ?? NULL;
            $name_and_detail = $_POST['name_and_detail' .$i] ?? NULL;
            $price_per_unit = (float) $_POST['price_per_unit' .$i] ?? NULL;
            $note = $_POST['note' .$i] ?? NULL;



            // $product_number = $i;
            // $product_name = $_POST['product_name' . $i] ?? null;
            // $product_unit = $_POST['product_unit' . $i] ?? null;
            // $product_price = isset($_POST['product_price' . $i]) ? (float) $_POST['product_price' . $i] : null;
            // $product_amount = isset($_POST['product_amount' . $i]) ? (int) $_POST['product_amount' . $i] : null;

            if ($number && $quantity && $name_and_detail && $price_per_unit && $note) {
                $list_orders[] = [
                    'id' => $id,
                    'number' => $number,
                    'quantity' => $quantity,
                    'name_and_detail' => $name_and_detail,
                    'price_per_unit' => $price_per_unit,
                    'note' => $note,
                ];
            }

        }

        $stmtDetail = $conn->prepare('INSERT INTO list_purchase_order (id,number, quantity, name_and_detail, price_per_unit, note) VALUES (?, ?, ?, ?, ?, ?)');
        foreach ($list_orders as $list_order) {
            $stmtDetail->execute([ 
                $list_order['id'],
                $list_order['number'],
                $list_order['quantity'],
                $list_order['name_and_detail'], 
                $list_order['price_per_unit'], 
                $list_order['note']
            ]);
        }

        $conn->commit(); // Commit the transaction
        echo "Data saved successfully!";
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
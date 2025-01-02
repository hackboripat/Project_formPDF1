<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบส่งของ/ใบเสร็จรับเงิน/ใบกำกับภาษี</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>

    <!-- container -->
    <div class="container">
        <div class="header">
            <p>ใบส่งของ/ใบเสร็จรับเงิน/ใบกำกับภาษี</p>
        </div>
        <form action="pdf.php" method="post" id="product-form" target="_blank">

            <div class="row">

                <div class="col">

                    <!-- form1 -->
                    <div class="form1">
                     <table>
                        <tr>
                            <td width="80px"><label for="customer_name">ชื่อลูกค้า</label></td>
                            <td><input type="text" id="customer_name" name="customer_name" required></td>
                        </tr>
                        <tr>
                            <td><label for="address">ที่อยู่</label></td>
                            <td><input type="text" id="address" name="address" required></td>
                        </tr>
                        <tr>
                            <td><label for="taxpayer_identification_number">เลขที่ประจำตัวผู้เสียภาษี</label></td>
                            <td><input type="text" id="taxpayer_identification_number" name="taxpayer_identification_number" required></td>
                        </tr>
                        <tr>
                            <td><label for="telephone_number">เบอร์โทรศัพท์</label></td>
                            <td><input type="text" id="telephone_number" name="telephone_number" required></td>
                        </tr>
                     </table>

                    </div>

                    <!-- form2 -->
                    <!-- <div class="form2">
                        <div>
                            <p for="fname">หมายเหตุ</p>
                            <textarea  id="note"  name="note" ></textarea>
                        </div>

                    </div> -->

                </div>

                <div class="col">

                    <!-- form3 -->
                    <div class="form3">

                        <table>
                            <tr>
                                <td><label for="volume">เล่มที่</label></td>
                                <td><input type="text" id="volume" name="volume" required></td>
                            </tr>
                            <tr>
                                <td><label for="receipt_number">เลขที่</label></td>
                                <td><input type="text" id="receipt_number" name="receipt_number" required></td>
                            </tr>
                            <tr>
                                <td><label for="date">วันที่</label></td>
                                <td><input type="date" class="" id="date" name="date"  onkeydown="return false" required></td>
                                <span id="datePickerLbl" style="pointer-events: none;"></span>
                            </tr>
                            <tr>
                                <td><label for="order_number">เลขที่ใบสั่งซื้อ</label></td>
                                <td><input type="text" id="order_number" name="order_number" required></td>
                            </tr>
                            <tr>
                                <td><label for="quotation_number">เลขที่ใบเสนอราคา</label></td>
                                <td><input type="text" id="quotation_number" name="quotation_number" required></td>
                            </tr>
                            <tr>
                                <td><label for="make_payment">ชำระเงิน</label></td>
                                <td><input type="text" id="make_payment" name="make_payment" required></td>
                            </tr>
                     </table>

                    </div>
                    
                </div>
                <div class="col">

                    <div class="form4">
                        <table>
                            <tr>
                                <td width="40px"><input type="checkbox" id="payment_cash" name="payment_cash" value="true"></td>
                                <td><label for="payment_cash"> การชำระเงินผ่านเงินสด</label></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" id="payment_check" name="payment_check" value="true"></td>
                                <td><label for="payment_check"> เช็ค</label></td>
                            </tr>

                            <tr>
                            
                                <td colspan="2">
                                    <table>
                                        <tr>
                                            <td width="115px"><label for="bank">ธนาคาร</label></td>
                                            <td><input type="text" id="bank" name="bank"></td>
                                        </tr>
                                        <tr>
                                            <td><label for="branch">สาขา</label></td>
                                            <td><input type="text" id="branch" name="branch"></td>
                                        </tr>
                                        <tr>
                                            <td><label for="check_number">เลขที่เช็ค</label></td>
                                            <td><input type="text" id="check_number" name="check_number"></td>
                                        </tr>
                                        <tr>
                                            <td><label for="check_date">ลงวันที่</label></td>
                                            <td><input type="date" id="check_date" name="check_date"></td>
                                        </tr>
                                    </table>
                                </td>
                                
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="table_products">
                <table>
                    <tr>
                        <th width="544px">รายการ</th>
                        <th width="180px">หน่วย</th>
                        <th width="180px">จำนวน</th>
                        <th width="180px">หน่วยละ</th>
                        <th width="180px">จำนวนเงิน</th>
                    </tr>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                    <tr>
                        <td><input type="text" name="product_name<?= $i ?>" <?= $i === 1 ? 'required' : '' ?>></td>
                        <td><input type="text" name="product_unit<?= $i ?>" <?= $i === 1 ? 'required' : '' ?>></td>
                        <td><input type="number" name="product_amount<?= $i ?>" <?= $i === 1 ? 'required' : '' ?>></td>
                        <td><input type="number" name="product_price<?= $i ?>" <?= $i === 1 ? 'required' : '' ?>></td>
                        <td><input type="number" name="product_total<?= $i ?>" readonly></td>
                    </tr>
                    <?php endfor; ?>
                </table>

            </div>

            <div class="summary">
                <table>
                    <tr>
                        <td><label for="subtotal">ยอดเงินรวม</label ></td>
                        <td><input type="number" id="subtotal" name="subtotal" readonly></td>
                    </tr>
                    <tr>
                        <td><label for="vat">ภาษีมูลค่าเพิ่ม</label></td>
                        <td><input type="number" id="vat" name="vat" readonly></td>
                    </tr>
                    <tr>
                        <td><label for="grand_total">ราคารวมทั้งสิ้น</label></td>
                        <td><input type="number" id="grand_total" name="grand_total"  readonly></td>
                    </tr>
                </table>

            </div>
            <div class="button_form">
                <button type="submit">
                    <!-- <i class="bi bi-printer"></i>  -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
                        <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1"/>
                    </svg>
                    พิมพ์
                </button>
                <button type="button" id="clear-form">
                    <!-- <i class="bi bi-x-square"></i>  -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                    </svg>
                    ล้างข้อมูลทั้งหมด
                </button>

            </div>

        </form>
    </div>


    <script>


        var today = new Date();
        document.getElementById("date").value = (today.getFullYear()+ 543) + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        document.getElementById("check_date").value = (today.getFullYear()+ 543) + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);

            
            // }
        document.addEventListener("DOMContentLoaded", function() {
                // document.querySelector(`input[name="date_check"]`).value = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
                const rows = 10;
                const vatRate = 7;

            function calculateRowTotal(row) {
                // const amount = parseFloat(document.querySelector(`input[name="product_amount${row}"]`).value) || 0;
                // const price = parseFloat(document.querySelector(`input[name="product_price${row}"]`).value) || 0;
                // const total = amount * price;
                // document.querySelector(`input[name="product_total${row}"]`).value = total.toFixed(2);

                // return total;

                const amount = parseFloat(document.querySelector(`input[name="product_amount${row}"]`).value || 0);
                const price = parseFloat(document.querySelector(`input[name="product_price${row}"]`).value || 0);

                let total = 0;

                if((price == 0 && amount == 0)){

                    document.querySelector(`input[name="product_total${row}"]`).value = "";
                    return 0;

                }else if(amount == 0){

                    // document.querySelector(`input[name="product_total${row}"]`).value = price.toFixed(2);
                    document.querySelector(`input[name="product_total${row}"]`).value = price;
                    return price;

                }else if(price == 0){
                    document.querySelector(`input[name="product_total${row}"]`).value = "";
                    return 0;
                }else{

                    total = amount * price;
                    document.querySelector(`input[name="product_total${row}"]`).value = total.toFixed(2);

                    return total;
                }


            }

            function calculateAllTotals() {
                let subtotal = 0;

                for (let i = 1; i <= rows; i++) {

                    subtotal += calculateRowTotal(i);
                    // if(calculateRowTotal(i) != null){
                        
                    // }else{
                    //     subtotal += 0;
                    // }
                }

                console.log("subtotal >.>",subtotal)

                // const discount = parseFloat(document.querySelector('input[name="discount"]').value) || 0;
                // const discount = 0;
                // const afterDiscount = subtotal - discount;

                const vat = subtotal * (vatRate / 100);
                const grandTotal = subtotal + vat;

                // อัพเดตค่าฟิลด์ต่าง ๆ
                document.querySelector('input[name="subtotal"]').value = subtotal.toFixed(2);
                // document.querySelector('input[name="after_discount"]').value = afterDiscount.toFixed(2);
                document.querySelector('input[name="vat"]').value = vat.toFixed(2);
                document.querySelector('input[name="grand_total"]').value = grandTotal.toFixed(2);
            }

            // เพิ่ม event listeners สำหรับฟิลด์ที่เกี่ยวข้อง
            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener("input", calculateAllTotals);
            });

            calculateAllTotals();
        });

        document.addEventListener("DOMContentLoaded", function() {

            const form = document.getElementById("product-form");
            const clearButton = document.getElementById("clear-form");


            // ฟังก์ชันล้างค่าฟอร์ม
            function clearForm() {

                form.reset();

                document.querySelectorAll('input[type="number"]').forEach(input => {
                    input.value = "";
                });
                document.querySelectorAll('input[type="text"]').forEach(input => {
                    input.value = "";
                });

                var today_ = new Date();
                document.getElementById("date").value = (today_.getFullYear()+ 543) + '-' + ('0' + (today_.getMonth() + 1)).slice(-2) + '-' + ('0' + today_.getDate()).slice(-2);
                document.getElementById("check_date").value = (today_.getFullYear()+ 543) + '-' + ('0' + (today_.getMonth() + 1)).slice(-2) + '-' + ('0' + today_.getDate()).slice(-2);
            }
            
            clearButton.addEventListener("click", clearForm);
        });

    </script>

</body>

</html>
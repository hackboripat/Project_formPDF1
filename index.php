<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบขอซื้อ</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>

    <?php date_default_timezone_set('Asia/Bangkok');?>

    <!-- container -->
    <div class="container">
        <div class="header">
            <p>ใบขอซื้อ</p>
        </div>
        <form action="pdf.php" method="post" id="product-form" target="_blank">

            <div class="row">

                <div class="col">

                    <!-- form1 -->
                    <div class="form1">
                     <table>
                        <tr>
                            <td width="80px"><label for="reason_purchase">เหตุผลในการขอซื้อ</label></td>
                            <td><input type="text" id="reason_purchase" name="reason_purchase" required></td>
                        </tr>
                        <tr>
                            <td><label for="department">แผนก</label></td>
                            <td><input type="text" id="department" name="department" required></td>
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

                    <!-- form2 -->
                    <div class="form2">

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
                                <td><label for="date">วันที่/เดือน/ปี</label></td>
                                <td><input type="date" class="" id="date" name="date" value="<?php echo date((date("Y")+543).'-m-d')?>" required></td>
                            </tr>
                            <tr>
                                <td><label for="agency">หน่วยงาน</label></td>
                                <td><input type="text" id="agency" name="agency" required></td>
                            </tr>
                            <tr>
                                <td><label for="delivery_date">วันที่ส่งมอบ</label></td>
                                <td><input type="date" class="" id="delivery_date" name="delivery_date" value="<?php echo date((date("Y")+543).'-m-d')?>" required></td>
                            </tr>

                     </table>

                    </div>
                    
                </div>
                <div class="col">

                    <div class="form3">
                        <table>
                            <tr>
                                <td><label for="purchasing_department">แผนกจัดซื้อ</label></td>
                                <td><input type="text" id="purchasing_department" name="purchasing_department" required></td>
                            </tr>
                            <tr>
                                <td><label for="date_get_job">รับงานวันที่</label></td>
                                <td><input type="date" class="" id="date_get_job" name="date_get_job" value="<?php echo date((date("Y")+543).'-m-d')?>" required></td>
                            </tr>
                            <tr>
                                <td><label for="order_number">ผู้บันทึก</label></td>
                                <td><input type="text" id="journalist" name="journalist" required></td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>

            <div class="table_products">
                <table>
                    <tr>
                        <th width="90px">รายการที่</th>
                        <th width="90px">จำนวน</th>
                        <th width="500px">ชื่อและรายละเอียดส่งที่ต้องการ</th>
                        <th width="120px">ราคาต่อหน่วย <br>(ถ้าทราบ) </th>
                        <th width="480px">หมายเหตุร้านที่เคยหรือต้องการสั่งซื้อ</th>
                    </tr>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                    <tr>
                        <td>
                            <div class="product_level" tabindex="-1">
                                <input type="number" name="number<?=$i?>" <?= $i === 1 ? 'required' : '' ?> id="number<?=$i?>" value="<?=$i?>" tabindex="-1"  readonly>
                            </div>
                        </td>
                        <td><input type="number" name="quantity<?= $i ?>" <?= $i === 1 ? 'required' : '' ?>></td>
                        <td><input type="text" name="name_and_detail<?= $i ?>" <?= $i === 1 ? 'required' : '' ?>></td>
                        <td><input type="number" name="price_per_unit<?= $i ?>" <?= $i === 1 ? 'required' : '' ?>></td>
                        <td><input type="text" name="note<?= $i ?>" ></td>
                    </tr>
                    <?php endfor; ?>
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
        document.getElementById("delivery_date").value = (today.getFullYear()+ 543) + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
        document.getElementById("date_get_job").value = (today.getFullYear()+ 543) + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);


            
            // }

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
                document.getElementById("delivery_date").value = (today.getFullYear()+ 543) + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);
                document.getElementById("date_get_job").value = (today.getFullYear()+ 543) + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);

                
                for (let index = 1; index <= 10; index++) {
                    document.getElementById(`number${index}`).value = index;
                }
            }
            
            clearButton.addEventListener("click", clearForm);
        });

    </script>

</body>

</html>
<?php

session_start();

include "connection.php";

if (isset($_SESSION["u"])) {
    $user_email = $_SESSION["u"]["email"];
    $user_rs = Database::search("SELECT * FROM `users` INNER JOIN `user_type` ON user_type.user_type_id=users.user_type_id 
    WHERE email='$user_email'");
    $user_data = $user_rs->fetch_assoc();

    if (isset($_GET["order_id"])) {
        $order_id = $_GET["order_id"];
    }

    $order_rs = Database::search("SELECT * FROM `order` INNER JOIN `order_status` 
    ON order.order_status_id=order_status.order_status_id INNER JOIN `users` 
    ON order.users_email=users.email WHERE order_id='$order_id'");
    $order_num = $order_rs->num_rows;
    $order_data = $order_rs->fetch_assoc();

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order - BZ#0<?php echo $order_id; ?></title>
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link rel="icon" href="resourses/logo.svg" />

    </head>

    <body class="admin-body">
        <div class="container-fluid bg-light min-vh-100">
            <div class="row">
                <div class="col-3 d-none d-lg-block">
                    <?php
                    if ($user_data["user_type_id"] == 1) {
                        include "admin-sidebar.php";
                    } else {
                        include "user-sidebar.php";
                    }
                    ?>
                </div>
                <div class="col-12 col-lg-9 p-0">
                    <div class="admin-header bg-white">
                        <div class="p-3 d-flex gap-2 align-items-center">
                            <button class="btn btn-primary headerbtn d-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminMenu" aria-controls="adminMenu">
                                <i class="bi bi-list"></i></i>&nbsp;Menu
                            </button>
                            <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="adminMenu" aria-labelledby="adminMenuLabel">
                                <div class="offcanvas-header bg-white">
                                    <a class="navbar-brand" href="index.php">
                                        <img src="resourses/logo2.svg" alt="Logo" height="50" class="d-inline-block align-text-center">
                                    </a>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body justify-content-sm-start">
                                    <?php
                                    if ($user_data["user_type_id"] == 1) {
                                        include "admin-offcanvas.php";
                                    } else {
                                        include "user-offcanvas.php";
                                    }
                                    ?>
                                </div>
                            </div>
                            <a class="navbar-brand d-none d-lg-block" href="index.php">
                                <img src="resourses/logo.svg" alt="Logo" height="50" class="d-inline-block align-text-center">
                            </a>
                            <h2 class="mb-0">BZ#0<?php echo $order_id; ?></h2>
                        </div>
                        <div class="p-3 d-flex gap-2 align-items-center">
                            <?php
                            if ($user_data["user_type_id"] == 1) {
                            ?>
                                <button class="btn btn-secondary headerbtn" onclick="location.href = 'orders.php'" type="button"><i class="bi bi-caret-left-fill"></i>&nbsp; Back</button>
                                <button class="btn btn-primary headerbtn" data-bs-toggle="modal" data-bs-target="#changerOrderStetus" type="button"><i class="bi bi-arrow-repeat"></i>&nbsp; Change Stetus</button>
                            <?php
                            } else {
                            ?>
                                <button class="btn btn-primary headerbtn" data-bs-toggle="modal" data-bs-target="#exampleModal" type="button"><i class="bi bi-eye"></i>&nbsp; View Invoice</button>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="modal fade" id="changerOrderStetus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Change Order Stetus</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="d-flex gap-3">
                                        <select name="" class="form-control" id="orderStetusSelecter">
                                            <option value="0" selected>Select Stetus To Change</option>
                                            <option value="1">Pending</option>
                                            <option value="2">Processing</option>
                                            <option value="3">Returned</option>
                                            <option value="4">Compleated</option>
                                            <option value="5">Cancelled</option>
                                        </select>
                                        <button class="btn btn-primary text-nowrap" onclick="changeOrderStetus(<?php echo $order_id; ?>);" id="changerOrderStetusSubmit">Change Stetus</button>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 pt-3">
                        <div class="row">
                            <div class="col-12 col-lg-5 col-md-5 p-2">
                                <div class="text-white p-3 pb-2 text-center rounded-4 mb-3 bg-<?php
                                                                                                if ($order_data["order_status"] == "Pending") {
                                                                                                    echo "info";
                                                                                                } elseif ($order_data["order_status"] == "Processing") {
                                                                                                    echo "warning";
                                                                                                } elseif ($order_data["order_status"] == "Returned") {
                                                                                                    echo "primary";
                                                                                                } elseif ($order_data["order_status"] == "Completed") {
                                                                                                    echo "success";
                                                                                                } elseif ($order_data["order_status"] == "Canselled") {
                                                                                                    echo "danger";
                                                                                                }
                                                                                                ?>">
                                    <div class="">
                                        <h4>Order <?php echo ($order_data["order_status"]) ?></h4>
                                    </div>
                                </div>
                                <div class="bg-white p-4 rounded-4 mb-3">
                                    <div class="mb-2">
                                        <h5>Billing Details</h5>
                                    </div>
                                    <span><?php echo ($order_data["first_name"]) ?> <?php echo ($order_data["last_name"]) ?></span><br>
                                    <?php
                                    $bAddress_rs = Database::search("SELECT * FROM `users_address`  WHERE `users_email` = '" . $order_data['email'] . "' AND `address_type` = '1'");
                                    $bAddress_data = $bAddress_rs->fetch_assoc();
                                    ?>
                                    <span><?php echo ($bAddress_data["line1"]) ?>,</span><br>
                                    <span><?php echo ($bAddress_data["line2"]) ?>,</span><br>
                                    <span><?php echo ($bAddress_data["city"]) ?>, <?php echo ($bAddress_data["postal_code"]) ?></span><br>
                                    <span>Email: <?php echo ($order_data["email"]) ?></span><br>
                                    <span>Phone: <?php echo ($order_data["mobile"]) ?></span>
                                </div>
                                <div class="bg-white p-4 rounded-4 mb-3">
                                    <div class="mb-2">
                                        <h5>Shipping details</h5>
                                    </div>
                                    <span><?php echo ($order_data["first_name"]) ?> <?php echo ($order_data["last_name"]) ?></span><br>
                                    <?php
                                    $sAddress_rs = Database::search("SELECT * FROM `users_address`  WHERE `users_email` = '" . $order_data['email'] . "' AND `address_type` = '2'");
                                    $sAddress_data = $sAddress_rs->fetch_assoc();
                                    ?>
                                    <span><?php echo ($sAddress_data["line1"]) ?>,</span><br>
                                    <span><?php echo ($sAddress_data["line2"]) ?>,</span><br>
                                    <span><?php echo ($sAddress_data["city"]) ?>, <?php echo ($sAddress_data["postal_code"]) ?></span>
                                </div>
                                <div class="bg-white p-4 rounded-4">
                                    <div class="mb-2">
                                        <h5>Shipping method</h5>
                                    </div>
                                    <span>Standerd Delivery</span>
                                </div>
                            </div>
                            <di class="col-12 col-lg-7 col-md-7 p-2">
                                <div class="bg-white p-4 rounded-4">
                                    <div class="d-flex justify-content-between">
                                        <h5>Order Details</h5>
                                        <h5>Order Date: <?php echo ($order_data["order_date"]) ?></h5>
                                    </div>
                                    <hr class="border-black border-2 my-2">
                                    <div class="table-responsive">
                                        <table class="table align-middle">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Image</th>
                                                    <th scope="col">Book Name</th>
                                                    <th scope="col">Quantity</th>
                                                    <th class="text-end" scope="col">Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $o_has_b_rs = Database::search("SELECT * FROM `order_has_book` INNER JOIN `book` 
                                                ON book.id=order_has_book.book_id INNER JOIN `book_img` 
                                                ON book_img.book_id=book.id WHERE order_has_book.order_order_id='" . $order_id . "'");
                                                $o_has_b_num = $o_has_b_rs->num_rows;

                                                for ($i = 0; $i < $o_has_b_num; $i++) {
                                                    $o_has_b_data = $o_has_b_rs->fetch_assoc();
                                                ?>
                                                    <tr>
                                                        <td><img src="<?php echo ($o_has_b_data["path"]) ?>" alt="book image" height="60px"></td>
                                                        <td><?php echo ($o_has_b_data["book_name"]) ?></td>
                                                        <td class="text-center"><?php echo ($o_has_b_data["order_qty"]) ?></td>
                                                        <th class="text-end text-nowrap">Rs. <?php echo ($o_has_b_data["item_total"]) ?>.00</th>
                                                    </tr>
                                                <?php

                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table align-middle">
                                            <tr class="fs-6">
                                                <th class="w-25 border-0"></th>
                                                <th>Sub Total</th>
                                                <th class="text-end">Rs. <?php echo ($order_data["subtotal"]) ?>.00</th>
                                            </tr>
                                            <tr class="fs-6">
                                                <th class="border-0"></th>
                                                <th>Shipping Cost</th>
                                                <th class="text-end">Rs. <?php echo ($order_data["shipping_cost"]) ?>.00</th>
                                            </tr>
                                            <tr class="fs-5">
                                                <th class="border-0"></th>
                                                <th>Total</th>
                                                <th class="text-end">Rs. <?php echo ($order_data["total_cost"]) ?>.00</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="bg-white p-4 mt-3 rounded-4">
                                    <div class="d-flex justify-content-between">
                                        <h5>Order Note</h5>
                                    </div>
                                    <div style="min-height: 140px;">
                                        <?php echo ($order_data["order_note"]) ?>
                                    </div>
                                </div>
                            </di>
                        </div>
                    </div>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Invoice</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <section class="py-3" id="invoice">
                                        <div class="container-fluid">
                                            <div class="row justify-content-center">
                                                <div class="col-12">
                                                    <div class="row gy-3 mb-3 justify-content-between align-items-center">
                                                        <div class="col-5 col-lg-5">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <h2 class="text-uppercase text-endx m-0">Invoice</h2>
                                                                <?php
                                                                if ($order_data["order_status_id"] == 1) {
                                                                    ?><span class="text-bg-info text-capitalize fs-6 px-3 rounded-2">Payment Pending</span><?php
                                                                } else if ($order_data["order_status_id"] == 2) {
                                                                    ?><span class="text-bg-success text-capitalize fs-6 px-3 rounded-2">Paid</span><?php
                                                                } else if ($order_data["order_status_id"] == 3) {
                                                                    ?><span class="text-bg-primary text-capitalize fs-6 px-3 rounded-2">Refunded</span><?php
                                                                } else if ($order_data["order_status_id"] == 4) {
                                                                    ?><span class="text-bg-success text-capitalize fs-6 px-3 rounded-2">Paid</span><?php
                                                                }else{
                                                                    ?><span class="text-bg-danger text-capitalize fs-6 px-3 rounded-2">Cancelled</span><?php
                                                                }
                                                                
                                                                ?>
                                                            </div>
                                                            <div class="row">
                                                                <span class="col-6">Order ID</span>
                                                                <span class="col-6 text-sm-end">BZ#0<?php echo ($order_data["order_id"]) ?></span>
                                                                <span class="col-6">Invoice Date</span>
                                                                <span class="col-6 text-sm-end"><?php echo ($order_data["order_date"]) ?></span>
                                                                <span class="col-6">Payment</span>
                                                                <span class="col-6 text-sm-end">Card Payment</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-5 text-end">
                                                                <img src="resourses/logo .png" alt="Book Zone Logo" width="135">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row mb-3 justify-content-between">
                                                        <div class="col-12 col-sm-6 col-md-8">
                                                            <div class="mb-2">
                                                                <h5>Bill To</h5>
                                                            </div>
                                                            <span><?php echo ($order_data["first_name"]) ?> <?php echo ($order_data["last_name"]) ?></span><br>
                                                            <?php
                                                            $bAddress_rs = Database::search("SELECT * FROM `users_address`  WHERE `users_email` = '" . $order_data['email'] . "' AND `address_type` = '1'");
                                                            $bAddress_data = $bAddress_rs->fetch_assoc();
                                                            ?>
                                                            <span><?php echo ($bAddress_data["line1"]) ?>, </span>
                                                            <span><?php echo ($bAddress_data["line2"]) ?>,</span><br>
                                                            <span><?php echo ($bAddress_data["city"]) ?>, <?php echo ($bAddress_data["postal_code"]) ?></span><br>
                                                            <span>Email: <?php echo ($order_data["email"]) ?></span><br>
                                                            <span>Phone: <?php echo ($order_data["mobile"]) ?></span>
                                                        </div>
                                                        <div class="col-12 col-sm-5 col-md-4 col-lg-4">
                                                            <div class="mb-2">
                                                                <h5>Ship To</h5>
                                                            </div>
                                                            <span><?php echo ($order_data["first_name"]) ?> <?php echo ($order_data["last_name"]) ?></span><br>
                                                            <?php
                                                            $sAddress_rs = Database::search("SELECT * FROM `users_address`  WHERE `users_email` = '" . $order_data['email'] . "' AND `address_type` = '2'");
                                                            $sAddress_data = $sAddress_rs->fetch_assoc();
                                                            ?>
                                                            <span><?php echo ($sAddress_data["line1"]) ?>,</span><br>
                                                            <span><?php echo ($sAddress_data["line2"]) ?>,</span><br>
                                                            <span><?php echo ($sAddress_data["city"]) ?>, <?php echo ($sAddress_data["postal_code"]) ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <div class="table-responsive">
                                                                <table class="table align-middle">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">Image</th>
                                                                            <th scope="col">Book Name</th>
                                                                            <th scope="col">Quantity</th>
                                                                            <th class="text-end" scope="col">Sub Total</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $o_has_b_rs = Database::search("SELECT * FROM `order_has_book` INNER JOIN `book` 
                                                ON book.id=order_has_book.book_id INNER JOIN `book_img` 
                                                ON book_img.book_id=book.id WHERE order_has_book.order_order_id='" . $order_id . "'");
                                                                        $o_has_b_num = $o_has_b_rs->num_rows;

                                                                        for ($i = 0; $i < $o_has_b_num; $i++) {
                                                                            $o_has_b_data = $o_has_b_rs->fetch_assoc();
                                                                        ?>
                                                                            <tr>
                                                                                <td><img src="<?php echo ($o_has_b_data["path"]) ?>" alt="book image" height="60px"></td>
                                                                                <td><?php echo ($o_has_b_data["book_name"]) ?></td>
                                                                                <td class="text-center"><?php echo ($o_has_b_data["order_qty"]) ?></td>
                                                                                <th class="text-end text-nowrap">Rs. <?php echo ($o_has_b_data["item_total"]) ?>.00</th>
                                                                            </tr>
                                                                        <?php

                                                                        }
                                                                        ?>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table align-middle">
                                                                    <tr class="fs-6">
                                                                        <th class="w-50 border-0"></th>
                                                                        <th>Sub Total</th>
                                                                        <th class="text-end">Rs. <?php echo ($order_data["subtotal"]) ?>.00</th>
                                                                    </tr>
                                                                    <tr class="fs-6">
                                                                        <th class="border-0"></th>
                                                                        <th>Shipping Cost</th>
                                                                        <th class="text-end">Rs. <?php echo ($order_data["shipping_cost"]) ?>.00</th>
                                                                    </tr>
                                                                    <tr class="fs-5">
                                                                        <th class="border-0"></th>
                                                                        <th>Total</th>
                                                                        <th class="text-end">Rs. <?php echo ($order_data["total_cost"]) ?>.00</th>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <!-- <div class="table-responsive">
                                                                    <table class="table table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col" class="text-uppercase">Product</th>
                                                                                <th scope="col" class="text-uppercase text-center">Qty</th>
                                                                                <th scope="col" class="text-uppercase text-end">Unit Price</th>
                                                                                <th scope="col" class="text-uppercase text-end">Amount</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="table-group-divider">
                                                                            <tr>
                                                                                <td>Harry Potter and the Half Blood Prince</td>
                                                                                <td class="text-center">2</td>
                                                                                <td class="text-end">Rs. 75.00</td>
                                                                                <td class="text-end">Rs. 150.00</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="3" class="text-end">Subtotal</td>
                                                                                <td class="text-end">Rs. 362.00</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="3" class="text-end">Shipping</td>
                                                                                <td class="text-end">15</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row" colspan="3" class="text-uppercase text-end">Total</th>
                                                                                <td class="text-end">$495.1</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div> -->
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p>
                                                                <strong>Book Zone</strong><br>
                                                                No.123, Lake View Rd,<br>
                                                                Horana, 12400<br>
                                                                Sri Lanka
                                                            </p>
                                                        </div>
                                                        <div class="col-6 text-end align-content-end">
                                                            <p>
                                                                Phone: +94 786 111 312<br>
                                                                Email: bookzonelk@gmail.com
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="saveInvoice()">Download Invoice</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="script.js"></script>
        <script src="bootstrap.bundle.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    </body>

    </html>

<?php
    // } else {
    //     header("Location: index.php");
    // }
} else {
    header("Location: login.php");
}

?>
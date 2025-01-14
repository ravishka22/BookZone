<?php

session_start();

include "connection.php";

if (isset($_SESSION["u"])) {
    $user_email = $_SESSION["u"]["email"];
    $user_rs = Database::search("SELECT * FROM `users` INNER JOIN `user_type` ON user_type.user_type_id=users.user_type_id 
    WHERE email='$user_email'");
    $user_data = $user_rs->fetch_assoc();
    if ($user_data["user_type_id"] == 1) {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Orders</title>

            <link rel="stylesheet" href="style.css" />
            <link rel="stylesheet" href="bootstrap.css" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
            <link rel="icon" href="resourses/logo.svg" />

        </head>

        <body class="admin-body" onload="loadOrders();">
            <div class="container-fluid bg-light min-vh-100">
                <div class="row">
                    <div class="col-3 d-none d-lg-block">
                        <?php
                        include "admin-sidebar.php";
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
                                        include "admin-offcanvas.php";
                                        ?>
                                    </div>
                                </div>
                                <a class="navbar-brand d-none d-lg-block" href="index.php">
                                    <img src="resourses/logo.svg" alt="Logo" height="50" class="d-inline-block align-text-center">
                                </a>
                                <h2 class="mb-0">Orders</h2>
                            </div>
                            <div class="p-3 d-flex gap-2 align-items-center">
                                <button class="btn btn-primary headerbtn" onclick="window.location.href='add-orders.php'" type="button"><i class="bi bi-plus-circle"></i>&nbsp; Add Orders</button>
                            </div>
                        </div>

                        <div class="admin-content p-4">
                            <div class="d-flex pb-4 flex-lg-row flex-column flex-md-row flex-sm-column justify-content-around gap-4 g-3 overflow-auto">
                                <div class="align-items-center text-center w-100 bg-white p-3 rounded-4">
                                    <lord-icon src="https://cdn.lordicon.com/qnwzeeae.json" trigger="hover" style="width:120px;height:120px">
                                    </lord-icon>
                                    <?php
                                    $pending_order_rs = Database::search("SELECT * FROM `order` INNER JOIN `users` ON users.email=order.users_email INNER JOIN `order_status` ON order.order_status_id=order_status.order_status_id
                            WHERE order.order_status_id='1' AND `user_type_id`='2'");
                                    $pending_order_num = $pending_order_rs->num_rows;
                                    ?>
                                    <h5 class="">Pending</h5>
                                    <h6 class=" text-secondary"><?php if ($pending_order_num == 0) {
                                                                    echo ("No Orders Available");
                                                                } else if ($pending_order_num == 1) {
                                                                    echo ($pending_order_num . " Order Available");
                                                                } else {
                                                                    echo ($pending_order_num . " Orders Available");
                                                                }
                                                                ?></h6>
                                </div>
                                <div class="align-items-center text-center w-100 bg-white p-3 rounded-4">
                                    <lord-icon src="https://cdn.lordicon.com/afixdwmd.json" trigger="hover" state="hover-oscillate-full" style="width:120px;height:120px">
                                    </lord-icon>
                                    <?php
                                    $processing_order_rs = Database::search("SELECT * FROM `order` INNER JOIN `users` ON users.email=order.users_email INNER JOIN `order_status` ON order.order_status_id=order_status.order_status_id
                            WHERE order.order_status_id='2' AND `user_type_id`='2'");
                                    $processing_order_num = $processing_order_rs->num_rows;
                                    ?>
                                    <h5 class="mt-0">Processing</h5>
                                    <h6 class=" text-secondary"><?php if ($processing_order_num == 0) {
                                                                    echo ("No Orders Available");
                                                                } else if ($processing_order_num == 1) {
                                                                    echo ($processing_order_num . " Order Available");
                                                                } else {
                                                                    echo ($processing_order_num . " Orders Available");
                                                                }
                                                                ?></h6>
                                </div>
                                <div class="align-items-center text-center w-100 bg-white p-3 rounded-4">
                                    <lord-icon src="https://cdn.lordicon.com/hsrrkevt.json" trigger="hover" style="width:120px;height:120px">
                                    </lord-icon>
                                    <?php
                                    $completed_order_rs = Database::search("SELECT * FROM `order` INNER JOIN `users` ON users.email=order.users_email INNER JOIN `order_status` ON order.order_status_id=order_status.order_status_id
                            WHERE order.order_status_id='4' AND `user_type_id`='2'");
                                    $completed_order_num = $completed_order_rs->num_rows;
                                    ?>
                                    <h5 class="mt-0">Shipped</h5>
                                    <h6 class=" text-secondary"><?php if ($completed_order_num == 0) {
                                                                    echo ("No Orders Available");
                                                                } else if ($completed_order_num == 1) {
                                                                    echo ($completed_order_num . " Order Available");
                                                                } else {
                                                                    echo ($completed_order_num . " Orders Available");
                                                                }
                                                                ?></h6>
                                </div>
                                <div class="align-items-center text-center w-100 bg-white p-3 rounded-4">
                                    <lord-icon src="https://cdn.lordicon.com/akqsdstj.json" trigger="hover" style="width:120px;height:120px">
                                    </lord-icon>
                                    <?php
                                    $canselled_order_rs = Database::search("SELECT * FROM `order` INNER JOIN `users` ON users.email=order.users_email INNER JOIN `order_status` ON order.order_status_id=order_status.order_status_id
                            WHERE order.order_status_id='5' AND `user_type_id`='2'");
                                    $canselled_order_num = $canselled_order_rs->num_rows;
                                    ?>
                                    <h5 class="mt-0">Canselled</h5>
                                    <h6 class=" text-secondary"><?php if ($canselled_order_num == 0) {
                                                                    echo ("No Orders Available");
                                                                } else if ($canselled_order_num == 1) {
                                                                    echo ($canselled_order_num . " Order Available");
                                                                } else {
                                                                    echo ($canselled_order_num . " Orders Available");
                                                                }
                                                                ?></h6>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="p-4 bg-white align-items-center rounded-4">
                                    <div class="pb-3 d-flex flex-lg-row flex-md-row flex-column justify-content-between align-items-center gap-3">
                                        <div class="d-flex flex-sm-row flex-lg-row flex-md-row flex-row align-items-stretch align-items-lg-center gap-3 w-100">
                                            <div class="d-flex flex-row align-items-center gap-2 w-100">
                                                <select class="form-select border-primary border-2 focus-ring focus-ring-light" id="orderStetusSelector" type="search">
                                                    <option selected value="0">Order Stetus</option>
                                                    <option value="1">Pending</option>
                                                    <option value="2">Processing</option>
                                                    <option value="3">Returned</option>
                                                    <option value="4">Completed</option>
                                                    <option value="5">Cancelled</option>

                                                </select>
                                                <button class="btn btn-primary" onclick="loadOrders();" type="button">Filter</button>
                                            </div>
                                            <div class="d-flex flex-row align-items-stretch gap-2 w-100">
                                                <select class="form-select border-primary  border-2 focus-ring focus-ring-light" id="customerSelector" type="search">
                                                    <option selected value="0">Select Customer</option>
                                                    <?php
                                                    $cus_rs = Database::search("SELECT * FROM `users` WHERE `user_type_id`='2' ORDER BY `first_name` ASC");
                                                    $cus_num = $cus_rs->num_rows;
                                                    for ($i=0; $i < $cus_num; $i++) { 
                                                        $cus_data = $cus_rs->fetch_assoc();
                                                        ?>
                                                        <option value="<?php echo($cus_data["email"])?>"><?php echo($cus_data["first_name"])?> <?php echo($cus_data["last_name"])?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <button class="btn btn-primary" onclick="loadOrders();" type="button">Filter</button>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center gap-2 w-100">
                                            <input class="form-control focus-ring focus-ring-light" type="search" placeholder="Search With Order Id Here" id="ordersSearch">
                                            <button class="btn btn-primary" onclick="loadOrders();" type="button">Search</button>
                                        </div>

                                    </div>
                                    <div class="row">

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-wrap table-responsive">
                                                <table class="table align-middle">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <!-- &nbsp; -->
                                                            <th scope="col">Order ID</th>
                                                            <th scope="col">Customer</th>
                                                            <th scope="col">Order Date</th>
                                                            <th scope="col">Stetus</th>
                                                            <th scope="col">Ship to</th>
                                                            <th scope="col">Total</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="ordersTable">
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="script.js"></script>
            <script src="bootstrap.bundle.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        </body>

        </html>

<?php
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: login.php");
}

?>
<?php
session_start();
require "connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>

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
                include "user-sidebar.php";
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
                                include "user-offcanvas.php";
                                ?>
                            </div>
                        </div>
                        <a class="navbar-brand d-none d-lg-block" href="index.php">
                            <img src="resourses/logo2.svg" alt="Logo" height="50" class="d-inline-block align-text-center">
                        </a>

                    </div>
                    <div class="p-3 d-flex gap-2 align-items-center">
                        <h2 class="fw-semibold mt-2"><i class="bi bi-cart3"></i>&nbsp;My Orders</h2>
                    </div>

                </div>

                <?php

                $user_email = $_SESSION["u"]["email"];

                ?>

                <!-- Content -->
                <div class="accountSettings px-4" id="accsettingsbody">
                    <div class="row mt-4 mb-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb fs-5 fw-normal ">
                                <li class="breadcrumb-item text-secondary">My Account</li>
                                <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">My Orders</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="d-flex pb-4 flex-lg-row flex-column flex-md-row flex-sm-column justify-content-around gap-4 g-3 overflow-auto">
                        <div class="align-items-center text-center w-100 bg-white p-3 rounded-4">
                            <lord-icon src="https://cdn.lordicon.com/qnwzeeae.json" trigger="hover" style="width:120px;height:120px">
                            </lord-icon>
                            <?php
                            $pending_order_rs = Database::search("SELECT * FROM `order` INNER JOIN `order_status` ON order.order_status_id=order_status.order_status_id
                            WHERE `users_email`='$user_email' AND order.order_status_id='1'");
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
                            $processing_order_rs = Database::search("SELECT * FROM `order` INNER JOIN `order_status` ON order.order_status_id=order_status.order_status_id
                            WHERE `users_email`='$user_email' AND order.order_status_id='2'");
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
                            $completed_order_rs = Database::search("SELECT * FROM `order` INNER JOIN `order_status` ON order.order_status_id=order_status.order_status_id
                            WHERE `users_email`='$user_email' AND order.order_status_id='4'");
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
                            $canselled_order_rs = Database::search("SELECT * FROM `order` INNER JOIN `order_status` ON order.order_status_id=order_status.order_status_id
                            WHERE `users_email`='$user_email' AND order.order_status_id='5'");
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

                    <div class="row mb-4 mx-1">
                        <div class="p-4 bg-white align-items-center rounded-4">
                            <div class="pb-3">
                                <h5 class="text-secondary">Orders</h5>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-wrap table-responsive">
                                        <table class="table align-middle">
                                            <thead>
                                                <tr class="text-center">
                                                    <!-- &nbsp; -->
                                                    <th class="text-start" scope="col">Order ID</th>
                                                    <!-- <th scope="col">Ordered Books</th> -->
                                                    <th scope="col">Order Date</th>
                                                    <th class="text-start" scope="col">Total Amount</th>
                                                    <th scope="col">Stetus</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="myOrdersTable">
                                                <?php


                                                $order_rs = Database::search("SELECT * FROM `order` INNER JOIN `order_status` ON order.order_status_id=order_status.order_status_id
                                                                                WHERE `users_email`='$user_email' ORDER BY `order_id` DESC");
                                                $order_num = $order_rs->num_rows;

                                                for ($i = 0; $i < $order_num; $i++) {
                                                    $order_data = $order_rs->fetch_assoc();

                                                    $book_rs = Database::search("SELECT * FROM `users` INNER JOIN `order_has_book` ON users.email=order_has_book.book_id 
                                                                                WHERE `email`='$user_email'");
                                                    $book_num = $book_rs->num_rows;
                                                    $book_data = $book_rs->fetch_assoc();

                                                    $order_id = $order_data["order_id"];
                                                ?>

                                                    <tr class="text-center text-nowrap">
                                                        <th class="text-start" scope="row">BZ#0<?php echo ($order_data["order_id"]) ?></th>
                                                        <!-- <td></td> -->
                                                        <td><?php echo ($order_data["order_date"]) ?></td>
                                                        <!-- <td class="text-center">01</td> -->
                                                        <td class="text-start">Rs. <?php echo ($order_data["total_cost"]) ?>.00</td>
                                                        <td><span class="badge rounded-pill px-3 py-2 fs-6 fw-normal text-bg-<?php
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
                                                                                                                                ?>"><?php echo ($order_data["order_status"]) ?></span></td>
                                                        <td class="text-center">
                                                            <?php
                                                            if ($order_data["order_status"] == "Pending") {
                                                                $_SESSION["oid"] = $order_id;
                                                            ?>
                                                                <button onclick="window.location.href = 'paymentProcess.php'" class="btn btn-sm btn-primary">Pay Now</button>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <button class="btn btn-sm btn-secondary" onclick="window.location.href = 'singleOrder.php?order_id=<?php echo $order_data['order_id']; ?>'">View Order</button>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php

                                                }

                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <?php
                // } else {
                //     header("Location: login.php");
                // }
                ?>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <script src="bootstrap.bundle.js"></script>

</body>

</html>
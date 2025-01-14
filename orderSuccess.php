<?php
session_start();
require "connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>

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
                        <h2 class="fw-semibold mt-2"><i class="bi bi-person-circle"></i></i>&nbsp;My Orders</h2>
                    </div>

                </div>

                <?php

                if (isset($_SESSION["u"])) {

                    $email = $_SESSION["u"]["email"];
                    $user_name = $_SESSION['u']["first_name"];
                    $order_id = $_SESSION['oid'];

                ?>

                    <!-- Content -->
                    <div class="container" >
                        <div class="row text-center justify-content-center">
                            <div class="col-sm-6 col-sm-offset-3">
                                <br><br>
                                <h2 class="text-success">Payment Success</h2>
                                <lord-icon src="https://cdn.lordicon.com/oqdmuxru.json" trigger="in" delay="0" state="in-check" colors="primary:#30e849" style="width:200px;height:200px">
                                </lord-icon>
                                <h3>Dear, <?php echo $user_name; ?></h3>
                                <p class="fs-5 text-secondary">Thank you for your order! It has been placed successfully. We'll keep you updated on shipping.</p>
                                <a onclick="updateOrderStatus(2,<?php echo ($order_id) ?>);" class="btn btn-success">View My Orders</a>
                                <br><br>
                            </div>

                        </div>
                    </div>

                <?php
                } else {
                    header("Location: login.php");
                }
                ?>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <script src="bootstrap.bundle.js"></script>

</body>

</html>
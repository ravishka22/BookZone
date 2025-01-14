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

<body class="admin-body" onload="loadDistricts();">
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
                        <h2 class="fw-semibold mt-2"><i class="bi bi-person-circle"></i></i>&nbsp;My Account</h2>
                    </div>

                </div>

                <?php

                if (isset($_SESSION["u"])) {

                    $email = $_SESSION["u"]["email"];
                ?>

                    <!-- Content -->
                    <div class="accountSettings px-4" id="accsettingsbody">
                        <div class="row mt-4 mb-2">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb fs-5 fw-normal ">
                                    <li class="breadcrumb-item active text-dark fw-semibold">My Account</li>
                                </ol>
                            </nav>
                        </div>

                        <div class="d-flex pb-4 flex-lg-row flex-column flex-md-row flex-sm-column justify-content-around gap-4 g-3 overflow-auto">
                            <div class="align-items-center text-center w-100 bg-white p-3 rounded-4">
                                <lord-icon src="https://cdn.lordicon.com/qnwzeeae.json" trigger="hover" style="width:120px;height:120px">
                                </lord-icon>
                                <h5 class="">Unpaid</h5>
                                <h6 class=" text-secondary">No Orders Available</h6>
                            </div>
                            <div class="align-items-center text-center w-100 bg-white p-3 rounded-4">
                                <lord-icon src="https://cdn.lordicon.com/lwumwgrp.json" trigger="hover" state="hover-oscillate-full" style="width:120px;height:120px">
                                </lord-icon>
                                <h5 class="mt-0">To be shipped</h5>
                                <h6 class=" text-secondary">No Orders Available</h6>
                            </div>
                            <div class="align-items-center text-center w-100 bg-white p-3 rounded-4">
                                <lord-icon src="https://cdn.lordicon.com/hsrrkevt.json" trigger="hover" style="width:120px;height:120px">
                                </lord-icon>
                                <h5 class="mt-0">Shipped</h5>
                                <h6 class=" text-secondary">No Orders Available</h6>
                            </div>
                            <div class="align-items-center text-center w-100 bg-white p-3 rounded-4">
                                <lord-icon src="https://cdn.lordicon.com/xjronrda.json" trigger="hover" style="width:120px;height:120px">
                                </lord-icon>
                                <h5 class="mt-0">Completed</h5>
                                <h6 class=" text-secondary">No Orders Available</h6>
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
                                                        <th scope="col">Order ID</th>
                                                        <th scope="col">Ordered Books</th>
                                                        <th scope="col">Order Date</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Total</th>
                                                        <th scope="col">Stetus</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center">
                                                        <th scope="row">01</th>
                                                        <td><button class="btn btn-sm btn-primary">View</button></td>
                                                        <td>10.03.2024</td>
                                                        <td class="text-center">01</td>
                                                        <td>Rs.100.00</td>
                                                        <td><span class="badge rounded-pill px-3 py-2 fs-6 fw-normal text-bg-success">Completed</span></td>
                                                        <td class="text-center"><button class="btn btn-sm btn-primary">View</button></td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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
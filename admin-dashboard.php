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
            <title>Dashboard</title>

            <link rel="stylesheet" href="style.css" />
            <link rel="stylesheet" href="bootstrap.css" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
            <link rel="icon" href="resourses/logo.svg" />

        </head>

        <body class="admin-body" onload="loadDashboard();">
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
                                <h2 class="mb-0">Dashboard</h2>
                            </div>
                            <div class="p-3 d-flex gap-2 align-items-center">
                                <button class="btn btn-danger headerbtn" onclick="signout();" type="button"><i class="bi bi-door-open"></i>&nbsp;Logout</button>
                            </div>
                        </div>

                        <div class="admin-content p-4">
                            <div class="row mb-4 gap-3">
                                <div class="p-4 bg-white align-items-center rounded-4">
                                    <div class="row">
                                        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">
                                            <div class="align-items-center text-center w-100 bg-light p-3 rounded-4">
                                                <lord-icon src="https://cdn.lordicon.com/qwjfapmb.json" trigger="hover" style="width:120px;height:120px">
                                                </lord-icon>
                                                <h5 class="">99 Books</h5>
                                                <h6 class=" text-secondary">Currently In Stock</h6>
                                            </div>
                                            <div class="align-items-center text-center w-100 bg-light p-3 rounded-4">
                                                <lord-icon src="https://cdn.lordicon.com/zfmcashd.json" trigger="hover" style="width:120px;height:120px">
                                                </lord-icon>
                                                <h5 class="">5 Customers</h5>
                                                <h6 class=" text-secondary">Active In Book Zone</h6>
                                            </div>
                                            <div class="align-items-center text-center w-100 bg-light p-3 rounded-4">
                                                <lord-icon src="https://cdn.lordicon.com/cosvjkbu.json" trigger="hover" style="width:120px;height:120px">
                                                </lord-icon>
                                                <h5 class="">2 Orders</h5>
                                                <h6 class=" text-secondary">Currently In Processing</h6>
                                            </div>
                                            <div class="align-items-center text-center w-100 bg-light p-3 rounded-4">
                                                <lord-icon src="https://cdn.lordicon.com/qnwzeeae.json" trigger="hover" style="width:120px;height:120px">
                                                </lord-icon>
                                                <h5 class="">Unpaid</h5>
                                                <h6 class=" text-secondary">No Books in Wisthlist</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="rounded-4 p-0">
                                    <div class="row p-0">
                                        <div class="d-flex flex-column flex-md-row flex-lg-row gap-3">
                                            <div class="w-100 bg-white  rounded-4 p-3">
                                                <div class="pt-3 ps-3">
                                                    <h5 class="">Sales | BookZone</h5>
                                                </div>
                                                <div class="chart" id="chart"></div>
                                            </div>

                                            <div class="w-100 bg-white  rounded-4 p-3">
                                                <div class="pt-3 ps-3">
                                                    <h5 class="">Sales | BookZone</h5>
                                                </div>
                                                <div class="chart2" id="chart"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <!-- <div class="p-4 bg-white align-items-center rounded-4">
                            <div class="pb-3 d-flex flex-lg-row flex-md-row flex-column justify-content-between align-items-center gap-3">
                                <div class="d-flex flex-sm-row flex-lg-row flex-md-row flex-row align-items-stretch align-items-lg-center gap-3 w-100">
                                    <div class="d-flex flex-row align-items-center gap-2 w-100">
                                        <select class="form-select border-primary border-2 focus-ring focus-ring-light" type="search">
                                            <option selected>Bulk Actions</option>
                                            <option value="1">Delete</option>
                                        </select>
                                        <button class="btn btn-primary" type="submit">Apply</button>
                                    </div>
                                    <div class="d-flex flex-row align-items-stretch gap-2 w-100">
                                        <select class="form-select border-primary  border-2 focus-ring focus-ring-light" type="search">
                                            <option selected>Change Stetus</option>
                                            <option value="1">Active</option>
                                            <option value="2">Inactive</option>
                                        </select>
                                        <button class="btn btn-primary" type="submit">Apply</button>
                                    </div>
                                </div>
                                <div class="d-flex flex-row align-items-center gap-2 w-100">
                                    <input class="form-control focus-ring focus-ring-light" type="search" name="" id="">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>

                            </div>
                            <div class="row">

                            </div>
                            
                        </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
            <script src="script.js"></script>
            <script src="bootstrap.bundle.js"></script>

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
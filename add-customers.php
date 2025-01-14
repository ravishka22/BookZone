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
    <title>Customers</title>

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="icon" href="resourses/logo.svg" />

</head>

<body class="admin-body" onload="loadAddCustomers();">
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
                        <h2 class="mb-0">Add User</h2>
                    </div>
                    <div class="p-3 d-flex gap-2 align-items-center">
                        <button class="btn btn-primary headerbtn" onclick="window.location.href='customers.php'" type="button"><i class="bi bi-person-lines-fill"></i>&nbsp; View Customers</button>
                    </div>
                </div>

                <div class="admin-content p-4">
                    <div class="accountSettings" id="accsettingsbody">

                        <div class="row bg-white rounded-4 mb-4">
                            <div class="p-4 pb-0">
                                <div class="row">
                                    <h5 class="text-secondary">Account Details</h5>
                                </div>
                                <div class="row mt-3">
                                    <!-- <div class="d-flex flex-row gap-2">
                                        <img src="resourses/default_propic.jpg" alt="Logo" height="150px" width="150px" class="rounded-4" id="propic">
                                        <div class="p-2 d-flex flex-column">
                                            <div class="d-flex flex-row my-auto gap-2 mb-2">
                                                <div class="file btn btn-lg btn-primary" onclick="changeProfileImage();">
                                                    Upload Photo
                                                    <input type="file" name="file" id="propicuploader" />
                                                </div>
                                                <button class="btn btn-dark btn-lg" type="button" onclick="resetImageSelection2();">
                                                <i class="bi bi-arrow-counterclockwise  d-flex d-sm-none d-md-none d-lg-none"></i><span class="d-none d-md-flex d-sm-flex">Reset</span>
                                                </button>
                                            </div>
                                            <div class="my-auto d-flex flex-row">
                                                <h6 class="fs-6 text-secondary">Allowed JPG, GIF or PNG. Max size of 1MB 1:1 Ratio</h6>
                                            </div>
                                        </div>
                                    </div> -->

                                </div>
                            </div>
                            <div class="p-4 row gap-2">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3 w-100">
                                            <input type="text" class="form-control" placeholder="" id="customer-fname">
                                            <label for="customer-fname">First name</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" placeholder="" id="customer-lname">
                                            <label for="customer-lname">Last name</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" placeholder="" id="customer-email">
                                            <label for="customer-email">E-mail</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="phone" class="form-control" placeholder="" id="customer-phone">
                                            <label for="customer-phone">Phone Number</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control" placeholder="" id="customer-bday">
                                            <label for="customer-bday">Birthday</label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="customer-gender" placeholder="" aria-label="Gender">
                                                <option selected value="0">Select Gender</option>
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                            </select>
                                            <label for="customer-gender">Gender</label>
                                        </div>
                                    </div>

                                </div>
                                
                                <div class="d-flex flex-row my-auto gap-3 mb-2">
                                    <button class="btn btn-primary" onclick="addCustomerDetails();" type="button">
                                        Save Changes
                                    </button>
                                    <button class="btn btn-dark" type="button">
                                        Cancle
                                    </button>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
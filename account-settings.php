<?php
session_start();
require "connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Details</title>

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
                        <h2 class="fw-semibold mt-2"><i class="bi bi-gear"></i>&nbsp;Account Settings</h2>
                    </div>

                </div>

                <?php

                if (isset($_SESSION["u"])) {

                    $email = $_SESSION["u"]["email"];

                    $details_rs = Database::search("SELECT * FROM `users` INNER JOIN `gender` ON 
                                                users.gender_id=gender.id INNER JOIN `user_type` ON users.user_type_id=user_type.user_type_id WHERE `email`='" . $email . "'");

                    $image_rs = Database::search("SELECT * FROM `profile_img` WHERE `users_email`='" . $email . "'");

                    $address_rs = Database::search("SELECT * FROM `users_address` INNER JOIN 
                                                `district` ON users_address.district_district_id=district.district_id 
                                                INNER JOIN `province` ON 
                                                district.province_id=province.province_id 
                                                WHERE `users_email`='" . $email . "' AND `address_type`='1'");
                    $address_num = $address_rs->num_rows;

                    $details_data = $details_rs->fetch_assoc();
                    $image_data = $image_rs->fetch_assoc();

                    $address_data = $address_rs->fetch_assoc();

                    
                    if ($address_num > 0) {
                        $line1 = $address_data["line1"];
                        $line2 = $address_data["line2"];
                        $city = $address_data["city"];
                        $pcode = $address_data["postal_code"];
                    }else{
                        $line1 = "";
                        $line2 = "";
                        $city = "";
                        $pcode = "";
                    }

                ?>

                    <!-- Content -->
                    <div class="accountSettings px-4" id="accsettingsbody">
                        <div class="row mt-4 mb-2">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb fs-5 fw-normal ">
                                    <li class="breadcrumb-item text-secondary">My Account</li>
                                    <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Account Settings</li>
                                </ol>
                            </nav>
                        </div>

                        <div class="row bg-white rounded-4 mb-4">
                            <div class="p-4 border-bottom border-1">
                                <div class="row">
                                    <h5 class="text-secondary">Account Details</h5>
                                </div>
                                <div class="row mt-3">
                                    <div class="d-flex flex-row gap-2">
                                        <img src="<?php echo $image_data["path"] ?>" alt="Logo" height="150px" width="150px" class="rounded-4" id="propic">
                                        <div class="p-2 d-flex flex-column">
                                            <div class="d-flex flex-row my-auto gap-2 mb-2">
                                                <div class="file btn btn-lg btn-primary" onclick="changeProfileImage();">
                                                    Upload Photo
                                                    <input type="file" name="file" id="propicuploader" />
                                                </div>
                                                <button class="btn btn-dark text-white btn-lg" type="button" onclick="resetImageSelection();">
                                                    <i class="bi bi-arrow-clockwise d-block d-sm-none d-md-none d-lg-none"></i><span class="d-none d-md-block d-sm-block">Reset</span>
                                                </button>
                                            </div>
                                            <div class="my-auto d-flex flex-row">
                                                <h6 class="fs-6 text-secondary">Allowed JPG, SVG or PNG. Please use 1:1 sized image </h6>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="p-4 row gap-2">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="asfname" value="<?php echo $details_data["first_name"]; ?>">
                                            <label for="asfname">First name</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="aslname" value="<?php echo $details_data["last_name"]; ?>">
                                            <label for="aslname">Last name</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="email" disabled class="form-control" id="asemail" value="<?php echo $details_data["email"]; ?>">
                                            <label for="asemail">E-mail</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="phone" class="form-control" id="asphone" value="<?php echo $details_data["mobile"]; ?>">
                                            <label for="asphone">Phone Number</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <?php
                                        if (empty($details_data["birthday"])) {
                                        ?>
                                            <div class="form-floating mb-3">
                                                <input type="date" class="form-control" id="asbday" placeholder="John">
                                                <label for="asbday">Birthday</label>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="form-floating mb-3">
                                                <input type="date" class="form-control" id="asbday" readonly value="<?php echo $details_data["birthday"]; ?>">
                                                <label for="asbday">Birthday</label>
                                            </div>
                                        <?php
                                        }

                                        ?>

                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <?php
                                        if (empty($details_data["gender"])) {
                                        ?>
                                            <div class="form-floating">
                                                <select class="form-select" id="asgender" aria-label="Gender">
                                                    <option selected value="0">Select Gender</option>
                                                    <option value="1">Male</option>
                                                    <option value="2">Female</option>
                                                </select>
                                                <label for="asgender">Gender</label>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="asgender" readonly value="<?php echo $details_data["gender"]; ?>">
                                                <label for="asgender">Gender</label>
                                            </div>
                                        <?php
                                        }

                                        ?>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="asregdate" readonly value="<?php echo $details_data["joined_date"]; ?>">
                                            <label for="fname">Registered Date</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="asacctype" readonly value="<?php echo $details_data["user_type"]; ?>">
                                            <label for="lname">Account Type</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row my-auto gap-3 mb-2">
                                    <button class="btn btn-primary" onclick="updateAccountDetails();" type="button">
                                        Save Changes
                                    </button>
                                    <button class="btn btn-dark" onclick="window.location.reload();" type="button">
                                        Cancle
                                    </button>
                                </div>


                            </div>
                        </div>

                        <div class="row bg-white rounded-4 mt-4 py-4 gap-4">
                            <div class="px-4">
                                <div class="row">
                                    <h5 class="text-secondary">Address Details</h5>
                                </div>
                            </div>

                            <div class="px-4 row gap-2">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" value="<?php echo ($line1) ?>" id="aline1" placeholder="">
                                            <label for="aline1">Address Line 01</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" value="<?php echo ($line2) ?>" id="aline2" placeholder="">
                                            <label for="aline2">Address Line 02</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <select class="form-control" name="province" id="province" onchange="loadDistricts(province);">
                                                <option value="0">Select Province</option>
                                                <?php
                                                $user_province = $address_data["province_id"];
                                                $province_rs = Database::search("SELECT * FROM `province`");
                                                $province_num = $province_rs->num_rows;
                                                for ($i = 0; $i < $province_num; $i++) {
                                                    $province_data = $province_rs->fetch_assoc();
                                                ?>
                                                    <option <?php if ($province_data["province_id"] == $user_province) {
                                                            ?>selected<?php
                                                                    } ?> value="<?php echo $province_data["province_id"]; ?>"><?php echo $province_data["province_name"]; ?></option>
                                                <?php
                                                }

                                                ?>
                                            </select>
                                            <label for="fname">Province</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <select class="form-control" name="district" id="district">
                                                <option value="0">Select District</option>
                                            </select>
                                            <label for="district">District</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" value="<?php echo ($city) ?>" id="city" placeholder="">
                                            <label for="city">City</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" value="<?php echo ($pcode) ?>" id="pcode" placeholder="">
                                            <label for="pcode">Postal Code</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row my-auto gap-3 mb-2">
                                    <button class="btn btn-primary" onclick="saveAddress();" type="button">
                                        Save Address
                                    </button>
                                    <button class="btn btn-dark" onclick="window.location.reload();" type="button">
                                        Cancle
                                    </button>
                                </div>


                            </div>
                        </div>

                        <div class="row bg-white rounded-4 mt-4 py-4 gap-4">
                            <div class="px-4">
                                <div class="row">
                                    <h5 class="text-secondary">Authentications</h5>
                                </div>
                            </div>
                            <div class="px-4 row gap-2">

                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-1">
                                            <input type="password" class="form-control" id="password1" placeholder="">
                                            <label for="password1">New Password</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-floating mb-1">
                                            <input type="password" class="form-control" id="password2" placeholder="">
                                            <label for="password2">Confirm Password</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <input type="checkbox" id="spcheck" class="form-check-input" onchange="showPassword2();">
                                    <label for="spcheck " class="form-check-label">Show Password</label>
                                </div>
                                <div class="d-flex flex-row my-auto gap-3 mb-2">
                                    <button class="btn btn-primary" onclick="updatePassword();" type="button">
                                        Update Password
                                    </button>
                                    <button class="btn btn-dark" onclick="window.location.reload();" type="button">
                                        Cancle
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row bg-white rounded-4 mt-4 p-4 gap-3">
                            <div class="p-0">
                                <div class="row p-0">
                                    <h5 class="text-secondary">Delete Account</h5>
                                </div>
                            </div>
                            <div class="row gap-3">
                                <div class="row gap-3">
                                    <div class="bg-warning text-warning-emphasis p-3 rounded-3 pb-2 fs-5 mb-2">
                                        <h6>
                                            Are you sure you want to delete your account?<Br>
                                            Once you delete your account, there is no going back. Please be certain.
                                        </h6>
                                    </div>
                                    <div class="mb-2 form-check">
                                        <input type="checkbox" class="form-check-input" id="deleteAccount">
                                        <label class="form-check-label" for="deleteAccount">I confirm my account deactivation</label>
                                    </div>
                                </div>
                                <div class="d-flex flex-row my-auto gap-3 mb-2 p-0">
                                    <button class="btn btn-danger" onclick="deactivateAccount();" type="button">
                                        Deactivate Account
                                    </button>
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
<?php
session_start();
require "connection.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Account</title>

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="resourses/logo.svg" />

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 py-3 px-4 px-lg-5 bg-light min-vh-100">
                <!-- Header -->
                <div class="topheader">
                    <div class="row bg-white rounded-4 p-3">
                        <div class="col-6 text-start">
                            <a href="index.php">
                                <img src="resourses/logo2.svg" alt="Logo" height="50" class="d-none d-sm-none d-md-flex d-lg-flex">
                                <img src="resourses/logo.svg" alt="Logo" height="60" class="d-flex d-sm-flex d-md-none d-lg-none">
                            </a>
                        </div>
                        <div class="col-6 justify-content-end d-flex flex-row align-items-center gap-2">
                            <h3 class="w-auto mt-2">Update Customer</h3>
                        </div>
                    </div>

                </div>
                <!-- Header -->

                <!-- Content -->
                <div class="accountSettings d-block" id="accsettingsbody">
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
                                    <img src="resourses/default_propic.jpg" alt="Logo" height="150px" width="150px" class="rounded-4" id="propic">
                                    <div class="p-2 d-flex flex-column">
                                        <div class="d-flex flex-row my-auto gap-3 mb-2">
                                            <div class="file btn btn-lg btn-primary" onclick="changeProfileImage();">
                                                Upload New Photo
                                                <input type="file" name="file" id="propicuploader" />
                                            </div>
                                            <button class="btn btn-dark btn-lg" type="button" onclick="resetImageSelection();">
                                                <i class="fa-solid fa-arrows-rotate d-flex d-sm-none d-md-none d-lg-none"></i><span class="d-none d-md-flex d-sm-flex">Reset</span>
                                            </button>
                                        </div>
                                        <div class="my-auto d-flex flex-row">
                                            <h6 class="fs-6 text-secondary">Allowed JPG, GIF or PNG. Max size of 800K</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="p-4 row gap-2">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="asfname" placeholder="John">
                                        <label for="fname">First name</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="aslname" placeholder="Smith">
                                        <label for="lname">Last name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="asemail" placeholder="John">
                                        <label for="fname">E-mail</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="phone" class="form-control" id="asphone" placeholder="Smith">
                                        <label for="lname">Phone Number</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="asbday" placeholder="John">
                                        <label for="fname">Birthday</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="asgender" aria-label="Gender">
                                            <option selected>Select Gender</option>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                        </select>
                                        <label for="asgender">Gender</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="asregdate" placeholder="John">
                                        <label for="fname">Registered Date</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="asacctype" placeholder="Smith">
                                        <label for="lname">Account Type</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row my-auto gap-3 mb-2">
                                <button class="btn btn-primary" onclick="updateAccountDetails();" type="button">
                                    Save Changes
                                </button>
                                <button class="btn btn-dark" type="button">
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
                                        <input type="text" class="form-control" id="fname" placeholder="John">
                                        <label for="fname">Address Line One</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="lname" placeholder="Smith">
                                        <label for="lname">Address Line Two</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="fname" placeholder="John">
                                        <label for="fname">Province</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="lname" placeholder="Smith">
                                        <label for="lname">District</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="fname" placeholder="John">
                                        <label for="fname">City</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="lname" placeholder="Smith">
                                        <label for="lname">Postal Code</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row my-auto gap-3 mb-2">
                                <button class="btn btn-primary" type="button">
                                    Save Changes
                                </button>
                                <button class="btn btn-dark" type="button">
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
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="fname" placeholder="John">
                                        <label for="fname">New Password</label>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="lname" placeholder="Smith">
                                        <label for="lname">Confirm Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row my-auto gap-3 mb-2">
                                <button class="btn btn-primary" type="button">
                                    Update Password
                                </button>
                                <button class="btn btn-dark" type="button">
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
                                    <input type="checkbox" value="" class="form-check-input" onclick="deleteAccount();" id="deleteAccount">
                                    <label class="form-check-label" for="deleteAccount">I confirm my account deactivation</label>
                                </div>
                            </div>
                            <div class="d-flex flex-row my-auto gap-3 mb-2 p-0">
                                <button class="btn btn-danger" type="button">
                                    Deactivate Account
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
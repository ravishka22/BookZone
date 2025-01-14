<?php

session_start();

require "connection.php";

if (isset($_SESSION["u"])) {
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Zone | User Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="icon" href="resourses/logo.svg" />

</head>

<body onload="changeView();">
    <?php
    include "header.php";
    ?>
    <div class="container align-items-center py-5 px-5">
        <div class="row justify-content-center align-content-center  h-auto">
            <!-- <div class="col-12 col-md-6 col-lg-6">
                <img src="resourses/logo.svg" alt="BookZone">
            </div> -->

            <div class="col-12 col-lg-6 col-md-8 align-content-center justify-content-center bg-light px-4 py-4 rounded-3">

                <!--Login-->
                <div class="col-12" id="SignInBox">
                    <h2 class="mb-4">Log in</h2>
                    <div class="col-12 d-none mb-3" id="msgdiv2">
                        <div class="alert alert-danger" role="alert" id="msg2">

                        </div>
                    </div>

                    <form>

                        <?php
                        $email = "";
                        $password = "";

                        if (isset($_COOKIE["email"])) {
                            $email = $_COOKIE["email"];
                        }

                        if (isset($_COOKIE["password"])) {
                            $password = $_COOKIE["password"];
                        }
                        ?>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email2" value="<?php echo $email; ?>" placeholder="name@example.com">
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password2" value="<?php echo $password; ?>" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class=" row">
                            <div class=" col-6">
                                <div class="mb-3 form-check">
                                    <input type="checkbox" value="" class="form-check-input" id="rememberme">
                                    <label class="form-check-label" for="rememberme">Remember me</label>
                                </div>
                            </div>
                            <div class=" col-6 text-end">
                                <div class="mb-3 form-check">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#enterEmailModal" class="ml-auto mb-0 text-sm link-opacity-100-hover">Forgot Password?</a>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary btn-lg col-12" onclick="signin();">Login</button>

                        <div class="row text-center mt-4">
                            <p>Don't have an account? <a href="#" onclick="ChangeView();" class="text-reset">Register here</a></p>

                        </div>

                        <!--FP Modal 1-->
                        <div class="modal fade" data-bs-keyboard="false" tabindex="-1" id="enterEmailModal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Forgot Password?</h1>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body bg-light">
                                        <div class="col-12 d-none mb-3" id="msgdiv1">
                                            <div class="alert alert-danger" role="alert" id="msg1">

                                            </div>
                                        </div>
                                        <form>
                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control" id="email3" placeholder="name@example.com">
                                                <label for="email3">Email address</label>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-primary" onclick="forgotPassword();">Get Code</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--FP Modal 1-->

                        <!--FP Modal 2-->
                        <div class="modal fade" data-bs-keyboard="false" tabindex="-1" id="forgotPasswordModal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Enter new Password</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body bg-light">
                                        <div class="col-12 d-none mb-3" id="msgdiv2">
                                            <div class="alert alert-danger" role="alert" id="msg2">

                                            </div>
                                        </div>
                                        <form>
                                            <div class="form-floating mb-3">
                                                <input type="password" class="form-control" id="np" placeholder="New Password">
                                                <label for="np">New Password</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="password" class="form-control" id="rnp" placeholder="Retype New Password">
                                                <label for="rnp">Retype New Password</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="vc" placeholder="Verifiction Code">
                                                <label for="vc">Verifiction Code</label>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" onclick="resetPassword();">Reset Password</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--FP Modal 2-->

                    </form>
                </div>
                <!--Login-->

                <!--Register-->
                <div class="col-12 d-none" id="SignUpBox">
                    <h2 class="mb-3">Register</h2>
                    <div class="col-12 d-none mb-3" id="msgdiv">
                        <div class="alert alert-danger" role="alert" id="msg">

                        </div>
                    </div>
                    <form>
                        <div class="row">
                            <div class=" col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="fname" placeholder="John">
                                    <label for="fname">First name</label>
                                </div>
                            </div>
                            <div class=" col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="lname" placeholder="Smith">
                                    <label for="lname">Last name</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" placeholder="name@example.com">
                            <label for="email">Email address</label>
                        </div>
                        <div class="row">
                            <div class=" col-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="mobile" placeholder="0771234567">
                                    <label for="mobile">Mobile number</label>
                                </div>
                            </div>
                            <div class=" col-6">
                                <div class="form-floating mb-3">
                                    <select class="form-control" name="" id="gender">
                                        <option value="0">Select Gender</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                    <label for="gender">Gender</label>
                                </div>
                            </div>
                        </div>


                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" placeholder="Password">
                            <label for="password">Password</label>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" value="" class="form-check-input" onclick="showPassword();" id="showpassword">
                            <label class="form-check-label" for="showpassword">Show Password</label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg col-12" onclick="signUp();">Sign Up</button>
                        <div class="row text-center mt-4">
                            <p>Already have an Account? <a href="#" onclick="ChangeView();" class="text-reset">login here</a></p>
                        </div>

                    </form>
                </div>
                <!--Register-->

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>


</body>

</html>
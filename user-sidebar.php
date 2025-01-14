<?php
// session_start();
// require "connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body class="">
    <?php

    if (isset($_SESSION["u"])) {

        $email = $_SESSION["u"]["email"];

        $details_rs = Database::search("SELECT * FROM `users` INNER JOIN `gender` ON 
                                    users.gender_id=gender.id INNER JOIN `user_type` ON users.user_type_id=user_type.user_type_id WHERE `email`='" . $email . "'");

        $image_rs = Database::search("SELECT * FROM `profile_img` WHERE `users_email`='" . $email . "'");

        $details_data = $details_rs->fetch_assoc();
        $image_data = $image_rs->fetch_assoc();

    ?>
        <div class="user-sidebar">
            <div class="user-sidebar bg-white p-3 fixed-top col-lg-3 vh-100">
                <div class="">
                    <div class="bg-primary align-items-center text-center p-2 text-white mb-2 rounded-3">
                        <h5 class="fw-bold my-2 fs-5"><i class="bi bi-speedometer2"></i>&nbsp; My Account</h5>
                    </div>

                    <div class="align-items-center text-center p-2 mb-3">
                        <img src="<?php echo $image_data["path"]; ?>" alt="Profile Pic" id="propic3" height="120px" width="120px" class="rounded-circle my-2">
                        <h5 class="w-auto mt-2 mb-0"><?php echo $details_data["first_name"] . " " . $details_data["last_name"]; ?></h5>
                        <span>~ <?php echo $details_data["user_type"]; ?> ~</span>
                    </div>


                    <div class="mb-2 dashbtns">
                        <ul class="nav flex-column gap-2">
                            <li class="btn btn-primary" onclick="window.location.href='my-account.php'" id="overviewbtn">
                                <a class="w-100"><i class="bi bi-shop"></i>&nbsp; Overview</a>
                            </li>
                            <li class="btn btn-primary" onclick="window.location.href='account-settings.php'">
                                <a><i class="bi bi-gear"></i>&nbsp; Account Settings</a>
                            </li>
                            <li class="btn btn-primary" onclick="window.location.href='myorders.php'">
                                <a><i class="bi bi-cart3"></i>&nbsp; My Orders &nbsp;</a>
                            </li>                            
                            <li class="btn btn-secondary" onclick="window.location.href='index.php'">
                                <a><i class="bi bi-box-arrow-up-right"></i>&nbsp; Visit BookZone</a>
                            </li>
                            <li class="btn btn-danger" onclick="signout();">
                                <a><i class="bi bi-door-open"></i>&nbsp; Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    <?php

    } else {
    }

    ?>


    <script src="script.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>

</html>
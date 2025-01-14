<?php
session_start();

require "connection.php";

if (isset($_SESSION["u"])) {

    $user_email = $_SESSION["u"]["email"];
    $user_status = $_SESSION["u"]["status"];

    $password1 = $_POST["p1"];
    $password2 = $_POST["p2"];

    $user_rs = Database::search("SELECT * FROM `users` WHERE `email` = '" . $user_email . "'");
    $user_num = $user_rs->num_rows;

    if ($user_num == 1) {
        if ($user_status == 1) {

            if (empty($password1)) {
                echo ("Please enter your new password");
            } else if (empty($password2)) {
                echo ("Please enter confirm password");
            } else if (strlen($password1) < 5) {
                echo ("Your password must atleast 5 characters");
            } else if (strlen($password1) > 12) {
                echo ("Your password must below 12 characters");
            } else if ($password1 != $password2) {
                echo ("Confirm password is not match");
            } else {
                Database::iud("UPDATE `users` SET `password`='" . $password1 . "' WHERE `email` = '" . $user_email . "'");
                echo ("success");
            }
        } else {
            echo ("Your account is deactivated");
        }
    } else {

        echo ("You are not a valid user");
    }
}

<?php
session_start();

require "connection.php";

if (isset($_SESSION["u"])) {

    $user_email = $_SESSION["u"]["email"];
    $user_status = $_SESSION["u"]["status"];

    $user_rs = Database::search("SELECT * FROM `users` WHERE `email` = '" . $user_email . "'");
    $user_num = $user_rs->num_rows;

    if ($user_num == 1) {
        if ($user_status == 1) {

            Database::iud("UPDATE `users` SET `status`='2' WHERE `email` = '" . $user_email . "'");
            echo ("success");

        } else {
            echo ("Your account is deactivated");
        }
    } else {

        echo ("You are not a valid user");
    }
}

<?php

require "connection.php";

$email = $_POST["email"];

$user_rs = Database::search("SELECT * FROM `users` WHERE `email` = '" . $email . "'");
$user_num = $user_rs->num_rows;

$profile_image_rs = Database::search("SELECT * FROM `profile_img` WHERE `users_email` = '" . $email . "'");
$profile_image_num = $user_rs->num_rows;

$adderss_rs = Database::search("SELECT * FROM `users_address` WHERE `users_email` = '" . $email . "'");
$adderss_num = $adderss_rs->num_rows;

if ($user_num == 1) {
    if ($adderss_num > 0) {
        Database::iud("DELETE FROM `bookzone`.`profile_img` WHERE `users_email` = '" . $email . "'");
        Database::iud("DELETE FROM `bookzone`.`users_address` WHERE `users_email` = '" . $email . "'");
        Database::iud("DELETE FROM `bookzone`.`users` WHERE `email` = '" . $email . "'");

        echo ("success");
    } else {
        echo ("success");
    }
} else {
    echo ("Invalid Customer");
}

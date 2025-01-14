<?php

require "connection.php";

$email = $_GET["email"];
$status = $_GET["stetus"];

$user_rs = Database::search("SELECT * FROM `users` WHERE `email` = '" . $email . "'");
$user_num = $user_rs->num_rows;

if (!$email == "") {
    if (!$status == 0) {
        Database::iud("UPDATE `users` SET `status`='" . $status . "' WHERE `email` = '" . $email . "'");

        echo ("success");

    } else {
        echo ($status);
    }
} else {
    echo ("Select a Customer");
}

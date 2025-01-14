<?php
session_start();

require "connection.php";

if (isset($_SESSION["u"])) {
    $user_email = $_SESSION["u"]["email"];
    $a_line1 = $_POST["al1"];
    $a_line2 = $_POST["al2"];
    $district = $_POST["ad"];
    $province = $_POST["ap"];
    $city = $_POST["ac"];
    $pcode = $_POST["apc"];

    $address_rs = Database::search("SELECT * FROM `users_address` WHERE `users_email`='" . $user_email . "' AND `address_type`='1'");
    $address_num = $address_rs->num_rows;

    if ($address_num > 0) {

        if (empty($a_line1)) {
            echo ("Address Line 01 Can't be Empty");
        } else if (empty($province)) {
            echo ("Please select your province");
        } else if (empty($district)) {
            echo ("Please select your district");
        } else if (empty($city)) {
            echo ("Please enter your city");
        } else if (empty($pcode)) {
            echo ("Please enter your postal code");
        } else if (strlen($pcode) < 5) {
            echo ("Postal code must have 5 numbers");
        } else if (strlen($pcode) > 5) {
            echo ("Postal code must have 5 numbers");
        }else{
            Database::iud("UPDATE `users_address` SET `line1`='" . $a_line1 . "', `line2`='" . $a_line2 . "', `city`='" . $city . "',
        `postal_code`='" . $pcode . "', `district_district_id`='" . $district . "' WHERE `users_email`='".$user_email."' AND `address_type`='1'");
            echo ("success");
        }
    } else {
        Database::iud("INSERT INTO `users_address`(`line1`,`line2`,`city`,`postal_code`,`district_district_id`,`users_email`,`address_type`) VALUES 
                            ('" . $a_line1 . "','" . $a_line2 . "','" . $city . "','" . $pcode . "','" . $district . "','" . $user_email . "','1')");
        echo ("success");
    }
}

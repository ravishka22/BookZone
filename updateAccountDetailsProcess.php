<?php
session_start();

require "connection.php";

if (isset($_SESSION["u"])) {

    $user_email = $_SESSION["u"]["email"];

    $fname = $_POST["fn"];
    $lname = $_POST["ln"];
    $email = $_POST["ea"];
    $mobile = $_POST["mn"];
    $bday = $_POST["bd"];
    $gender = $_POST["g"];



    $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");

    if (isset($_FILES["img"])) {

        $img = $_FILES["img"];
        $file_type = $img["type"];

        if (in_array($file_type, $allowed_image_extentions)) {

            $new_file_type;

            if ($file_type == "image/jpg") {
                $new_file_type = ".jpg";
            } else if ($file_type == "image/jpeg") {
                $new_file_type = ".jpeg";
            } else if ($file_type == "image/png") {
                $new_file_type = ".png";
            } else if ($file_type == "image/svg+xml") {
                $new_file_type = ".svg";
            }

            $file_name = "resourses/profile_images/" . $fname . "_" . $lname . "_" . uniqid() . $new_file_type;
            move_uploaded_file($img["tmp_name"], $file_name);

            $image_rs = Database::search("SELECT * FROM `profile_img` WHERE `users_email` = '" . $user_email . "'");

            $image_num = $image_rs->num_rows;

            if ($image_num == 1) {

                Database::iud("UPDATE `profile_img` SET `path`='" . $file_name . "' WHERE 
                            `users_email` = '" . $user_email . "'");
            } else {

                Database::iud("INSERT INTO `profile_img`(`path`,`users_email`) VALUES 
                            ('" . $file_name . "','" . $user_email . "')");
            }
        } else {

            echo ("File type does not allowed to upload");
        }
    }

    $user_rs = Database::search("SELECT * FROM `users` WHERE `email` = '" . $user_email . "'");
    $user_num = $user_rs->num_rows;

    $gender_rs = Database::search("SELECT * FROM `gender` INNER JOIN `users` ON gender.id=users.gender_id WHERE `email`='" . $email . "'");
    $gender_num = $gender_rs->num_rows;

    if ($user_num == 1) {

        if (empty($fname)) {
            echo ("First name can't be Empty");
        } else if (strlen($fname) < 3) {
            echo ("First name must have atleast 3 characters");
        } else if (strlen($fname) > 45) {
            echo ("First name must less than 45 characters");
        } else if (empty($lname)) {
            echo ("Last name can't be Empty");
        } else if (strlen($lname) < 3) {
            echo ("Last name must have atleast 3 characters");
        } else if (strlen($lname) > 45) {
            echo ("Last name must less than 45 characters");
        } else if (empty($mobile)) {
            echo ("Please enter your Mobie Number.");
        } else if (strlen($mobile) != 10) {
            echo ("Mobile number must contain 10 characters.");
        } else if ($gender_num == 0) {

            if (empty($bday)) {
                echo ("Please enter your First Name.");
            } else {
                Database::iud("UPDATE `users` SET `first_name`='" . $fname . "',`last_name`='" . $lname . "',`email`='" . $email . "',
                `mobile`='" . $mobile . "',`birthday`='" . $bday . "',`gender_id`='" . $gender . " WHERE `email` = '" . $user_email . "'");

                echo ("success");
            }
        } else {
            if (empty($bday)) {
                echo ("Please enter your Birthday.");
            } else {
                Database::iud("UPDATE `users` SET `first_name`='" . $fname . "',`last_name`='" . $lname . "',`email`='" . $email . "',
                `mobile`='" . $mobile . "',`birthday`='" . $bday . "' WHERE `email` = '" . $user_email . "'");

                echo ("success");
            }
        }
    } else {

        echo ("You are not a valid user");
    }
}

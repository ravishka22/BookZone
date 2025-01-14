<?php

require "connection.php";


$fname = $_POST["fn"];
$lname = $_POST["ln"];
$email = $_POST["ea"];
$mobile = $_POST["mn"];
$bday = $_POST["bd"];
$gender = $_POST["g"];

// $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");

if (empty($fname)) {
    echo ("Please enter customer First Name.");
} else if (strlen($fname) > 45) {
    echo ("First Name must have less than 45 characters.");
} else if (empty($lname)) {
    echo ("Please enter customer Last Name.");
} else if (strlen($lname) > 45) {
    echo ("Last Name must have less than 45 characters.");
} else if (empty($email)) {
    echo ("Please enter customer Email Address.");
} else if (strlen($email) > 100) {
    echo ("Email must have less than 100 characters.");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email Address");
} else if (empty($mobile)) {
    echo ("Please enter customer Mobie Number.");
} else if (strlen($mobile) != 10) {
    echo ("Mobile number must contain 10 characters.");
} else if (!preg_match("/07[0,1,2,4,5,6,7,8][0-9]/", $mobile)) {
    echo ("Invalid Mobile Number.");
} else {
    $rs = Database::search("SELECT * FROM `users` WHERE `email`='" . $email . "' OR 
    `mobile`='" . $mobile . "'");
    $n = $rs->num_rows;

    if ($n > 0) {
        echo ("Customer with the same Mobile Number or Email already exists.");
    } else {

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        $p = $lname . "_" . uniqid();

        Database::iud("INSERT INTO 
        `users`(`first_name`,`last_name`,`email`,`password`,`mobile`,`joined_date`,`status`,`user_type_id`) 
        VALUES ('" . $fname . "','" . $lname . "','" . $email . "','" . $p . "','" . $mobile . "',
        '" . $date . "','1','2')");

        Database::iud("INSERT INTO`profile_img`(`path`,`users_email`) VALUES ('resourses/default_propic.jpg','" . $email . "')");

        // if (isset($_FILES["img"])) {

        //     $img = $_FILES["img"];
        //     $file_type = $img["type"];

        //     if (in_array($file_type, $allowed_image_extentions)) {

        //         $new_file_type;

        //         if ($file_type == "image/jpg") {
        //             $new_file_type = ".jpg";
        //         } else if ($file_type == "image/jpeg") {
        //             $new_file_type = ".jpeg";
        //         } else if ($file_type == "image/png") {
        //             $new_file_type = ".png";
        //         } else if ($file_type == "image/svg+xml") {
        //             $new_file_type = ".svg";
        //         }

        //         $file_name = "resourses/profile_images/" . $fname . "_" . $lname . "_" . uniqid() . $new_file_type;
        //         move_uploaded_file($img["tmp_name"], $file_name);



        //         Database::iud("INSERT INTO `profile_img`(`path`,`users_email`) VALUES 
        //                                 ('" . $file_name . "','" . $email . "')");
        //     } else {

        //         echo ("File type does not allowed to upload");
        //     }
        // } else {
        //     Database::iud("INSERT INTO`profile_img`(`path`,`users_email`) VALUES ('resourses/default_propic.jpg','" . $email . "')");
        // }


        echo ("Register success");
    }
}

<?php

require "connection.php";

$lname = $_POST["ln"];
$ldisc = $_POST["ld"];

if (empty($lname)) {
    echo ("Please enter Language Name.");
} else if (strlen($lname) < 5) {
    echo ("Language Name must have more than 5 characters.");
} else if (strlen($lname) > 45) {
    echo ("Language Name must have less than 45 characters.");
} else if (strlen($ldisc) > 100) {
    echo ("Short Discription must have less than 100 characters.");
} else {
    $rs = Database::search("SELECT * FROM `language` WHERE `language_name`='" . $lname . "'");
    $n = $rs->num_rows;

    if ($n > 0) {
        echo ("This language already exists.");
    } else {
        Database::iud("INSERT INTO `language`(`language_name`,`language_discription`)
        VALUES ('$lname','$ldisc')");
        echo ("success");
    }
}

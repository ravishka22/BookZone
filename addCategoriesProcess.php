<?php

require "connection.php";

$cname = $_POST["cn"];
$cdisc = $_POST["cd"];

if (empty($cname)) {
    echo ("Please enter Category Name.");
} else if (strlen($cname) < 5) {
    echo ("Category Name must have more than 5 characters.");
} else if (strlen($cname) > 45) {
    echo ("Category Name must have less than 45 characters.");
} else if (strlen($cdisc) > 100) {
    echo ("Short Discription must have less than 100 characters.");
} else {
    $rs = Database::search("SELECT * FROM `category` WHERE `category_name`='" . $cname . "'");
    $n = $rs->num_rows;

    if ($n > 0) {
        echo ("This category already exists.");
    } else {
        Database::iud("INSERT INTO `category`(`category_name`,`category_discription`)
        VALUES ('$cname','$cdisc')");
        echo ("success");
    }
}

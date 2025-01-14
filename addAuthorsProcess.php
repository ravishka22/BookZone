<?php

require "connection.php";

$aname = $_POST["an"];
$adisc = $_POST["ad"];

if (empty($aname)) {
    echo ("Please enter Author Name.");
} else if (strlen($aname) < 5) {
    echo ("Author Name must have more than 5 characters.");
} else if (strlen($aname) > 45) {
    echo ("Author Name must have less than 45 characters.");
} else {
    $rs = Database::search("SELECT * FROM `author` WHERE `author_name`='" . $aname . "'");
    $n = $rs->num_rows;

    if ($n > 0) {
        echo ("This author already exists.");
    } else {
        Database::iud("INSERT INTO `author`(`author_name`,`author_discription`)
        VALUES ('$aname','$adisc')");
        echo ("success");
    }
}

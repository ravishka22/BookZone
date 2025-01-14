<?php

include "connection.php";

$order_id = $_POST["oid"];
$stetus = $_POST["stetus"];

if ($stetus == 0) {
    echo("Please select order stetus");
} else {
    $rs = Database::search("SELECT * FROM `order` WHERE order_id='".$order_id."'");
    $num = $rs->num_rows;
    $data = $rs->fetch_assoc();

    Database::iud("UPDATE `order` SET `order_status_id`='".$stetus."' WHERE order_id='".$order_id."'");

    echo("success");
}



?>
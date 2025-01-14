<?php

session_start();

$_SESSION["oid"] = "";

require "connection.php";

$order_stetus = $_GET["status"];
$order_id = $_GET["id"];

$order_rs = Database::search("SELECT * FROM `order` WHERE `order_id` = '" . $order_id . "'");
$order_num = $order_rs->num_rows;

Database::iud("UPDATE `order` SET `order_status_id`='" . $order_stetus . "' WHERE `order_id` = '" . $order_id . "'");
echo ("success");


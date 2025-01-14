<?php

session_start();

require "connection.php";

$book_id = $_GET["id"];
$email = $_SESSION["u"]["email"];

$cart_rs = Database::search("SELECT * FROM `cart` WHERE `book_id`='" . $book_id . "' AND `users_email`='" . $email . "'");
$cart_num = $cart_rs->num_rows;

if ($cart_num == 1) {
    Database::iud("DELETE FROM `cart` WHERE `book_id`='" . $book_id . "' AND `users_email`='" . $email . "'");
    echo("success");
}else{
    echo("Invalid Book");
}

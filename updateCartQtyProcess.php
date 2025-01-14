<?php

session_start();

require "connection.php";

$book_id = $_GET["id"];
$email = $_SESSION["u"]["email"];
$book_qty = $_GET["qty"];

$cart_rs = Database::search("SELECT * FROM `cart` WHERE `book_id`='" . $book_id . "' AND `users_email`='" . $email . "'");
$cart_num = $cart_rs->num_rows;

$book_rs = Database::search("SELECT * FROM `book` WHERE `id` = '$book_id'");
$book_num = $book_rs->num_rows;
$book_data = $book_rs->fetch_assoc();



if ($book_qty > 0) {
    if ($book_qty < $book_data["quantity"]) {
        Database::iud("UPDATE `cart` SET `cart_qty`='" . $book_qty . "' WHERE `book_id`='" . $book_id . "' AND `users_email`='" . $email . "' ");
        echo ("Cart Updated");
    }else{
        echo("You can't add more than ".$book_data["quantity"]);
    }
}else{
    echo("You must add 1 or more");
}

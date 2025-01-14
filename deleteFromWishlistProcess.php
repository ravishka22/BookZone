<?php

session_start();

require "connection.php";

$book_id = $_GET["id"];
$email = $_SESSION["u"]["email"];

$wishlist_rs = Database::search("SELECT * FROM `wishlist` WHERE `book_id`='" . $book_id . "' AND `users_email`='" . $email . "'");
$wishlist_num = $wishlist_rs->num_rows;

if ($wishlist_num > 0) {
    Database::iud("DELETE FROM `wishlist` WHERE `book_id`='" . $book_id . "' AND `users_email`='" . $email . "'");
    echo("success");
}else{
    echo("success");
}

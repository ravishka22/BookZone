<?php

require "connection.php";

$book_id = $_GET["id"];

$book_rs = Database::search("SELECT * FROM `book` WHERE `id` = '" . $book_id . "'");
$book_num = $book_rs->num_rows;

$book_h_cat_rs = Database::search("SELECT * FROM `book_has_category` WHERE `book_id` = '" . $book_id . "' ");
$book_h_cat_num = $book_h_cat_rs->num_rows;

$book_img_rs = Database::search("SELECT * FROM `book_img` WHERE `book_id` = '" . $book_id . "' ");
$book_img_num = $book_img_rs->num_rows;

$cart_rs = Database::search("SELECT * FROM `cart` WHERE `book_id` = '" . $book_id . "' ");
$cart_num = $cart_rs->num_rows;

if ($book_num == 1) {

    if ($book_h_cat_num > 0) {
        Database::iud("DELETE FROM `bookzone`.`book_has_category` WHERE `book_id` = '" . $book_id . "'");
    }

    if ($book_img_num > 0) {
        Database::iud("DELETE FROM `bookzone`.`book_img` WHERE `book_id` = '" . $book_id . "'");
    }

    if ($cart_num > 0) {
        Database::iud("DELETE FROM `bookzone`.`cart` WHERE `book_id` = '" . $book_id . "'");
    }

    Database::iud("DELETE FROM `bookzone`.`book` WHERE `id` = '" . $book_id . "'");

    echo ("success");
} else {
    echo ("Invalid Book");
}
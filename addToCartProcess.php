<?php

session_start();

require "connection.php";


if (isset($_GET["id"])) {

    if (isset($_SESSION["u"])) {

        $book_id = $_GET["id"];
        $email = $_SESSION["u"]["email"];
        $book_qty = $_GET["qty"];

        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `book_id`='" . $book_id . "' AND `users_email`='" . $email . "'");
        $cart_num = $cart_rs->num_rows;

        $wishlist_rs = Database::search("SELECT * FROM `wishlist` WHERE `book_id`='" . $book_id . "' AND `users_email`='" . $email . "'");
        $wishlist_num = $wishlist_rs->num_rows;

        if ($cart_num == 1) {

            echo ("This Book Already exists In the Cart");
        } else {

            if (isset($book_qty)) {
                Database::iud("INSERT INTO `cart`(`cart_qty`,`book_id`,`users_email`)
                        VALUES ('" . $book_qty . "','" . $book_id . "','" . $email . "')");
            } else {
                Database::iud("INSERT INTO `cart`(`cart_qty`,`book_id`,`users_email`)
                        VALUES ('1','" . $book_id . "','" . $email . "')");
            }

            if ($wishlist_num == 1) {
                Database::iud("DELETE FROM `wishlist` WHERE `book_id`='" . $book_id . "' AND `users_email`='" . $email . "'");
            }

            echo ("Book Added");
        }

        

        if ($wishlist_num == 1) {
            Database::iud("DELETE FROM `wishlist` WHERE `book_id`='" . $book_id . "' AND `users_email`='" . $email . "'");
        }
    } else {
        echo ("Please Login");
    }
}

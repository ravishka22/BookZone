<?php

session_start();

require "connection.php";


if (isset($_GET["id"])) {

    if (isset($_SESSION["u"])) {

        $book_id = $_GET["id"];
        $email = $_SESSION["u"]["email"];
        
        $wishlist_rs = Database::search("SELECT * FROM `wishlist` WHERE `book_id`='" . $book_id . "' AND `users_email`='" . $email . "'");
        $wishlist_num = $wishlist_rs->num_rows;

        if ($wishlist_num == 1) {

            echo ("Already exists In the Wishlist");
        } else {

            
                Database::iud("INSERT INTO `wishlist`(`book_id`,`users_email`)
                        VALUES ('" . $book_id . "','" . $email . "')");
            

            echo ("Book Added");
        }
    }else {
        echo ("Please Login");
    }
}

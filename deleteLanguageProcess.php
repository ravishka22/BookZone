<?php

require "connection.php";

$language_id = $_GET["id"];

$language_rs = Database::search("SELECT * FROM `language` WHERE `id` = '" . $language_id . "'");
$language_num = $language_rs->num_rows;

$book_rs = Database::search("SELECT * FROM `book` WHERE `language_id` = '" . $language_id . "' ");
$book_num = $book_rs->num_rows;

if ($language_num == 1) {
    if ($book_num > 0) {
        for ($i=0; $i < $book_num; $i++) { 
            $book_data = $book_rs->fetch_assoc();
            Database::iud("UPDATE  `book` SET `language_id` = '1' WHERE `language_id` = '" . $language_id . "'");
        }
        Database::iud("DELETE FROM `bookzone`.`language` WHERE `id` = '" . $language_id . "'");
    }
    Database::iud("DELETE FROM `bookzone`.`language` WHERE `id` = '" . $language_id . "'");

    echo ("success");
} else {
    echo ("Invalid Language");
}

<?php

require "connection.php";

$author_id = $_GET["id"];

$author_rs = Database::search("SELECT * FROM `author` WHERE `id` = '" . $author_id . "'");
$author_num = $author_rs->num_rows;

$book_rs = Database::search("SELECT * FROM `book` WHERE `author_id` = '" . $author_id . "' ");
$book_num = $book_rs->num_rows;

if ($author_num == 1) {

    if ($book_num > 0) {
        for ($i=0; $i < $book_num; $i++) { 
            $book_data = $book_rs->fetch_assoc();
            Database::iud("UPDATE  `book` SET `author_id` = '1' WHERE `author_id` = '" . $author_id . "'");
        }
        Database::iud("DELETE FROM `bookzone`.`author` WHERE `id` = '" . $author_id . "'");
    }

    Database::iud("DELETE FROM `bookzone`.`author` WHERE `id` = '" . $author_id . "'");

    echo ("success");
} else {
    echo ("Invalid Author");
}

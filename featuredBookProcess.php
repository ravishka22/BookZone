<?php

require "connection.php";

$book_id = $_GET["bid"];

$book_rs = Database::search("SELECT * FROM `book` WHERE `id` = '" . $book_id . "'");
$book_num = $book_rs->num_rows;
$book_data = $book_rs->fetch_assoc();


if ($book_num == 1) {
    if ($book_data['book_status_id'] == 1) {
        Database::iud("UPDATE `book` SET `book_status_id`='3' WHERE `id` = '" . $book_id . "'");
        echo ("featured");
    } else if ($book_data['book_status_id'] == 3) {
        Database::iud("UPDATE `book` SET `book_status_id`='1' WHERE `id` = '" . $book_id . "'");
        echo ("notfeatured");
    }else {
        echo ("Book is not published");
    }
    
} else {
    echo ("Invalid Author");
}
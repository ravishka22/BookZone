<?php

require "connection.php";

$category_id = $_GET["id"];

$category_rs = Database::search("SELECT * FROM `category` WHERE `id` = '" . $category_id . "'");
$category_num = $category_rs->num_rows;

$cat_rs = Database::search("SELECT * FROM `book_has_category` WHERE `category_id` = '" . $category_id . "' ");
$cat_num = $cat_rs->num_rows;

if ($category_num == 1) {
    if ($cat_num > 0) {
        for ($i=0; $i < $cat_num; $i++) { 
            $cat_data = $cat_rs->fetch_assoc();
            Database::iud("UPDATE  `book_has_category` SET `category_id` = '1' WHERE `category_id` = '" . $category_id . "'");
        }
        Database::iud("DELETE FROM `bookzone`.`category` WHERE `id` = '" . $category_id . "'");

    }
    Database::iud("DELETE FROM `bookzone`.`category` WHERE `id` = '" . $category_id . "'");

    echo ("success");
} else {
    echo ("Invalid Category");
}

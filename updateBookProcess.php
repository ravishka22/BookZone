<?php

require "connection.php";

$book_id = $_POST["bid"];
$bname = $_POST["bn"];
$bdisc = $_POST["bdisc"];
$bpage = $_POST["bpage"];
$bpublisher = $_POST["bpub"];
$bisbn = $_POST["bisbn"];
$bpublisheddate = $_POST["bpd"];
$blanguage = $_POST["bl"];
$bauthor = $_POST["ba"];
$bprice = $_POST["bprice"];
$bsaleprice = $_POST["bsprice"];
$bqty = $_POST["bq"];
$bsku = $_POST["bsku"];
$bweight = $_POST["bw"];
$bdimention = $_POST["bdimen"];
$bcategory = $_POST["cat"];
$bcatlength = $_POST["catlength"];
$catarray = explode(",", $bcategory);



$allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/webp", "image/svg+xml");

if (empty($bname)) {
    echo ("Please enter Book Name.");
} else if (strlen($bname) < 5) {
    echo ("Book Name must have more than 5 characters.");
} else if (strlen($bname) > 45) {
    echo ("Book Name must have less than 45 characters.");
} else if (empty($bdisc)) {
    echo ("Please enter Book Discription.");
} else if (strlen($bdisc) < 5) {
    echo ("Book Discription must have more than 5 characters.");
} else if (empty($bpage)) {
    echo ("Please Enter Page Count.");
} else if (empty($bisbn)) {
    echo ("Please Enter Book ISBN.");
} else if (empty($bprice)) {
    echo ("Please Enter Book Price.");
} else if (empty($bqty)) {
    echo ("Please Enter Book Quantity.");
} else {

    $book_rs = Database::search("SELECT * FROM `book` INNER JOIN `language` ON book.language_id=language.id 
                                                INNER JOIN `author` ON author.id=book.author_id WHERE book.id = '$book_id'");
    $book_num = $book_rs->num_rows;

    if ($book_num == 1) {


        Database::iud("UPDATE `book` SET `book_name`='" . $bname . "', `book_discription`='" . $bdisc . "', 
                    `publisher`='" . $bpublisher . "', `isbn`='" . $bisbn . "', `pages`='" . $bpage . "', `published_date`='" . $bpublisheddate . "',
                    `price`='" . $bprice . "', `quantity`='" . $bqty . "', `weight`='" . $bweight . "', `dimention`='" . $bdimention . "' WHERE book.id='$book_id'");

        if (!empty($bsaleprice)) {
            Database::iud("UPDATE `book` SET `sale_price`='" . $bsaleprice . "' WHERE book.id='$book_id'");
        }

        if (!$blanguage == 0) {
            Database::iud("UPDATE `book` SET `language_id`='" . $blanguage . "' WHERE book.id='$book_id'");
        }

        if (!$bauthor == 0) {
            Database::iud("UPDATE `book` SET `author_id`='" . $bauthor . "' WHERE book.id='$book_id'");
        }

        if (isset($_FILES["img"])) {

            $bimg = $_FILES["img"];
            $file_type = $bimg["type"];
            if (in_array($file_type, $allowed_image_extentions)) {

                $new_file_type;

                if ($file_type == "image/jpg") {
                    $new_file_type = ".jpg";
                } else if ($file_type == "image/jpeg") {
                    $new_file_type = ".jpeg";
                } else if ($file_type == "image/png") {
                    $new_file_type = ".png";
                } else if ($file_type == "image/svg+xml") {
                    $new_file_type = ".svg";
                } else if ($file_type == "image/webp") {
                    $new_file_type = ".webp";
                }

                $file_name = "resourses/book_images/BZ-" . $book_id . "_" . uniqid() . $new_file_type;
                move_uploaded_file($bimg["tmp_name"], $file_name);

                $bookimg_rs = Database::search("SELECT * FROM `book_img` WHERE `book_id`='" . $book_id . "'");
                $bookimg_num = $bookimg_rs->num_rows;

                Database::iud("UPDATE `book_img` SET `path`='" . $file_name . "' WHERE book_id='$book_id'");
            } else {

                echo ("File type does not allowed to upload");
            }
        }

        if (!empty($catarray)) {
            for ($i = 0; $i < $bcatlength; $i++) {
                Database::iud("DELETE FROM `bookzone`.`book_has_category` WHERE `book_id` = '" . $book_id . "'");
            }
            for ($i = 0; $i < $bcatlength; $i++) {
                Database::iud("INSERT INTO `book_has_category` (`category_id`,`book_id`) VALUES 
                ('" . $catarray[$i] . "','" . $book_id . "')");
            }
        }

        echo ("success");
    } else {
        echo ("Invalid Book");
    }











    // echo ("success");
}

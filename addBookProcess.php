<?php

require "connection.php";

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

$allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml", "image/webp");

$book_rs = Database::search("SELECT * FROM `book` WHERE book.book_name='$bname'");
$book_num_rows = $book_rs->num_rows;

if (empty($bname)) {
    echo ("Please enter Book Name.");
} else if (strlen($bname) < 5) {
    echo ("Book Name must have more than 5 characters.");
} else if (strlen($bname) > 100) {
    echo ("Book Name must have less than 100 characters.");
} else if ($book_num_rows > 0) {
    echo ("Book with the same name already exists.");
} else if (empty($bdisc)) {
    echo ("Please enter Book Discription.");
} else if (strlen($bdisc) < 5) {
    echo ("Book Discription must have more than 5 characters.");
} else if (empty($bpage)) {
    echo ("Please Enter Page Count.");
} else if (empty($bisbn)) {
    echo ("Please Enter Book ISBN.");
} else if (empty($bpublisheddate)) {
    echo ("Please Enter Book Published Date.");
} else if ($bpublisheddate == "mm/dd/yy") {
    echo ("Please Enter Book Published Date.");
} else if ($blanguage == 0) {
    echo ("Please Select Book Language.");
} else if ($bauthor == 0) {
    echo ("Please Select Book Author.");
} else if (empty($bprice)) {
    echo ("Please Enter Book Price.");
} else if (empty($bqty)) {
    echo ("Please Enter Book Quantity.");
} else if (empty($bweight)) {
    echo ("Please Enter Book Weight.");
} else if (empty($bdimention)) {
    echo ("Please Enter Book Dimention.");
} else if (empty($bcatlength)) {
    echo ("Please Select Book Categories.");
} else {

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");


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

            Database::iud("INSERT INTO 
            `book` (`book_name`,`book_discription`,`pages`,`publisher`,`price`,`sale_price`,`quantity`,`isbn`,`published_date`,
            `sku`,`weight`,`dimention`,`language_id`,`author_id`,`book_added_date`,`book_status_id`) 
            VALUES ('" . $bname . "','" . $bdisc . "','" . $bpage . "','" . $bpublisher . "','" . $bprice . "','" . $bsaleprice . "','" . $bqty . "','" . $bisbn . "',
            '" . $bpublisheddate . "','" . $bsku . "','" . $bweight . "','" . $bdimention . "','" . $blanguage . "','" . $bauthor . "','" . $date . "','1')");

            $book_id = Database::$connection->insert_id;

            $file_name = "resourses/book_images/BZ-" . $book_id . "_" . uniqid() . $new_file_type;
            move_uploaded_file($bimg["tmp_name"], $file_name);

            Database::iud("INSERT INTO `book_img` (`path`,`book_id`) VALUES 
                                        ('" . $file_name . "','" . $book_id . "')");

            for ($i = 0; $i < $bcatlength; $i++) {
                Database::iud("INSERT INTO `book_has_category` (`category_id`,`book_id`) VALUES 
                ('" . $catarray[$i] . "','" . $book_id . "')");
            }

            echo ("success");
        } else {

            echo ("File type does not allowed to upload");
        }
    } else {
        echo ("Please Upload Book Image");
    }
}

<?php

session_start();

require "connection.php";

if (isset($_SESSION["u"])) {

    $book_id;
    $book_qty;
    $user_email = $_SESSION["u"]["email"];
    $sub_total = 0;
    $total_weight = 0;
    $discount = 0;

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d");

    if ($_POST["bid"] > 0) {

        $book_id = $_POST["bid"];
        $book_qty = $_POST["bq"];
        $sub_total = $_POST["st"];
        $total_weight = $_POST["tw"];

        if ($total_weight <= 250) {
            $shipping = 200;
        } else if ($total_weight <= 500 & $total_weight > 250) {
            $shipping = 250;
        } else if ($total_weight <= 1000 & $total_weight > 500) {
            $shipping = 350;
        } else if ($total_weight <= 2000 & $total_weight > 1000) {
            $shipping = 400;
        } else if ($total_weight <= 3000 & $total_weight > 2000) {
            $shipping = 450;
        } else if ($total_weight <= 4000 & $total_weight > 3000) {
            $shipping = 500;
        } else if ($total_weight <= 5000 & $total_weight > 4000) {
            $shipping = 550;
        } else if ($total_weight <= 6000 & $total_weight > 5000) {
            $shipping = 600;
        } else if ($total_weight <= 7000 & $total_weight > 6000) {
            $shipping = 650;
        } else if ($total_weight <= 8000 & $total_weight > 7000) {
            $shipping = 700;
        } else if ($total_weight <= 9000 & $total_weight > 8000) {
            $shipping = 750;
        } else if ($total_weight <= 10000 & $total_weight > 9000) {
            $shipping = 800;
        }

        $total = $sub_total + $shipping - $discount;

        Database::iud("INSERT INTO `order`(`order_status_id`,`users_email`,
        `order_date`,`subtotal`,`shipping_method`,`shipping_cost`,`discount`,`total_cost`)
        VALUES ('1','" . $user_email . "','" . $date . "','" . $sub_total . "','1','" . $shipping . "',
        '" . $discount . "','" . $total . "')");

        $order_id = Database::$connection->insert_id;

        Database::iud("INSERT INTO `order_has_book`(`order_order_id`,`book_id`,`order_qty`,`item_total`) VALUES ('" . $order_id . "','" . $book_id . "','" . $book_qty . "','" . $sub_total . "')");

        $qbook_rs = Database::search("SELECT * FROM `book` WHERE `id`='".$book_id."'");
        $qbook_data = $qbook_rs->fetch_assoc();
        $new_qty = $qbook_data["quantity"] - $book_qty;
        Database::iud("UPDATE `book` SET `quantity`='".$new_qty."' WHERE `id`='".$book_id."'");
        
        $_SESSION["oid"] = $order_id;
        
        echo ("success");

    } else {
        $cart_book_rs = Database::search("SELECT * FROM `cart` WHERE `users_email`='" . $user_email . "'");
        $cart_book_num = $cart_book_rs->num_rows;

        $item_total;

        for ($i = 0; $i < $cart_book_num; $i++) {
            $cart_book_data = $cart_book_rs->fetch_assoc();
            $book_id = $cart_book_data["book_id"];
            $book_qty = $cart_book_data["cart_qty"];


            $book_rs = Database::search("SELECT * FROM `book` INNER JOIN `book_img` ON book_img.book_id=book.id 
            INNER JOIN `cart` ON cart.book_id=book.id
            WHERE book.id='" . $book_id . "' AND cart.users_email='" . $user_email . "'");
            $book_num = $book_rs->num_rows;

            $book_data = $book_rs->fetch_assoc();

            if ($book_data['sale_price'] > 0) {
                $item_total = $book_data["sale_price"] * $book_data["cart_qty"];
            } else {
                $item_total = $book_data["price"] * $book_data["cart_qty"];
            }

            $sub_total = $sub_total + $item_total;

            $total_weight = $total_weight + $book_data["weight"] * $book_data["cart_qty"];

            if ($total_weight <= 250) {
                $shipping = 200;
            } else if ($total_weight <= 500 & $total_weight > 250) {
                $shipping = 250;
            } else if ($total_weight <= 1000 & $total_weight > 500) {
                $shipping = 350;
            } else if ($total_weight <= 2000 & $total_weight > 1000) {
                $shipping = 400;
            } else if ($total_weight <= 3000 & $total_weight > 2000) {
                $shipping = 450;
            } else if ($total_weight <= 4000 & $total_weight > 3000) {
                $shipping = 500;
            } else if ($total_weight <= 5000 & $total_weight > 4000) {
                $shipping = 550;
            } else if ($total_weight <= 6000 & $total_weight > 5000) {
                $shipping = 600;
            } else if ($total_weight <= 7000 & $total_weight > 6000) {
                $shipping = 650;
            } else if ($total_weight <= 8000 & $total_weight > 7000) {
                $shipping = 700;
            } else if ($total_weight <= 9000 & $total_weight > 8000) {
                $shipping = 750;
            } else if ($total_weight <= 10000 & $total_weight > 9000) {
                $shipping = 800;
            }

            $total = $sub_total + $shipping - $discount;
        }

        Database::iud("INSERT INTO `order`(`order_status_id`,`users_email`,
            `order_date`,`subtotal`,`shipping_method`,`shipping_cost`,`discount`,`total_cost`)
            VALUES ('1','" . $user_email . "','" . $date . "','" . $sub_total . "','1','" . $shipping . "',
            '" . $discount . "','" . $total . "')");

        $order_id = Database::$connection->insert_id;

        $cart_book_rs2 = Database::search("SELECT * FROM `cart` WHERE `users_email`='" . $user_email . "'");
        $cart_book_num2 = $cart_book_rs2->num_rows;

        for ($i = 0; $i < $cart_book_num; $i++) {
            $cart_book_data2 = $cart_book_rs2->fetch_assoc();
            $book_id = $cart_book_data2["book_id"];
            $book_qty = $cart_book_data2["cart_qty"];


            $book_rs2 = Database::search("SELECT * FROM `book` INNER JOIN `book_img` ON book_img.book_id=book.id 
            INNER JOIN `cart` ON cart.book_id=book.id
            WHERE book.id='" . $book_id . "' AND cart.users_email='" . $user_email . "'");
            $book_num2 = $book_rs2->num_rows;

            $book_data2 = $book_rs2->fetch_assoc();

            if ($book_data2['sale_price'] > 0) {
                $item_total = $book_data2["sale_price"] * $book_data2["cart_qty"];
            } else {
                $item_total = $book_data2["price"] * $book_data2["cart_qty"];
            }

            Database::iud("INSERT INTO `order_has_book`(`order_order_id`,`book_id`,`order_qty`,`item_total`) VALUES ('" . $order_id . "','" . $book_id . "','" . $book_qty . "','" . $item_total . "')");
        }

        $_SESSION["oid"] = $order_id;

        echo ("success");
    }
} else {
    echo ("Please Login");
}

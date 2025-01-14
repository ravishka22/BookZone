<?php

session_start();

include "connection.php";


if (isset($_SESSION["u"])) {
    $array = [];    

    $merchant_id = "1226914";
    $order_id = $_SESSION["oid"];
    $merchant_secret = "MTAzNzIwMjgzMjYyMzc0OTk0NTY1MTk1ODkwMTY0MDYwODY5NQ==";

    $order_rs = Database::search("SELECT * FROM `order` WHERE `order_id`='" . $order_id . "'");
    $order_num = $order_rs->num_rows;
    $order_data = $order_rs->fetch_assoc();
    $country = "Sri Lanka";

    $items = "BZ#00".$order_id;
    $amount = $order_data["total_cost"].".00";
    $currency = "LKR";
    $hash = strtoupper(
        md5(
            $merchant_id . 
            $order_id . 
            number_format($amount, 2, '.', '') . 
            $currency .  
            strtoupper(md5($merchant_secret)) 
        ) 
    );

    $user_email = $_SESSION["u"]["email"];

    $order_note = $_POST["onote"];

    $b_fname = $_POST["bfn"];
    $b_lname = $_POST["bln"];
    $b_email = $_POST["be"];
    $b_phone = $_POST["bp"];
    $b_line1 = $_POST["bl1"];
    $b_line2 = $_POST["bl2"];
    $b_province = $_POST["bpro"];
    $b_district = $_POST["bdis"];
    $b_city = $_POST["bc"];
    $b_pcode = $_POST["bpc"];

    $s_fname = $_POST["sfn"];
    $s_lname = $_POST["sln"];
    $s_line1 = $_POST["sl1"];
    $s_line2 = $_POST["sl2"];
    $s_province = $_POST["spro"];
    $s_district = $_POST["sdis"];
    $s_city = $_POST["sc"];
    $s_pcode = $_POST["spc"];

    $c_box = $_POST["cb"];



    $user_rs = Database::search("SELECT * FROM `users` WHERE `email`='" . $user_email . "'");
    $user_num = $user_rs->num_rows;
    if ($user_num == 1) {
        $user_data = $user_rs->fetch_assoc();
    }

    if (empty($b_fname)) {
        echo ("First name can't be Empty");
    } else if (empty($b_lname)) {
        echo ("Last name can't be Empty");
    } else if (empty($b_phone)) {
        echo ("Please enter your Mobie Number.");
    } else if (strlen($b_phone) != 10) {
        echo ("Mobile number must contain 10 characters.");
    } else if (empty($b_line1)) {
        echo ("Address line 01 can't be Empty");
    } else if (empty($b_province)) {
        echo ("Province can't be Empty");
    } else if (empty($b_district)) {
        echo ("District can't be Empty");
    } else if (empty($b_city)) {
        echo ("City can't be Empty");
    } else if (empty($b_pcode)) {
        echo ("Postal Code can't be Empty");
    } else if (strlen($order_note) > 500) {
        echo ("Order note must less than 500 characters");
    } else {

        if ($c_box == 1) {

            $delivery_address = $s_line1.", ".$s_line2.", ".$s_city.", ".$s_pcode;
            $delivery_city = $s_city;

            if (empty($s_fname)) {
                echo ("First name can't be Empty in Shipping Address");
            } else if (empty($s_lname)) {
                echo ("Last name can't be Empty in Shipping Address");
            } else if (empty($s_line1)) {
                echo ("Shipping Address line 01 can't be Empty");
            } else if (empty($s_province)) {
                echo ("Shipping Province can't be Empty");
            } else if (empty($s_district)) {
                echo ("Shipping District can't be Empty");
            } else if (empty($s_city)) {
                echo ("Shipping City can't be Empty");
            } else if (empty($s_pcode)) {
                echo ("Shipping Postal Code can't be Empty");
            }

            $address2_rs = Database::search("SELECT * FROM `users_address` 
            WHERE `users_email`='" . $user_email . "' AND `address_type`='2'");
            $address2_num = $address2_rs->num_rows;

            if ($address2_num > 0) {
                Database::iud("UPDATE `users_address` SET `line1`='" . $s_line1 . "',`line2`='" . $s_line2 . "',`city`='" . $s_city . "',
                `postal_code`='" . $s_pcode . "',`district_district_id`='" . $s_district . "' WHERE `users_email`='" . $user_email . "' 
                AND `address_type`='2'");
            } else {
                Database::iud("INSERT INTO `users_address`(`line1`,`line2`,`city`,`postal_code`,
                            `district_district_id`,`address_type`,`users_email`) 
                            VALUE('" . $s_line1 . "','" . $s_line2 . "','" . $s_city . "','" . $s_pcode . "',
                            '" . $s_district . "','2','" . $user_email . "')");
            }
        }

        $address1_rs = Database::search("SELECT * FROM `users_address` 
            WHERE `users_email`='" . $user_email . "' AND `address_type`='1'");
        $address1_num = $address1_rs->num_rows;

        if ($address1_num > 0) {
            Database::iud("UPDATE `users_address` SET `line1`='" . $b_line1 . "',`line2`='" . $b_line2 . "',`city`='" . $b_city . "',
                `postal_code`='" . $b_pcode . "',`district_district_id`='" . $b_district . "' WHERE `users_email`='" . $user_email . "' 
                AND `address_type`='1'");
        } else {
            Database::iud("INSERT INTO `users_address`(`line1`,`line2`,`city`,`postal_code`,
                            `district_district_id`,`address_type`,`users_email`) 
                            VALUE('" . $b_line1 . "','" . $b_line2 . "','" . $b_city . "','" . $b_pcode . "',
                            '" . $b_district . "','1','" . $user_email . "')");
        }
        
        echo ("success");

    }

    $address = $b_line1.", ".$b_line2.", ".$b_city.", ".$b_pcode;

    $delivery_address = $b_line1.", ".$b_line2.", ".$b_city.", ".$b_pcode;
    $delivery_city = $b_city;
    $delivery_country = "Sri Lanka";

    $array["merchant_id"] = $merchant_id;
    $array["order_id"] = $order_id;
    $array["items"] = $items;
    $array["amount"] = $amount;
    $array["currency"] = $currency;
    $array["hash"] = $hash;
    $array["first_name"] = $b_fname;
    $array["last_name"] = $b_lname;
    $array["email"] = $b_email;
    $array["phone"] = $b_phone;
    $array["address"] = $address;
    $array["city"] = $b_city;
    $array["country"] = $country;
    $array["delivery_address"] = $delivery_address;
    $array["delivery_city"] = $delivery_city;
    $array["delivery_country"] = $delivery_country;

    $jsonObj = json_encode($array);

    

} else {
}

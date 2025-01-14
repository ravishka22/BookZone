<?php

session_start();

include "connection.php";

$subtotal = 0;
$total = 0;
$shipping = 0;
$discount = 0;
$total_weight = 0;
$totitems = 1;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="icon" href="resourses/logo.svg" />

</head>

<body class="bg-light pb-0" onload="loadBillingDistricts(); loadShippingDistricts();">
    <?php
    if (isset($_SESSION["u"])) {

        $subtotal;
        $total;
        $shipping;
        $discount;

        if (isset($_SESSION["oid"]) && !empty($_SESSION["oid"])) {
            $user_email = $_SESSION["u"]["email"];
            $order_id = $_SESSION["oid"];

            $order_rs = Database::search("SELECT * FROM `order`  WHERE `order_id`='" . $order_id . "'");
            $order_num = $order_rs->num_rows;
            $order_data = $order_rs->fetch_assoc();

            $book_rs = Database::search("SELECT * FROM `book` INNER JOIN `order_has_book` ON book.id=order_has_book.book_id 
                                    WHERE `order_order_id`='" . $order_id . "'");
            $book_num = $book_rs->num_rows;

            $subtotal = $order_data["subtotal"];
            $total = $order_data["total_cost"];
            $shipping = $order_data["shipping_cost"];
            $discount = $order_data["discount"];
            $totitems = $book_num;


            $user_rs = Database::search("SELECT * FROM `users_address` INNER JOIN `users` 
        ON users.email=users_address.users_email INNER JOIN `district` 
        ON district.district_id=users_address.district_district_id
        WHERE `users`.`email`='$user_email' AND `address_type`='1'");
            $user_num = $user_rs->num_rows;

            if ($user_num == 1) {
                $user_data = $user_rs->fetch_assoc();
            }

            $user_rs2 = Database::search("SELECT * FROM `users_address` INNER JOIN `users` 
        ON users.email=users_address.users_email INNER JOIN `district` 
        ON district.district_id=users_address.district_district_id
        WHERE `users`.`email`='$user_email' AND `address_type`='1'");
            $user_num2 = $user_rs2->num_rows;

            if ($user_num2 == 1) {
                $user_data2 = $user_rs2->fetch_assoc();
            }

            include "header.php";
    ?>
            <div class="container p-3">
                <div class="row">
                    <div class="col-lg-8 col-12 p-3 min-vh-100 chekoutaddress">
                        <div class="bg-white p-4 rounded-3" style="height: auto;">
                            <h3>Checkout <span class="fs-6 text-primary"></h3>
                            <div class="row bg-white rounded-4 mt-4 gap-2">
                                <div class="px-4">
                                    <div class="row">
                                        <h5 class="text-secondary">Billing Details</h5>
                                    </div>
                                </div>

                                <div class="px-4 row gap-2">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="bafname" placeholder="" value="<?php if ($user_num == 1) {
                                                                                                                                echo $user_data["first_name"];
                                                                                                                            } else {
                                                                                                                                echo "";
                                                                                                                            } ?>">
                                                <label for="bafname">First name</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="balname" value="<?php if ($user_num == 1) {
                                                                                                                echo $user_data["last_name"];
                                                                                                            } else {
                                                                                                                echo "";
                                                                                                            } ?>">
                                                <label for="balname">Last name</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control disabled" disabled id="baemail" value="<?php if ($user_num == 1) {
                                                                                                                                    echo $user_data["email"];
                                                                                                                                } else {
                                                                                                                                    echo "";
                                                                                                                                } ?>">
                                                <label for="baemail">E-mail</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="phone" class="form-control" id="baphone" value="<?php if ($user_num == 1) {
                                                                                                                    echo $user_data["mobile"];
                                                                                                                } else {
                                                                                                                    echo "";
                                                                                                                } ?>">
                                                <label for="baphone">Phone Number</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row gap-2">
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" value="<?php if ($user_num == 1) {
                                                                                                    echo ($user_data["line1"]);
                                                                                                } else {
                                                                                                    echo "";
                                                                                                } ?>" id="baline1" placeholder="">
                                                <label for="baline1">Address Line 01</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" value="<?php if ($user_num == 1) {
                                                                                                    echo ($user_data["line2"]);
                                                                                                } else {
                                                                                                    echo "";
                                                                                                } ?>" id="baline2" placeholder="">
                                                <label for="baline2">Address Line 02</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-floating mb-3">
                                                <select class="form-control" name="province" id="baprovince" onchange="loadBillingDistricts();">
                                                    <option value="0">Select Province</option>
                                                    <?php
                                                    $user_province = $address_data["province_id"];
                                                    $province_rs = Database::search("SELECT * FROM `province`");
                                                    $province_num = $province_rs->num_rows;
                                                    for ($i = 0; $i < $province_num; $i++) {
                                                        $province_data = $province_rs->fetch_assoc();
                                                    ?>
                                                        <option <?php if ($user_num == 1) {
                                                                    if ($province_data["province_id"] == $user_data["province_id"]) {
                                                                ?>selected<?php
                                                                        }
                                                                    } else {
                                                                        echo "";
                                                                    } ?> value="<?php echo $province_data["province_id"]; ?>"><?php echo $province_data["province_name"]; ?></option>
                                                    <?php
                                                    }

                                                    ?>
                                                </select>
                                                <label for="baprovince">Province</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-floating mb-3">
                                                <select class="form-control" name="district" id="badistrict">
                                                    <option value="0">Select District</option>
                                                </select>
                                                <label for="badistrict">District</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" value="<?php if ($user_num == 1) {
                                                                                                    echo ($user_data["city"]);
                                                                                                } else {
                                                                                                    echo "";
                                                                                                } ?>" id="bacity" placeholder="">
                                                <label for="bacity">City</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" value="<?php if ($user_num == 1) {
                                                                                                        echo ($user_data["postal_code"]);
                                                                                                    } else {
                                                                                                        echo "";
                                                                                                    } ?>" id="bapcode" placeholder="">
                                                <label for="bapcode">Postal Code</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row px-4">
                                    <div class="d-flex flex-row my-auto gap-2 mb-2">
                                        <input type="checkbox" class="form-check-input form-check" onchange="activeShippingAddress(this);" name="" id="sAddressCheck">
                                        <label class="fs-5" for="sAddressCheck">Ship to a different address?</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-3 mt-3 d-none" id="saddressBox" style="height: auto;">
                            <div class="row bg-white rounded-4 gap-2">
                                <div class="px-4">
                                    <div class="row">
                                        <h5 class="text-secondary">Shipping Address</h5>
                                    </div>
                                </div>

                                <div class="px-4 row gap-2">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="shafname" placeholder="" value="<?php if ($user_num2 == 1) {
                                                                                                                                echo $user_data2["first_name"];
                                                                                                                            } else {
                                                                                                                                echo "";
                                                                                                                            } ?>">
                                                <label for="shafname">First name</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="shalname" placeholder="" value="<?php if ($user_num2 == 1) {
                                                                                                                                echo $user_data2["last_name"];
                                                                                                                            } else {
                                                                                                                                echo "";
                                                                                                                            } ?>">
                                                <label for="shalname">Last name</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row gap-2">
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" value="<?php if ($user_num2 == 1) {
                                                                                                    echo $user_data2["line1"];
                                                                                                } else {
                                                                                                    echo "";
                                                                                                } ?>" id="shaline1" placeholder="">
                                                <label for="shaline1">Address Line 01</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" value="<?php if ($user_num2 == 1) {
                                                                                                    echo $user_data2["line2"];
                                                                                                } else {
                                                                                                    echo "";
                                                                                                } ?>" id="shaline2" placeholder="">
                                                <label for="shaline2">Address Line 02</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-floating mb-3">
                                                <select class="form-control" name="province" id="shaprovince" onchange="loadShippingDistricts();">
                                                    <option value="0">Select Province</option>
                                                    <?php
                                                    $user_province = $address_data["province_id"];
                                                    $province_rs = Database::search("SELECT * FROM `province`");
                                                    $province_num = $province_rs->num_rows;
                                                    for ($i = 0; $i < $province_num; $i++) {
                                                        $province_data = $province_rs->fetch_assoc();
                                                    ?>
                                                        <option <?php if ($province_data["province_id"] == $user_data2["province_id"]) {
                                                                ?>selected<?php
                                                                        } ?> value="<?php echo $province_data["province_id"]; ?>"><?php echo $province_data["province_name"]; ?></option>
                                                    <?php
                                                    }

                                                    ?>
                                                </select>
                                                <label for="shaprovince">Province</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-floating mb-3">
                                                <select class="form-control" name="district" id="shadistrict">
                                                    <option value="0">Select District</option>
                                                </select>
                                                <label for="shadistrict">District</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" value="<?php if ($user_num2 == 1) {
                                                                                                    echo $user_data2["city"];
                                                                                                } else {
                                                                                                    echo "";
                                                                                                } ?>" id="shacity" placeholder="">
                                                <label for="shacity">City</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" value="<?php if ($user_num2 == 1) {
                                                                                                        echo $user_data2["postal_code"];
                                                                                                    } else {
                                                                                                        echo "";
                                                                                                    } ?>" id="shapcode" placeholder="">
                                                <label for="shapcode">Postal Code</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 p-3">
                        <!-- CUPONE CODE AREA -->
                        <!-- <div class="bg-white mb-3 p-4 rounded-3">
                        <h4>Coupon Code</h4>
                        <p>If you have a coupon code, please enter it in the box below</p>
                        <div class="d-flex flex-row align-items-center gap-2 w-100">
                            <input class="form-control focus-ring focus-ring-light" type="search" name="" id="">
                            <button class="btn btn-primary" type="submit">Apply</button>
                        </div>
                    </div> -->
                        <div class="bg-white p-4 rounded-3">
                            <h4>Order Summary</h4>
                            <p>Shipping cost is calculated based on weight of the books.</p>
                            <div class="mb-4">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Book Title</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cartTable" class="align-middle">
                                        <?php
                                        for ($i = 0; $i < $book_num; $i++) {
                                            $book_data = $book_rs->fetch_assoc();
                                        ?>
                                            <tr style="font-size: 14px;">
                                                <td><?php echo ($book_data["book_name"]); ?> <span class="fw-bold">x <?php echo ($book_data["order_qty"]); ?></span></td>
                                                <td class="text-end text-nowrap fw-semibold">Rs. <?php echo ($book_data["item_total"]) ?>.00</td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <div>
                                <table class="table">
                                    <tbody id="cartTable" class="align-middle">
                                        <tr>
                                            <td>Order Subtotal</td>
                                            <td class="text-end fw-semibold">Rs. <?php echo $subtotal ?>.00</td>

                                        </tr>
                                        <tr>
                                            <td>Discount</td>
                                            <td class="text-end fw-semibold">- Rs. <?php echo $discount ?>.00</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping Cost</td>
                                            <td class="text-end fw-semibold">+ Rs. <?php echo $shipping ?>.00</td>
                                        </tr>
                                        <tr class="fs-5">
                                            <th>Total Payment</th>
                                            <th class="text-end fw-semibold">Rs. <?php echo $total ?>.00</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" onclick="payNow(<?php echo ($order_id) ?>)" class="btn btn-primary btn-lg w-100">Pay Now</button>
                            <!-- <button type="button" class="btn btn-outline-secondary mt-2 w-100">Continue Shopping</button> -->
                        </div>
                        <div class="bg-white mt-3 p-4 rounded-3">
                            <h4>Order Note(Optional)</h4>
                            <!-- <p>If you have a coupon code, please enter it in the box below</p> -->
                            <div class="">
                            <textarea class="form-control focus-ring focus-ring-light" placeholder="Notes about your order, e.g. special notes for delivery. 500 characters max" name="orderNote" id="orderNote" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        } else {
            header("Location: index.php");
        }
    } else {
        header("Location: index.php");
    }
    ?>



    <?php
    include "footer.php";
    ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <!-- <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script> -->
    <script src="bootstrap.bundle.js"></script>
    <script src="https://kit.fontawesome.com/a039630b67.js" crossorigin="anonymous"></script>

</body>

</html>
<?php

session_start();

include "connection.php";

$user_email = $_SESSION["u"]["email"];

$book_rs = Database::search("SELECT * FROM `book` INNER JOIN `cart` ON cart.book_id=book.id 
            INNER JOIN `book_img` ON book_img.book_id=book.id WHERE `users_email`='" . $user_email . "'");
$book_num = $book_rs->num_rows;

$subtotal = 0;
$total = 0;
$shipping = 0;
$discount = 0;
$total_weight = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="icon" href="resourses/logo.svg" />

</head>

<body class="bg-light">
    <?php
    if (isset($_SESSION["u"])) {
        include "header.php";
    ?>
        <div class="container p-3">
            <div class="row">
                <div class="col-lg-8 col-12 p-3">
                    <div class="bg-white p-4 rounded-3 overflow-y-scroll" style="height: 70vh;">
                        <h3>Book Cart <span class="fs-6 text-primary"><?php echo $book_num; ?> items</span></h3>
                        <div class="table-responsive my-3">
                            <?php
                            if ($book_num == 0) {
                            ?>
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/evyuuwna.json" trigger="boomerang" state="morph-shopping-bag-open" style="width:200px;height:200px">
                                    </lord-icon>
                                    <h4 class='text-center'>Your cart is empty!</h4>
                                    <button type="button" onclick="location.href = 'index.php'" class="btn btn-primary">Continue Shopping</button>
                                </div>
                            <?php
                            } else {
                            ?>
                                <table class="table">
                                    <thead class="table-active">
                                        <tr class=" px-3">
                                            <!-- &nbsp; -->
                                            <th class="text-center" scope="col">Book</th>
                                            <th scope="col">&nbsp;</th>
                                            <th style="width:15%" scope="col">Quantity</th>
                                            <th style="width:20%" scope="col">Price</th>
                                            <th class="text-center" style="width:15%" scope="col">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cartTable" class="align-middle">
                                        <?php


                                        for ($i = 0; $i <  $book_num; $i++) {
                                            $book_data = $book_rs->fetch_assoc();

                                            $item_total;

                                            if ($book_data['sale_price'] > 0) {
                                                $item_total = $book_data["sale_price"] * $book_data["cart_qty"];
                                            } else {
                                                $item_total = $book_data["price"] * $book_data["cart_qty"];
                                            }

                                            $subtotal = $subtotal + $item_total;

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


                                            $total = $subtotal + $shipping - $discount;

                                        ?>
                                            <tr>
                                                <div class="" id="snackbar"></div>
                                                <td><img src="<?php echo $book_data["path"]; ?>" height="100px" alt=""></td>
                                                <td><?php echo $book_data["book_name"]; ?></td>
                                                <td class="text-center">
                                                    <input type="number" class="form-control w-75" value="<?php echo $book_data["cart_qty"]; ?>" onclick='check_value(<?php echo $book_data["quantity"]; ?>,this);' onkeyup='check_value(<?php echo $book_data["quantity"]; ?>,this);' onchange='updateCartQty(<?php echo $book_data["id"]; ?>,this);' id="bookQty">
                                                </td>
                                                <td class="text-nowrap"><span>Rs. <?php echo $item_total ?>.00</span></td>
                                                <td class="text-danger fs-5 text-center"><a style="cursor: pointer;" onclick="deleteFromCart(<?php echo $book_data['id']; ?>);"><i class="bi bi-trash"></i></a></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            <?php
                            }

                            ?>

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
                        <h4>Cart Summary</h4>
                        <p>Shipping cost is calculated based on weight of the books.</p>
                        <div>
                            <table class="table">
                                <tbody id="cartTable" class="align-middle">
                                    <tr>
                                        <td>Order Subtotal</td>
                                        <td class="text-end">Rs. <?php echo $subtotal ?>.00</td>

                                    </tr>
                                    <tr>
                                        <td>Discount</td>
                                        <td class="text-end">- Rs. <?php echo $discount ?>.00</td>
                                    </tr>
                                    <tr>
                                        <td>Shipping</td>
                                        <td class="text-end">+ Rs. <?php echo $shipping ?>.00</td>
                                    </tr>
                                    <tr class="fs-5">
                                        <th>Total</th>
                                        <th class="text-end fw-semibold">Rs. <?php echo $total ?>.00</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" onclick="checkout(0,<?php echo $item_total ?>,1,<?php echo $total_weight ?>);" class="btn btn-primary btn-lg w-100">Procceed to Checkout</button>
                        <button type="button" onclick="window.location.href = 'index.php'" class="btn btn-outline-secondary mt-2 w-100">Continue Shopping</button>
                    </div>
                </div>
            </div>
        </div>

    <?php
    } else {
        header("Location: index.php");
    }
    ?>



    <?php
    include "footer.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <script src="bootstrap.bundle.js"></script>
    <script src="https://kit.fontawesome.com/a039630b67.js" crossorigin="anonymous"></script>
</body>

</html>
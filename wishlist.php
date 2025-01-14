<?php

session_start();

include "connection.php";

$user_email = $_SESSION["u"]["email"];

$book_rs = Database::search("SELECT * FROM `book` INNER JOIN `wishlist` ON wishlist.book_id=book.id 
            INNER JOIN `book_img` ON book_img.book_id=book.id WHERE `users_email`='" . $user_email . "'");
$book_num = $book_rs->num_rows;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>

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
                <div class="col-12 p-3">
                    <div class="bg-white p-4 rounded-3 overflow-y-scroll align-items-center" style="height: 80vh;">
                        <h3>Wishlist <span class="fs-6 text-primary"><?php echo $book_num; ?> items</span></h3>
                        <div class="table-responsive my-3">
                            <?php
                            if ($book_num == 0) {
                            ?>
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/evyuuwna.json" trigger="boomerang" state="morph-shopping-bag-open" style="width:200px;height:200px">
                                    </lord-icon>
                                    <h4 class='text-center'>Your wishlist is empty!</h4>
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
                                            <th style="width:20%" scope="col">Price</th>
                                            <th style="width:20%" scope="col">Add to Cart</th>
                                            <th class="text-center" style="width:15%" scope="col">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cartTable" class="align-middle">
                                        <?php


                                        for ($i = 0; $i <  $book_num; $i++) {
                                            $book_data = $book_rs->fetch_assoc();
                                        ?>
                                            <tr>
                                                <div class="" id="snackbar"></div>
                                                <td><img src="<?php echo $book_data["path"]; ?>" height="100px" alt=""></td>
                                                <td><?php echo $book_data["book_name"]; ?></td>
                                                <td class="text-nowrap"><?php if ($book_data["quantity"] == 0) {
                                                                        ?><span class="text-danger text-decoration-none fw-semibold">Out Of Stock</span><?php
                                                                                                                                                    } else if (empty($book_data["sale_price"])) {
                                                                                                                                                        ?>Rs. <?php echo ($book_data["price"]); ?>.00
                                                    <?php
                                                                                                                                                    } else {
                                                    ?><span class="text-decoration-line-through fs-6">Rs. <?php echo ($book_data["price"]); ?>.00</span><br>Rs. <?php echo ($book_data["sale_price"]); ?>.00
                                                    <?php
                                                                                                                                                    }
                                                    ?></td>
                                                <td>
                                                    <input type="hidden" name="" value="" id="emptyIN">
                                                    <a type="button" class="btn btn-primary" id="1" style="cursor: pointer;" onclick="addToCart(<?php echo ($book_data['id']); ?>,this);">Add to Cart</a>
                                                </td>

                                                <td class="text-danger fs-5 text-center"><a style="cursor: pointer;" onclick="deleteFromWishlist(<?php echo ($book_data['id']); ?>);"><i class="bi bi-trash"></i></a></td>
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

            </div>
        </div>
    <?php
    } else {
        header("Location: login.php");
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
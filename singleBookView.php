<?php

include "connection.php";
session_start();

if (isset($_GET["id"])) {
    $bid = $_GET["id"];

    $book_rs = Database::search("SELECT * FROM `book` INNER JOIN `language` ON book.language_id=language.id 
                                                INNER JOIN `author` ON author.id=book.author_id WHERE book.id = '$bid'");
    $book_num = $book_rs->num_rows;

    $bimg_rs = Database::search("SELECT * FROM `book_img` WHERE book_id = '$bid'");
    $bimg_num = $bimg_rs->num_rows;

    $bcat_rs = Database::search("SELECT * FROM `category` INNER JOIN `book_has_category` ON
                                book_has_category.category_id=category.id WHERE book_has_category.`book_id`='$bid'");
    $bcat_num = $bcat_rs->num_rows;


    if ($bimg_num == 1) {
        $bimg_data = $bimg_rs->fetch_assoc();
    }

    if ($book_num == 1) {
        $book_data = $book_rs->fetch_assoc();
    }

    $book_price;
    if ($book_data['sale_price'] > 0) {
        $book_price = $book_data["sale_price"];
    } else {
        $book_price = $book_data["price"];
    }
    

    $offer_rate = round((($book_data["price"] - $book_data["sale_price"]) / $book_data["price"] * 100));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($book_data["book_name"]); ?></title>

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="icon" href="resourses/logo.svg" />
</head>

<body>
    <?php
    include "header.php";
    ?>
    <div class="container" style="margin-top: 50px; margin-bottom: 50px;">
        <div class="row my-3">
            <div class="col-12 col-lg-6">
                <?php if ($book_data["quantity"] == 0) {
                ?>
                    <span style="rotate: -90deg; margin-left: 0px; margin-top: 60px;" class="product-label text-bg-danger fs-5 text-white px-3 py-1 position-absolute">
                        Out Of Stock</span>
                <?php
                } else if (!$book_data["sale_price"] == 0) {
                ?>
                    <span style="rotate: -90deg; margin-left: 10px; margin-top: 40px;" class="product-label text-uppercase text-bg-success fs-5 text-white px-3 py-1 position-absolute">
                        <?php echo ($offer_rate); ?>% off</span>
                <?php
                } elseif ($book_data["book_status_id"] == 3) {
                ?>
                    <span style="rotate: -90deg; margin-left: 20px; margin-top: 40px;" class="product-label text-bg-warning fs-5 text-white px-3 py-1 position-absolute">
                        Featured</span>
                <?php
                } ?>
                <div class="align-content-center text-center mb-lg-0 mb-3">
                    <img src="<?php echo ($bimg_data["path"]); ?>" height="520px" alt="">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="shop.php">Books</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo ($book_data["book_name"]); ?></li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-3">
                    <div class="ratings text-warning fs-4">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                    </div>
                    <h5 class="mt-2">4.5 Stars | 12 Reviews</h5>
                </div>
                <div class="">
                    <h2 class="display-6 fw-medium"><?php echo ($book_data["book_name"]); ?></h2>
                </div>

                <div class="mb-3">
                    <h5 class="text-secondary fw-semibold">By <?php echo ($book_data["author_name"]); ?></h5>
                </div>
                <div class="">
                    <h2 class=" fw-semibold"><?php if ($book_data['sale_price'] > 0) { ?> <span class="text-decoration-line-through fs-6 text-danger">Rs. <?php echo ($book_data["price"]); ?>.00</span><br>
                            <span class="text-primary">Rs.<?php echo ($book_data["sale_price"]); ?>.00</span>
                            <span class="text-success">(<?php echo ($offer_rate); ?>% off)</span><?php
                                                                                                } else { ?> <span class="text-primary">Rs. <?php echo ($book_data["price"]); ?>.00</span><?php } ?>
                    </h2>
                </div>
                <div class="mt-3">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="d-flex justify-content-between gap-3 align-items-center">
                                <label for="bookQty" class="form-label fs-5 fw-medium mt-2">Quantity</label>
                                <input type="number" class="form-control w-25" value="1" onclick='check_value(<?php echo $book_data["quantity"]; ?>,this);' onkeyup='check_value(<?php echo $book_data["quantity"]; ?>,this);' id="bookQty" placeholder="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class=" ">
                                <h5 class="mt-2"><?php if ($book_data["quantity"] > 0) {
                                                    ?><span class="text-success"> In Stock</span>
                                    <?php
                                                    } else {
                                    ?><span class="text-danger"> Out of Stock</span>
                                    <?php
                                                    }
                                    ?> <span class="fs-6 text-dark"> Only <?php echo ($book_data["quantity"]); ?> Left</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="d-flex justify-content-between gap-3 align-items-center">
                                <button class="btn btn-primary w-100 py-2 fs-5" onclick="addToCart(<?php echo ($bid); ?>,bookQty);" id="addToCart"><i class="bi bi-cart-plus"></i>&nbsp; Add To Cart</button>
                            </div>
                            <div class="" id="snackbar"></div>
                        </div>
                        <div class="col-6 d-flex gap-4 align-items-center">
                            <div class=" py-2">
                                <button class="btn btn-success fs-5" onclick="checkout(<?php echo ($bid)?>,<?php echo ($book_price)?>,bookQty,<?php echo ($book_data['weight'])?>);" 
                                id="buyNow">Buy Now</button>
                            </div>
                            <div class=" py-2">
                                <a class="text-danger p-0 fs-3" style="cursor: pointer;" onclick="addToWishlist(<?php echo ($bid); ?>,this);" id="addToWishlist1"><i class="bi bi-heart"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="p-0">
                    <p class="m-0">Categories: <?php for ($x = 0; $x < $bcat_num; $x++) {
                                                    $bcat_data = $bcat_rs->fetch_assoc();
                                                    echo ($bcat_data["category_name"] . ", ");
                                                } ?></p>
                    <p class="">ISBN: <?php echo ($book_data["isbn"]) ?></p>
                </div>
                <div class="p-0">

                </div>
            </div>
        </div>
        <div class="row mt-5 mb-3">
            <div class="">
                <div class="sbvTab">
                    <ul class="nav nav-tabs fs-5 justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link active" id="bookDiscription" onclick="viewDiscriptionBox(this);">Discription</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="bookMoreDetails" onclick="viewMoreDetailsBox(this);">More Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="bookReview" onclick="viewReviewBox(this);">Reviews</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="d-block col-10" style="min-height: 300px;" id="discriptionBox">
                <p class=""><?php echo ($book_data["book_discription"]); ?></p>
            </div>
            <div class="d-none" style="min-height: 300px;" id="reviewBox">
            </div>
            <div class="d-none" style="min-height: 300px;" id="moreDetailsBox">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-5">
                        <div class="">
                            <h5>Book Details</h5>
                            <table class="table table-bordered table">
                                <tbody>
                                    <tr>
                                        <th>Author</th>
                                        <td><?php echo ($book_data["author_name"]); ?></td>
                                    </tr>
                                    <tr>
                                        <th>ISBN</th>
                                        <td><?php echo ($book_data["isbn"]); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Book Pages</th>
                                        <td><?php echo ($book_data["pages"]); ?> Pages</td>
                                    </tr>
                                    <tr>
                                        <th>Publisher</th>
                                        <td><?php echo ($book_data["publisher"]); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Book Published Date</th>
                                        <td><?php echo ($book_data["published_date"]); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Language</th>
                                        <td><?php echo ($book_data["language_name"]); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="">
                            <h5>Shipping Details</h5>
                            <table class="table table-bordered table">
                                <tbody>
                                    <tr>
                                        <th>Weight</th>
                                        <td><?php echo ($book_data["weight"]); ?>g</td>
                                    </tr>
                                    <tr>
                                        <th>Dimention</th>
                                        <td><?php echo ($book_data["dimention"]); ?>cm<sup>3</sup></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5 mt-3 mt-sm-0 mt-lg-0">
                        <div class="" style="min-height: 200px;">
                            <h5>About Author</h5>
                            <h5>Name: <span class="text-primary fw-bold"><?php echo ($book_data["author_name"]); ?></span></h5>
                            <p class="fs-6"><?php if (isset($book_data["author_discription"])) {
                                                echo ($book_data["author_discription"]);
                                            } else {
                                                echo ("No author discription available!");
                                            }
                                            ?></p>
                        </div>
                        <div class="">
                            <h5>Stock Details</h5>
                            <table class="table table-bordered table">
                                <tbody>
                                    <tr>
                                        <th>Quantity</th>
                                        <td><?php echo ($book_data["quantity"]); ?></td>
                                    </tr>
                                    <tr>
                                        <th>SKU</th>
                                        <td><?php echo ($book_data["sku"]); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>

    
    <?php
    include "footer.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
    <script src="bootstrap.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</body>

</html>
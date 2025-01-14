<?php

session_start();

require "connection.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Zone | Online Book Store</title>

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="icon" href="resourses/logo.svg" />


</head>

<body class="mb-0 pb-0">
    <?php
    include "header.php";
    ?>
    <div class="container py-4">
        <!-- Hero Section -->
        <?php

        $bcat_rs = Database::search("SELECT * FROM `category`");
        $bcat_num = $bcat_rs->num_rows;


        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        ?>

        <div class="row mb-5">
            <div class=" col-3">
                <div class=" bg-light h-100 rounded-4 d-none d-lg-block text-center p-3">
                    <h3>Categories</h3>
                    <hr>
                    <div class="overflow-y-auto" style="height: 50vh">
                        <ul class="nav flex-column text-start">
                            <?php for ($x = 0; $x < $bcat_num; $x++) {
                                $bcat_data = $bcat_rs->fetch_assoc(); ?>
                                <li class="nav-item btn btn-light btn-sm ps-3 text-start">
                                    <a class="nav-link p-1" style="font-size: 16px;" href="shop.php?cat=<?php echo ($bcat_data['id']) ?>"><?php echo ($bcat_data['category_name']) ?></a>
                                </li>
                            <?php
                            } ?>
                        </ul>
                    </div>

                </div>
            </div>
            <div class=" col-12 col-lg-9">
                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner rounded-4">
                        <div class="carousel-item active">
                            <img src="resourses/banners/banner (1).webp" class="d-block w-100" alt="Book Zone Banner 01">
                        </div>
                        <div class="carousel-item">
                            <img src="resourses/banners/banner (2).webp" class="d-block w-100" alt="Book Zone Banner 02">
                        </div>
                        <div class="carousel-item">
                            <img src="resourses/banners/banner (3).webp" class="d-block w-100" alt="Book Zone Banner 03">
                        </div>

                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Hero Section -->

        <!-- Sale Books -->
        <div class="row mt-5">
            <!-- Section Title -->
            <div class="container">
                <div class="row mb-4">
                    <div class="d-flex gap-3 justify-content-between bg-light py-2 px-4 rounded-3">
                        <h2 class="mt-2 fw-bold">Sale Books</h2>
                        <button type="button" class="btn my-auto btn-primary">
                            View All
                        </button>
                    </div>
                </div>
            </div>

            <!-- Section Items -->
            <div class="container">
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5">
                    <?php
                    $sale_book_rs = Database::search("SELECT * FROM `book` INNER JOIN `book_img` ON book_img.book_id=book.id ORDER BY `sale_price` DESC LIMIT 5");
                    $sale_book_num = $sale_book_rs->num_rows;

                    for ($x = 0; $x < $sale_book_num; $x++) {
                        $sale_book_data = $sale_book_rs->fetch_assoc();

                        $sale_author_rs = Database::search("SELECT * FROM `book` INNER JOIN `author` ON book.author_id=author.id WHERE book.id='" . $sale_book_data['id'] . "'");
                        $sale_author_num = $sale_author_rs->num_rows;

                        $sale_language_rs = Database::search("SELECT * FROM `book` INNER JOIN `language` ON book.language_id=language.id WHERE book.id='" . $sale_book_data['id'] . "'");
                        $sale_language_num = $sale_language_rs->num_rows;

                        $sale_author_data = $sale_author_rs->fetch_assoc();

                        $sale_added_time = $sale_book_data["book_added_date"];
                        $sale_current_time = $date;

                        $sale_d1 = new DateTime($sale_added_time);
                        $sale_d2 = new DateTime($sale_current_time);
                        $sale_interval = $sale_d2->diff($sale_d1);

                        $sale_offer_rate = round((($sale_book_data["price"] - $sale_book_data["sale_price"]) / $sale_book_data["price"] * 100));

                        if (!empty($sale_book_data["sale_price"])) {
                    ?>
                            <li class="nav-item my-1">
                                <div class=" col">
                                    <div class="product-grid bg-white text-center">
                                        <div class="product-image overflow-hidden position-relative">
                                            <a href="<?php echo "singleBookView.php?id=" . ($sale_book_data['id']) ?>" class="image d-block">
                                                <img class="" height="250px" src="<?php echo ($sale_book_data["path"]); ?>" alt="Book Image">
                                            </a>
                                            <?php if ($sale_book_data["quantity"]  == 0) {
                                            ?><span class=" product-label text-bg-danger fw-semibold text-uppercase text-white px-2 py-1 position-absolute">Out of Stock</span>
                                                <?php
                                            } else if (empty($sale_book_data["sale_price"])) {
                                                if ($sale_book_data["book_status_id"] == 3) {
                                                ?><span class=" product-label text-bg-warning fw-semibold text-uppercase text-white px-2 py-1 position-absolute">Featured</span>
                                                <?php
                                                }
                                            } else {
                                                ?><span class=" product-label text-bg-success fw-semibold text-uppercase text-white px-2 py-1 position-absolute">
                                                    <?php echo ($sale_offer_rate); ?>% off</span>
                                                <?php
                                            }
                                            if ($sale_interval->format('%d') < 10) {
                                                if ($sale_book_data["quantity"] > 0) {
                                                ?><span class="new-label text-bg-primary fw-semibold text-uppercase text-white px-2 py-1 position-absolute">New</span>
                                            <?php
                                                }
                                            }
                                            ?>

                                            <ul class="product-links p-0 m-0 position-absolute w-100">
                                                <li><a class="text-white" id="addToWishlist2" style="cursor: pointer;" onclick="addToWishlist(<?php echo ($sale_book_data['id']); ?>,this);"><i class="fa-regular fa-heart"></i></a></li>
                                                <li><a class="text-white" id="1" style="cursor: pointer;" onclick="addToCart(<?php echo ($sale_book_data['id']); ?>,this);"><i class="fas fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="product-content text-center pt-3">
                                            <h5 class="title fs-6 mb-1"><a href="<?php echo "singleBookView.php?id=" . ($sale_book_data['id']) ?>"><?php echo ($sale_book_data["book_name"]); ?></a></h5>
                                            <h6 class="author fs-6 mb-1"><a href="#"><?php echo ($sale_author_data["author_name"]); ?></a></h6>
                                            <!-- <div class="text-warning fs-6">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-half"></i>
                                                </div> -->
                                            <div class="price"><?php if ($sale_book_data["quantity"] == 0) {
                                                                ?><span class="text-danger text-decoration-none fw-semibold">Out Of Stock</span><?php
                                                                                                                                            } else  if (empty($sale_book_data["sale_price"])) {
                                                                                                                                                ?>Rs. <?php echo ($sale_author_data["price"]); ?>.00
                                                <?php
                                                                                                                                            } else {
                                                ?><span>Rs. <?php echo ($sale_author_data["price"]); ?>.00</span>Rs.
                                                    <?php echo ($sale_author_data["sale_price"]); ?>.00
                                                <?php
                                                                                                                                            }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                    <?php
                        }
                    }
                    ?>


                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div>
                <img src="resourses/banners/hp_banner.png" class="rounded-4" width="100%" alt="">
            </div>
        </div>

        <!-- New Books -->
        <div class="row mt-5">
            <!-- Section Title -->
            <div class="container">
                <div class="row mb-4">
                    <div class="d-flex gap-3 justify-content-between bg-light py-2 px-4 rounded-3">
                        <h2 class="mt-2 fw-bold">New Books</h2>
                        <button type="button" class="btn my-auto btn-primary">
                            View All
                        </button>
                    </div>
                </div>
            </div>

            <!-- Section Items -->
            <div class="container">
                <div class="row row-gap-lg-3 row-cols-lg-5 row-cols-md-3 row-cols-sm-3 row-cols-2">
                    <?php
                    $book_rs = Database::search("SELECT * FROM `book` INNER JOIN `book_img` ON book_img.book_id = book.id ORDER BY `id` DESC LIMIT 10");
                    $book_num = $book_rs->num_rows;

                    for ($x = 0; $x < $book_num; $x++) {
                        $book_data = $book_rs->fetch_assoc();

                        $author_rs = Database::search("SELECT * FROM `book` INNER JOIN `author` ON book.author_id=author.id WHERE book.id='" . $book_data['id'] . "'");
                        $author_num = $author_rs->num_rows;

                        $language_rs = Database::search("SELECT * FROM `book` INNER JOIN `language` ON book.language_id=language.id WHERE book.id='" . $book_data['id'] . "'");
                        $language_num = $language_rs->num_rows;

                        // $bimg_data = $bimg_rs->fetch_assoc();
                        $author_data = $author_rs->fetch_assoc();

                        $added_time = $book_data["book_added_date"];
                        $current_time = $date;

                        $d1 = new DateTime($added_time);
                        $d2 = new DateTime($current_time);
                        $interval = $d2->diff($d1);

                        $offer_rate = round((($book_data["price"] - $book_data["sale_price"]) / $book_data["price"] * 100));
                    ?>
                        <li class="nav-item my-2">
                            <div class="col">
                                <div class="product-grid bg-white text-center">
                                    <div class="product-image overflow-hidden position-relative">
                                        <a href="<?php echo "singleBookView.php?id=" . ($book_data['id']) ?>" class="image d-block">
                                            <img class="" height="250px" src="<?php echo ($book_data["path"]); ?>" alt="Book Image">
                                        </a>
                                        <?php if ($book_data["quantity"]   == 0) {
                                        ?><span class=" product-label text-bg-danger fw-semibold text-uppercase text-white px-2 py-1 position-absolute">Out of Stock</span>
                                            <?php
                                        } else if (empty($book_data["sale_price"])) {
                                            if ($book_data["book_status_id"] == 3) {
                                            ?><span class=" product-label text-bg-warning fw-semibold text-uppercase text-white px-2 py-1 position-absolute">Featured</span>
                                            <?php
                                            }
                                        } else {
                                            ?><span class=" product-label text-bg-success fw-semibold text-uppercase text-white px-2 py-1 position-absolute">
                                                <?php echo ($offer_rate); ?>% off</span>
                                            <?php
                                        }
                                        if ($interval->format('%d') < 10) {
                                            if ($book_data["quantity"] > 0) {
                                            ?><span class="new-label text-bg-primary fw-semibold text-uppercase text-white px-2 py-1 position-absolute">New</span>
                                        <?php
                                            }
                                        }
                                        ?>

                                        <ul class="product-links p-0 m-0 position-absolute w-100">
                                            <li><a class="text-white" id="addToWishlist2" style="cursor: pointer;" onclick="addToWishlist(<?php echo ($sale_book_data['id']); ?>,this);"><i class="bi bi-heart"></i></a></li>
                                            <li><a class="text-white" id="1" style="cursor: pointer;" onclick="addToCart(<?php echo ($book_data['id']); ?>,this);"><i class="fas fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-content text-center pt-3">
                                        <h5 class="title fs-6 mb-1"><a href="<?php echo "singleBookView.php?id=" . ($book_data['id']) ?>"><?php echo ($book_data["book_name"]); ?></a></h5>
                                        <h6 class="author fs-6 mb-1"><a href="#"><?php echo ($author_data["author_name"]); ?></a></h6>
                                        <!-- <div class="text-warning fs-6">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-half"></i>
                                            </div> -->
                                        <div class="price"><?php if ($book_data["quantity"] == 0) {
                                                            ?><span class="text-danger text-decoration-none fw-semibold">Out Of Stock</span><?php
                                                                                                                                        } else if (empty($book_data["sale_price"])) {
                                                                                                                                            ?>Rs. <?php echo ($author_data["price"]); ?>.00
                                            <?php
                                                                                                                                        } else {
                                            ?><span>Rs. <?php echo ($author_data["price"]); ?>.00</span>Rs. <?php echo ($author_data["sale_price"]); ?>.00
                                            <?php
                                                                                                                                        }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php
                    }
                    ?>

                </div>
            </div>
        </div>
        <div class="" id="snackbar"></div>

    </div>

    <?php
    include "footer.php";
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/a039630b67.js" crossorigin="anonymous"></script>
</body>

</html>
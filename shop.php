<?php

session_start();

require "connection.php";

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="icon" href="resourses/logo.svg" />
</head>

<body>
    <?php
    include "header.php";
    ?>
    <div class="container-fluid p-0">
        <div class="container py-4">
            <div class="row mb-5">
                <div class=" col-3">
                    <div class=" bg-light rounded-3 d-none d-lg-block text-start p-3">
                        <h4 class="text-center">Categories</h4>
                        <hr>
                        <?php
                        $bcat_rs = Database::search("SELECT * FROM `category`");
                        $bcat_num = $bcat_rs->num_rows;
                        ?>
                        <div class="overflow-y-auto" style="height: 60vh">
                            <ul class="nav flex-column text-start">
                                <li class="nav-item btn btn-light btn-sm ps-3 text-start">
                                    <a class="nav-link p-1" style="font-size: 16px;" href="shop.php">All Books</a>
                                </li>
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
                    <div class="mt-3 bg-light rounded-3 d-none d-lg-block text-start p-3">
                        <h4 class="text-center">Authors</h4>
                        <hr>
                        <?php
                        $ba_rs = Database::search("SELECT * FROM `author`");
                        $ba_num = $ba_rs->num_rows;
                        ?>
                        <div class="overflow-y-auto" style="height: 60vh">
                            <ul class="nav flex-column text-start">
                                <li class="nav-item btn btn-light btn-sm ps-3 text-start">
                                    <a class="nav-link p-1" style="font-size: 16px;" href="shop.php">All Books</a>
                                </li>
                                <?php for ($x = 0; $x < $ba_num; $x++) {
                                    $ba_data = $ba_rs->fetch_assoc(); ?>
                                    <li class="nav-item btn btn-light btn-sm ps-3 text-start">
                                        <a class="nav-link p-1" style="font-size: 16px;" href="shop.php?author=<?php echo ($ba_data['id']) ?>"><?php echo ($ba_data['author_name']) ?></a>
                                    </li>
                                <?php
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class=" col-12 col-lg-9">
                    <div class="row" id="shopBooksArea">
                        <?php

                        $title = "All Books";
                        $subtitle = "Explor our book collection";
                        $text;
                        $select;
                        $category;
                        $author;
                        $sortbytime = 1;

                        $query = "SELECT * FROM `book` INNER JOIN `book_img` ON book_img.book_id=book.id ";

                        if (isset($_GET["author"])) {
                            $author = $_GET["author"];
                            $query .= "WHERE `author_id` = '$author'";
                            $rs = Database::search("SELECT * FROM `author` WHERE `id`='" . $author . "'");
                            $data = $rs->fetch_assoc();
                            $title = $data['author_name'];
                            $subtitle = "Explor Books by " . $data['author_name'] . "";
                        }

                        if (isset($_GET["cat"])) {
                            $category = $_GET["cat"];
                            $query .= "INNER JOIN `book_has_category` ON book.id=book_has_category.book_id WHERE book_has_category.category_id = '$category'";
                            $rs = Database::search("SELECT `category_name` FROM `category` WHERE `id`='" . $category . "'");
                            $data = $rs->fetch_assoc();
                            $title = $data['category_name'];
                            $subtitle = "Explor Books in '" . $data['category_name'] . "' Category";
                        }


                        if (isset($_GET["t"]) && isset($_GET["c"])) {
                            $text = $_GET["t"];
                            $select = $_GET["c"];

                            if (!empty($text) && $select == 0) {
                                $query .= "WHERE `book_name` LIKE '%" . $text . "%'";
                                $title = "Search Books";
                                $subtitle = "Showing results for '" . $text . "'";
                            } else if (empty($text) && $select != 0) {

                                $query .= "INNER JOIN `book_has_category` ON book.id=book_has_category.book_id WHERE `category_id` ='" . $select . "'";
                                $title = "Search Books";
                                $rs = Database::search("SELECT `category_name` FROM `category` WHERE `id`='" . $select . "'");
                                $data = $rs->fetch_assoc();
                                $subtitle = "Showing results for Category: " . $data["category_name"] . "";
                            } else if (!empty($text) && $select != 0) {

                                $query .= "INNER JOIN `book_has_category` ON book.id=book_has_category.book_id WHERE `category_id` ='" . $select . "' AND `book_name` LIKE '%" . $text . "%'";
                                $title = "Search Books";
                                $rs = Database::search("SELECT `category_name` FROM `category` WHERE `id`='" . $select . "'");
                                $data = $rs->fetch_assoc();
                                $subtitle = "Showing results for '" . $text . "' & Category: " . $data["category_name"] . "";
                            }
                        }

                        if ($sortbytime == 1) {
                            $query .= " ORDER BY `book_added_date` DESC ";
                        }

                        if (isset($_GET["page"])) {
                            $pageno = $_GET["page"];
                        } else {
                            $pageno = 1;
                        }

                        ?>

                        <!-- Section Title -->
                        <div class="container">
                            <div class="row mb-4">
                                <div class="d-flex justify-content-between bg-light py-2 px-4 rounded-3">
                                    <div class="">
                                        <h2 class="mt-2 mb-0 fw-bold"><?php echo $title ?></h2>
                                        <p class="mb-2 mt-1"><?php echo $subtitle ?></p>
                                    </div>

                                    <select class="form-select h-auto w-auto my-auto" name="sort" id="sortSelector">
                                        <option value="1">Default Sorting</option>
                                        <option value="2">Sort By Latest</option>
                                        <option value="3">Sort By Stock</option>
                                        <option value="4">Price Low To High</option>
                                        <option value="5">Price High To Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Section Items -->
                        <div class="container">
                            <?php
                            $book_rs = Database::search($query);
                            $book_num = $book_rs->num_rows;

                            $results_per_page = 12;
                            $number_of_pages = ceil($book_num / $results_per_page);

                            $page_results = ($pageno - 1) * $results_per_page;
                            $selected_rs = Database::search($query . "LIMIT " . $results_per_page . " OFFSET " . $page_results . " ");
                            $selected_num = $selected_rs->num_rows;


                            if ($book_num == 0) {
                            ?>
                                <div class="row">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/ikowlvxp.json" trigger="loop" state="loop-cycle" style="width:200px;height:200px">
                                        </lord-icon>
                                        <h2 class="mt-2 mb-0 fw-bold">No Books Found</h>
                                    </div>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4">

                                    <?php

                                    for ($x = 0; $x < $selected_num; $x++) {
                                        $book_data = $selected_rs->fetch_assoc();

                                        $author_rs = Database::search("SELECT * FROM `book` INNER JOIN `author` ON book.author_id=author.id WHERE book.id='" . $book_data['id'] . "'");
                                        $author_num = $author_rs->num_rows;

                                        $language_rs = Database::search("SELECT * FROM `book` INNER JOIN `language` ON book.language_id=language.id WHERE book.id='" . $book_data['id'] . "'");
                                        $language_num = $language_rs->num_rows;

                                        $author_data = $author_rs->fetch_assoc();

                                        $added_time = $book_data["book_added_date"];
                                        $current_time = $date;

                                        $d1 = new DateTime($added_time);
                                        $d2 = new DateTime($current_time);
                                        $interval = $d2->diff($d1);

                                        $offer_rate = round((($book_data["price"] - $book_data["sale_price"]) / $book_data["price"] * 100));

                                        // if (!empty($book_data["sale_price"])) {
                                    ?>
                                        <li class="nav-item my-1">
                                            <div class=" col">
                                                <div class="product-grid bg-white text-center">
                                                    <div class="product-image overflow-hidden position-relative">
                                                        <a href="<?php echo "singleBookView.php?id=" . ($book_data['id']) ?>" class="image d-block">
                                                            <img class="" height="250px" src="<?php echo ($book_data["path"]); ?>" alt="Book Image">
                                                        </a>
                                                        <?php if ($book_data["quantity"]  == 0) {
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
                                                            <li><a class="text-white" id="addToWishlist2" style="cursor: pointer;" onclick="addToWishlist(<?php echo ($book_data['id']); ?>,this);"><i class="fa-regular fa-heart"></i></a></li>
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
                                                                                                                                                        } else  if (empty($book_data["sale_price"])) {
                                                                                                                                                            ?>Rs. <?php echo ($book_data["price"]); ?>.00
                                                            <?php
                                                                                                                                                        } else {
                                                            ?><span>Rs. <?php echo ($book_data["price"]); ?>.00</span>Rs.
                                                                <?php echo ($book_data["sale_price"]); ?>.00
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
                            <?php
                            }
                            ?>

                        </div>

                        <!-- Pagination -->
                        <div class="container">
                            <div class="mt-5">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item">
                                            <a class="page-link <?php if ($pageno <= 1) {
                                                                    echo ("disabled");
                                                                } ?> " <?php if ($pageno <= 1) {
                                                                        ?> href="#" <?php
                                                                            } else {
                                                                                ?> href="shop.php?page=<?php echo $pageno - 1 ?>
                                                                                <?php if(isset($_GET["t"])){echo ("&t=".$text);} ?>
                                                                                <?php if(isset($_GET["c"])){echo ("&c=".$select);}?>
                                                                                <?php if(isset($_GET["cat"])){echo ("&cat=".$category);}?>
                                                                                <?php if(isset($_GET["author"])){echo ("&author=".$author);}?>" <?php } ?> aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php

                                        for ($y = 1; $y <= $number_of_pages; $y++) {
                                            if ($y == $pageno) {
                                        ?>
                                                <li class="page-item active">
                                                    <a class="page-link" href="shop.php?page=<?php echo $y ?>
                                                                                <?php if(isset($_GET["t"])){echo ("&t=".$text);} ?>
                                                                                <?php if(isset($_GET["c"])){echo ("&c=".$select);}?>
                                                                                <?php if(isset($_GET["cat"])){echo ("&cat=".$category);}?>
                                                                                <?php if(isset($_GET["author"])){echo ("&author=".$author);}?>"><?php echo $y; ?></a>
                                                </li>
                                            <?php
                                            } else {
                                            ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="shop.php?page=<?php echo $y ?>
                                                                                <?php if(isset($_GET["t"])){echo ("&t=".$text);} ?>
                                                                                <?php if(isset($_GET["c"])){echo ("&c=".$select);}?>
                                                                                <?php if(isset($_GET["cat"])){echo ("&cat=".$category);}?>
                                                                                <?php if(isset($_GET["author"])){echo ("&author=".$author);}?>"><?php echo $y; ?></a>
                                                </li>
                                        <?php
                                            }
                                        }

                                        ?>
                                        <li class="page-item">
                                            <a class="page-link <?php if ($pageno >= $number_of_pages) {
                                                                    echo ("disabled");
                                                                } ?> " <?php if ($pageno >= $number_of_pages) {
                                                                        ?> href="#" <?php
                                                                            } else {
                                                                                ?> href="shop.php?page=<?php echo $pageno + 1 ?>
                                                                                <?php if(isset($_GET["t"])){echo ("&t=".$text);} ?>
                                                                                <?php if(isset($_GET["c"])){echo ("&c=".$select);}?>
                                                                                <?php if(isset($_GET["cat"])){echo ("&cat=".$category);}?>
                                                                                <?php if(isset($_GET["author"])){echo ("&author=".$author);}?>" <?php } ?> aria-label="Previous">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php
        include "footer.php";
        ?>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/a039630b67.js" crossorigin="anonymous"></script>
</body>

</html>
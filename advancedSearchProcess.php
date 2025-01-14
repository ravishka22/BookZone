<?php

session_start();

require "connection.php";

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");

$title = "All Books";
$subtitle = "Explor our book collection";
$search_text = $_POST["st"];
$category = $_POST["c"];
$author = $_POST["a"];
$language = $_POST["l"];
$min = $_POST["min"];
$max = $_POST["max"];
$pages_count = $_POST["pc"];
if (isset($_POST["sort"])) {
    $sort = $_POST["s"];
}else {
    $sort = 0;
}

if (isset($_POST["page"])) {
    $pageno = $_POST["page"];
} else {
    $pageno = 1;
}

if (empty($category)) {
    $query = "SELECT * FROM `book` INNER JOIN `book_img` ON book_img.book_id=book.id WHERE 1=1";
} else {
    $query = "SELECT * EXCEPT[category.id] FROM `book` INNER JOIN `book_img` ON book_img.book_id=book.id 
    INNER JOIN `book_has_category` ON book.id=book_has_category.book_id WHERE `category_id`='" . $category . "'";
}

if (!empty($search_text)) {
    $query .= " AND `book_name` LIKE '%" . $search_text . "%'";
}

if (!empty($author)) {
    $query .= " AND `author_id`='" . $author . "'";
}

if (!empty($language)) {
    $query .= " AND `language_id`='" . $language . "'";
}

if (!empty($min) && !empty($max)) {
    $query .= " AND `price` BETWEEN '$min' AND '$max'";
}

if ($pages_count == 1) {
    $query .= " AND `pages` BETWEEN '0' AND '100'";
} elseif ($pages_count == 2) {
    $query .= " AND `pages` BETWEEN '100' AND '250'";
} elseif ($pages_count == 3) {
    $query .= " AND `pages` BETWEEN '250' AND '500'";
} elseif ($pages_count == 4) {
    $query .= " AND `pages` BETWEEN '500' AND '1000'";
} elseif ($pages_count == 5) {
    $query .= " AND `pages` > '1000'";
}

if ($sort == 0) {
    $query .= " ORDER BY `id` DESC ";
} elseif ($sort == 1) {
    $query .= " ORDER BY `book_added_date` DESC ";
} elseif ($sort == 2) {
    $query .= " ORDER BY `sale_price` DESC ";
} elseif ($sort == 3) {
    $query .= " ORDER BY `price` DESC ";
} elseif ($sort == 4) {
    $query .= " ORDER BY `price` ASC ";
} elseif ($sort == 5) {
    $query .= " ORDER BY `book_name` ASC ";
} elseif ($sort == 6) {
    $query .= " ORDER BY `book_name` DESC ";
}



?>

<!-- Section Items -->

    

    <?php
    $book_rs = Database::search($query);
    $book_num = $book_rs->num_rows;

    $results_per_page = 8;
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

<!-- Pagination -->

    <div class="mt-5">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a style="cursor: pointer;" class="page-link <?php if ($pageno <= 1) {
                                            echo ("disabled");
                                        } ?> " <?php if ($pageno <= 1) {
                                                ?> href="#" <?php
                                                                                } else {
                                                                                    ?> onclick="advancedSearch(<?php echo $pageno - 1 ?>);" <?php } ?> aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php

                for ($y = 1; $y <= $number_of_pages; $y++) {
                    if ($y == $pageno) {
                ?>
                        <li class="page-item active">
                            <a style="cursor: pointer;" class="page-link" onclick="advancedSearch(<?php echo $y ?>);"><?php echo $y; ?></a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="page-item">
                            <a style="cursor: pointer;" class="page-link" onclick="advancedSearch(<?php echo $y ?>);" ><?php echo $y; ?></a>
                        </li>
                <?php
                    }
                }

                ?>
                <li class="page-item">
                    <a style="cursor: pointer;" class="page-link <?php if ($pageno >= $number_of_pages) {
                                            echo ("disabled");
                                        } ?> " <?php if ($pageno >= $number_of_pages) {
                                                ?> href="#" <?php
                                                                                } else {
                                                                                    ?> onclick="advancedSearch(<?php echo $pageno + 1 ?>);"<?php } ?> aria-label="Previous">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

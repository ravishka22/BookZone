<?php
require "connection.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Search</title>

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
                    <div class="row" id="advancedSearchArea">
                        <!-- Section Title -->
                        <div class="container">
                            <div class="row mb-4">
                                <div class="d-flex justify-content-between bg-light py-2 px-4 rounded-3">
                                    <div class="">
                                        <h2 class="my-2 fw-bold">Advanced Search</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row mb-4">
                                <div class="bg-light p-4 rounded-3">
                                    <form role="search">
                                        <div class="col-12 d-flex mb-3">
                                            <input class="form-control border-primary form-control-lg me-2 border-2 focus-ring focus-ring-light" id="aSearchText" name="t" type="search" placeholder="Type Keywords to Search..." aria-label="Search">
                                            <button class="btn btn-primary text-nowrap me-2" onclick="advancedSearch(1);" type="button">Search Books</button>
                                            <button class="btn btn-secondary text-nowrap" type="button" onclick="window.location.href = 'advanced-search.php'">Reset</button>
                                        </div>
                                        <div class="col-12 d-flex gap-3 mb-2">
                                            <div class="w-100">
                                                <select class="form-select border-primary me-2 w-100 md border-2 focus-ring focus-ring-light" name="c" id="aSearchCategory" type="search" aria-label="Default select example">
                                                    <option value="0" selected>All Categories</option>
                                                    <?php

                                                    $category_rs = Database::search("SELECT * FROM `category`");
                                                    $category_num = $category_rs->num_rows;

                                                    for ($i = 0; $i < $category_num; $i++) {
                                                        $category_data = $category_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo ($category_data["id"]); ?>"><?php echo ($category_data["category_name"]); ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="w-100">
                                                <select class="form-select border-primary me-2 w-100 md border-2 focus-ring focus-ring-light" name="a" id="aSearchAuthor" type="search" aria-label="Default select example">
                                                    <option value="0" selected>All Authors</option>
                                                    <?php

                                                    $author_rs = Database::search("SELECT * FROM `author`");
                                                    $author_num = $author_rs->num_rows;

                                                    for ($i = 0; $i < $author_num; $i++) {
                                                        $author_data = $author_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo ($author_data["id"]); ?>"><?php echo ($author_data["author_name"]); ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="w-100">
                                                <select class="form-select border-primary me-2 w-100 md border-2 focus-ring focus-ring-light" name="l" id="aSearchLanguage" type="search" aria-label="Default select example">
                                                    <option value="0" selected>All Languages</option>
                                                    <?php

                                                    $language_rs = Database::search("SELECT * FROM `language`");
                                                    $language_num = $language_rs->num_rows;

                                                    for ($i = 0; $i < $language_num; $i++) {
                                                        $language_data = $language_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo ($language_data["id"]); ?>"><?php echo ($language_data["language_name"]); ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex gap-3">
                                            <?php
                                            $min_rs = Database::search("SELECT MIN(`price`) FROM `book`");
                                            $min_data = $min_rs->fetch_assoc();
                                            $min = $min_data['MIN(`price`)'];

                                            $max_rs = Database::search("SELECT MAX(`price`) FROM `book`");
                                            $max_data = $max_rs->fetch_assoc();
                                            $max = $max_data['MAX(`price`)'];
                                            ?>
                                            <div class="w-100">
                                                <label class="form-label mb-0" for="minPrice">Min Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text border-primary border-2">Rs. </span>
                                                    <input onchange="checkValue(<?php echo ($min); ?>,<?php echo ($max); ?>,this);" class="form-control border-primary border-end-0 border-start-0 border-2 text-end focus-ring focus-ring-light" value="<?php echo ($min); ?>" type="number" name="" id="minPrice">
                                                    <span class="input-group-text border-primary border-2">.00</span>
                                                </div>
                                            </div>
                                            <div class="w-100">
                                                <label class="form-label mb-0" for="maxPrice">Max Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text border-primary border-2">Rs. </span>
                                                    <input onchange="checkValue(<?php echo ($min); ?>,<?php echo ($max); ?>,this);" class="form-control border-primary border-end-0 border-start-0 text-end border-2 focus-ring focus-ring-light" value="<?php echo ($max); ?>" type="number" name="" id="maxPrice">
                                                    <span class="input-group-text border-primary border-2">.00</span>
                                                </div>
                                            </div>
                                            <div class="w-100">
                                                <label class="form-label mb-0" for="maxPrice">Pages Count</label>
                                                <select class="form-select border-primary me-2 w-100 md border-2 focus-ring focus-ring-light" name="pages" id="selectPagesCount" type="search" aria-label="Default select example">
                                                    <option value="0" selected>Any Number Of Pages</option>
                                                    <option value="1">0 - 100 Pages</option>
                                                    <option value="2">100 - 250 Pages</option>
                                                    <option value="3">250 - 500 Pages</option>
                                                    <option value="4">500 - 1000 Pages</option>
                                                    <option value="5">More than 1000 Pages</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Section Items -->
                        <div class="row mb-4">
                            <div class="d-flex justify-content-between bg-light p-4 rounded-3">
                                <p class="mb-2 mt-1">Explor our book collection</p>
                                <select class="form-select h-auto w-auto my-auto" onchange="advancedSearch(1);" name="sort" id="aSearchSortSelector">
                                    <option value="0">Default Sorting</option>
                                    <option value="1">Sort by Latest</option>
                                    <option value="2">Sort by Discount</option>
                                    <option value="3">Sort by Price: Low To High</option>
                                    <option value="4">Sort by Price: High To Low</option>
                                    <option value="5">Sort by Name: A - Z</option>
                                    <option value="6">Sort by Name: Z - A</option>
                                </select>
                            </div>
                        </div>
                        <div class="container" id="advancedSearchResults">
                            <div class="row">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/ikowlvxp.json" trigger="loop" state="loop-cycle" style="width:200px;height:200px">
                                    </lord-icon>
                                    <h2 class="mt-2 mb-0 fw-bold">No Items Searched Yet...</h>
                                </div>
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
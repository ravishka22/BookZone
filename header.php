<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>

    <div class=" col-12  bg-white">
        <!-- Top Bar -->
        <div class="topbar  bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-6 col-md-7 col-lg-8 d-flex flex-row my-2 align-items-center">
                        <lord-icon class="d-flex d-md-none d-lg-flex" src="https://cdn.lordicon.com/rsvfayfn.json" trigger="loop" delay="500" colors="primary:#e83a30" style="width:50px;"></lord-icon>
                        <a href="tel:+94786111312" class="d-flex d-md-none d-lg-flex nav-link fw-semibold fs-4 text-primary me-lg-3"> 0786111312 </a>
                        <ul class="nav d-none d-md-flex d-lg-flex d-xl-flex">
                            <li class="nav-item">
                                <a class="nav-link active text-black" aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-black" href="shop.php">Shop</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-black" href="cart.php">Cart</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-black" href="#">Support</a>
                            </li>
                        </ul>
                    </div>
                    <div class=" col-6 col-md-5 col-lg-4 d-flex flex-row justify-content-end align-items-center my-2 nobtnout">

                        <lord-icon src="https://cdn.lordicon.com/kthelypq.json" trigger="hover" colors="primary:#0d6efd" style="width:50px;"></lord-icon>
                        <button type="button" class="btn p-0 align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php
                            if (isset($_SESSION["u"])) {
                                $session_data = $_SESSION["u"];
                            ?>
                                <span>Hello! <?php echo $session_data["first_name"]; ?></span>
                            <?php
                            } else {
                            ?>
                                <span>User Account</span>
                            <?php
                            }
                            ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php
                            if (isset($_SESSION["u"])) {
                                $session_data = $_SESSION["u"];

                                if ($session_data["user_type_id"] == 1) {
                            ?>
                                    <li><a class="dropdown-item" href="admin-dashboard.php">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="my-account.php">My Account</a></li>
                                    <li><a class="dropdown-item" href="myorders.php">My Orders</a></li>
                                    <li><a class="dropdown-item" href="wishlist.php">Wishlist</a></li>
                                <?php
                                } else {
                                ?>
                                    <li><a class="dropdown-item" href="my-account.php">My Account</a></li>
                                    <li><a class="dropdown-item" href="myorders.php">My Orders</a></li>
                                    <li><a class="dropdown-item" href="wishlist.php">Wishlist</a></li>
                                <?php
                                }
                                ?>
                            <?php
                            } else {
                            ?>
                                <li><a class="dropdown-item disabled" aria-disabled="true" href="myAccount.php">My Account</a></li>
                                <li><a class="dropdown-item disabled" aria-disabled="true" href="myorders.php">My Orders</a></li>
                                <li><a class="dropdown-item disabled" aria-disabled="true" href="wishlist.php">Wishlist</a></li>
                            <?php
                            }
                            ?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <?php
                            if (isset($_SESSION["u"])) {
                                $session_data = $_SESSION["u"];
                            ?>
                                <li><a class="dropdown-item" href="#" onclick="signout();">Logout</a></li>
                            <?php
                            } else {
                            ?>
                                <li><a class="dropdown-item" href="login.php">Login</a></li>
                            <?php
                            }
                            ?>

                        </ul>

                        <span></span>
                    </div>


                </div>
            </div>
        </div>
        <!-- Top Bar -->

        <!-- Middle Bar -->
        <nav class="middlebar border-bottom border-1">
            <div class="container my-3">
                <div class="row d-grid d-flex justify-content-between align-content-center flex-lg-row flex-sm-row flex-md-row">
                    <div class=" col-lg-4 col-md-2 col-6 align-content-center">
                        <a class="navbar-brand d-none d-md-none d-lg-block d-xl-block" href="index.php">
                            <img src="resourses/logo2.svg" alt="Logo" height="50" class="d-inline-block align-text-center">
                        </a>
                        <a class="navbar-brand d-block d-md-block d-lg-none d-xl-none" href="index.php">
                            <img src="resourses/logo.svg" alt="Logo" height="50" class="d-inline-block align-text-center">
                        </a>
                    </div>
                    <div class="col-lg-6 col-md-8 col-12 text-center align-content-center d-none d-lg-block d-md-block">
                        <form class="d-flex" role="search" action="shop.php" method="get">
                            <input class="form-control me-2 border-primary border-2 focus-ring focus-ring-primary" name="t"  id="h_search" type="search" placeholder="Search" aria-label="Search">
                            <select class="form-select border-primary me-2 w-auto md border-2 focus-ring focus-ring-light" name="c" id="h_cat_select" type="search" aria-label="Default select example">
                                <option value="0" selected>All</option>
                                <?php

                                $category_rs = Database::search("SELECT * FROM `category`");
                                $category_num = $category_rs->num_rows;

                                for ($i = 0; $i < $category_num; $i++) {
                                    $category_data = $category_rs->fetch_assoc();
                                ?>
                                    <option value="<?php echo($category_data["id"]); ?>"><?php echo($category_data["category_name"]); ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <div class="btn-group nobtnout">
                                <button class="btn btn-primary" type="submit">
                                    <lord-icon src="https://cdn.lordicon.com/kkvxgpti.json" trigger="hover" colors="primary:#ffffff" style="width:30px;"></lord-icon>
                                </button>
                                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="advanced-search.php">Advance Search</a></li>
                                </ul>
                            </div>
                        </form>
                    </div>
                    <div class=" col-lg-2 col-md-2 col-6 mt-3 text-end align-content-center gx-0 nobtnout">
                        <!-- Wishlist -->
                        <button class="btn p-0" type="button" onclick="window.location.href='wishlist.php'">
                            <lord-icon src="https://cdn.lordicon.com/xyboiuok.json" trigger="hover" style="width:40px;height:40px" colors="primary:#0d6efd">
                            </lord-icon>
                        </button>
                        <!-- <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasWishlist" aria-labelledby="offcanvasWishlistLabel">
                            <div class="offcanvas-header bg-light">
                                <h5 class="offcanvas-title" id="offcanvasWishlistLabel">Wishlist</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                ...
                            </div>
                        </div> -->
                        <!-- Wishlist -->
                        <!-- Cart -->
                        <?php
                        if (isset($_SESSION["u"])) {
                        ?>
                            <button class="btn p-0" onclick="window.location.href='cart.php'" type="button">
                                <lord-icon src="https://cdn.lordicon.com/evyuuwna.json" trigger="hover" colors="primary:#0d6efd" style="width:40px;height:40px">
                                </lord-icon>
                            </button>
                        <?php
                        } else {
                        ?>
                            <button class="btn p-0" onclick="window.location.href='login.php'" type="button">
                                <lord-icon src="https://cdn.lordicon.com/evyuuwna.json" trigger="hover" colors="primary:#0d6efd" style="width:40px;height:40px">
                                </lord-icon>
                            </button>
                        <?php
                        }
                        ?>
                        <!-- <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
                            <div class="offcanvas-header bg-light">
                                <h5 class="offcanvas-title" id="offcanvasCartLabel">Cart</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body text-center align-content-start p-0">
                                <div class=" text-center align-self-start h-75 mt-2  pt-3">
                                    <span class="">No products in the cart.</span>
                                    <lord-icon src="https://cdn.lordicon.com/evyuuwna.json" trigger="boomerang" state="morph-shopping-bag-open" style="width:250px;height:350px">
                                    </lord-icon>
                                </div>
                                <div class="d-flex container flex-row justify-content-between px-5 py-2">
                                    <span class="fw-semibold fs-4">Sub Total</span>
                                    <span class="fw-semibold fs-4">Rs.000.00</span>
                                </div>

                                <div class="d-flex flex-row justify-content-center gap-5 py-3 bg-light align-content-center">
                                    <button class="btn btn-dark btn-lg" type="button">View Cart</button>
                                    <button class="btn btn-dark btn-lg" type="button">Checkout</button>
                                </div>

                            </div>
                        </div> -->
                        <!-- Cart -->
                        <!-- Mobile Menu -->
                        <button class="btn p-0 d-lg-none d-md-none d-xl-none" type="button" data-bs-toggle="offcanvasMenu" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                            <lord-icon src="https://cdn.lordicon.com/eouimtlu.json" trigger="hover" colors="primary:#0d6efd" style="width:40px;height:40px">
                            </lord-icon>
                        </button>
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
                            <div class="offcanvas-header bg-light">
                                <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body justify-content-sm-start">
                                <ul class="navbar-nav text-start flex-grow-1 pe-3">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Link</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Dropdown
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                            <li><a class="dropdown-item" href="#">Another action</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                                        </ul>
                                    </li>
                                </ul>
                                <form class="d-flex mt-3" role="search">
                                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                                    <button class="btn btn-outline-success" type="submit">Search</button>
                                </form>
                            </div>
                        </div>
                        <!-- Mobile Menu -->


                    </div>
                </div>


            </div>

        </nav>
        <!-- Middle Bar -->

    </div>

    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>

</html>
<?php

session_start();

include "connection.php";

if (isset($_SESSION["u"])) {

    $user_email = $_SESSION["u"]["email"];
    $user_rs = Database::search("SELECT * FROM `users` INNER JOIN `user_type` ON user_type.user_type_id=users.user_type_id 
    WHERE email='$user_email'");
    $user_data = $user_rs->fetch_assoc();

    $total_rs = Database::search("SELECT SUM(total_cost) FROM `order` WHERE `order_status_id` < '5'");
    $total_num = $total_rs->num_rows;
    $total = $total_rs->fetch_assoc();

    $total_order_rs = Database::search("SELECT * FROM `order`");
    $total_order_num = $total_order_rs->num_rows;

    $subtotal_rs = Database::search("SELECT SUM(subtotal) FROM `order` WHERE `order_status_id` < '5'");
    $subtotal_num = $subtotal_rs->num_rows;
    $subtotal = $subtotal_rs->fetch_assoc();

    $shipping_rs = Database::search("SELECT SUM(shipping_cost) FROM `order` WHERE `order_status_id` < '5'");
    $shipping_num = $shipping_rs->num_rows;
    $shipping = $shipping_rs->fetch_assoc();

    $book_rs = Database::search("SELECT * FROM `book`");
    $book_num = $book_rs->num_rows;

    $category_rs = Database::search("SELECT * FROM `category`");
    $category_num = $category_rs->num_rows;

    $author_rs = Database::search("SELECT * FROM `author`");
    $author_num = $author_rs->num_rows;

    $language_rs = Database::search("SELECT * FROM `language`");
    $language_num = $language_rs->num_rows;

    $tot_cus = Database::search("SELECT * FROM `users` WHERE `user_type_id`='2'");
    $tot_cus_num = $tot_cus->num_rows;

    $active_cus = Database::search("SELECT * FROM `users` WHERE `user_type_id`='2' AND `status`='1'");
    $active_cus_num = $active_cus->num_rows;

    $male_cus = Database::search("SELECT * FROM `users` WHERE `user_type_id`='2' AND `gender_id`='1'");
    $male_cus_num = $male_cus->num_rows;

    $female_cus = Database::search("SELECT * FROM `users` WHERE `user_type_id`='2' AND `gender_id`='2'");
    $female_cus_num = $female_cus->num_rows;

    $in_stock = Database::search("SELECT * FROM `book` WHERE `quantity`>'1'");
    $in_stock_num = $in_stock->num_rows;

    $low_stock = Database::search("SELECT * FROM `book` WHERE `quantity`<='5'");
    $low_stock_num = $low_stock->num_rows;

    $out_stock = Database::search("SELECT * FROM `book` WHERE `quantity`='0'");
    $out_stock_num = $out_stock->num_rows;

    $total_stock_rs = Database::search("SELECT SUM(quantity) FROM `book`");
    $total_stock_num = $total_stock_rs->num_rows;
    $total_stock = $total_stock_rs->fetch_assoc();

    if ($user_data["user_type_id"] == 1) {
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Reports</title>

            <link rel="stylesheet" href="style.css" />
            <link rel="stylesheet" href="bootstrap.css" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
            <link rel="icon" href="resourses/logo.svg" />

        </head>

        <body class="admin-body">
            <div class="container-fluid bg-light min-vh-100">
                <div class="row">
                    <div class="col-3 d-none d-lg-block">
                        <?php
                        include "admin-sidebar.php";
                        ?>
                    </div>
                    <div class="col-12 col-lg-9 p-0">
                        <div class="admin-header bg-white">
                            <div class="p-3 d-flex gap-2 align-items-center">
                                <button class="btn btn-primary headerbtn d-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminMenu" aria-controls="adminMenu">
                                    <i class="bi bi-list"></i></i>&nbsp;Menu
                                </button>
                                <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="adminMenu" aria-labelledby="adminMenuLabel">
                                    <div class="offcanvas-header bg-white">
                                        <a class="navbar-brand" href="index.php">
                                            <img src="resourses/logo2.svg" alt="Logo" height="50" class="d-inline-block align-text-center">
                                        </a>
                                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body justify-content-sm-start">
                                        <?php
                                        include "admin-offcanvas.php";
                                        ?>
                                    </div>
                                </div>
                                <a class="navbar-brand d-none d-lg-block" href="index.php">
                                    <img src="resourses/logo.svg" alt="Logo" height="50" class="d-inline-block align-text-center">
                                </a>
                                <h2 class="mb-0">Reports</h2>
                            </div>
                            <div class="p-3 d-flex gap-2 align-items-center">
                                <button class="btn btn-primary headerbtn" onclick="window.location.href='shop.php'" type="button"><i class="bi bi-book"></i>&nbsp; All Books</button>
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="row">
                                <div class="d-flex gap-3 mb-3">
                                    <button type="button" onclick="showOrdersReport();" class="btn btn-lg btn-dark w-100">Orders</button>
                                    <button type="button" onclick="showBooksReport();" class="btn btn-lg btn-dark w-100">Books</button>
                                    <button type="button" onclick="showCustomersReport();" class="btn btn-lg btn-dark w-100">Customers</button>
                                    <button type="button" onclick="showStockReport();" class="btn btn-lg btn-dark w-100">Stock</button>
                                </div>
                            </div>

                            <div class="row d-block" id="orderReport">
                                <di class="col-12 p-2">
                                    <div class="bg-white pt-3 pb-1 text-center rounded-4">
                                        <h2 class="fw-bold">Orders Report</h2>
                                    </div>
                                </di>
                                <di class="col-12 p-2">
                                    <div class="bg-white pt-3 pb-1 d-flex text-center rounded-4">
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <h6>Total Sales</h6>
                                            <h2 class="fw-semibold fs-2"><span class="fs-6 fw-normal">Rs. </span><?php echo ($total['SUM(total_cost)']) ?><span class="fs-6 fw-normal">.00</span></h2>
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <h6>Net Sales</h6>
                                            <h2 class="fw-semibold fs-2"><span class="fs-6 fw-normal">Rs. </span><?php echo ($subtotal['SUM(subtotal)']) ?><span class="fs-6 fw-normal">.00</span></h2>
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <h6>Total Shipping</h6>
                                            <h2 class="fw-semibold fs-2"><span class="fs-6 fw-normal">Rs. </span><?php echo ($shipping['SUM(shipping_cost)']) ?><span class="fs-6 fw-normal">.00</span></h2>
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <h6>Total Orders</h6>
                                            <h2 class="fw-semibold fs-2"><?php echo ($total_order_num) ?></h2>
                                        </div>
                                    </div>
                                </di>
                                <di class="col-12 p-2">
                                    <div class="bg-white p-4 rounded-4">
                                        <div>
                                            <h5>All Orders</h5>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-center">
                                                        <!-- &nbsp; -->
                                                        <th scope="col">Order ID</th>
                                                        <th scope="col">Customer</th>
                                                        <th scope="col">Order Date</th>
                                                        <th scope="col">Stetus</th>
                                                        <th scope="col">Ship to</th>
                                                        <th scope="col">Shipping</th>
                                                        <th scope="col">Total</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="languageTable">
                                                    <?php
                                                    $query = "SELECT * FROM `order` INNER JOIN `order_status` ON order_status.order_status_id=order.order_status_id
                                                    INNER JOIN `users` ON order.users_email=users.email INNER JOIN `users_address` ON users_address.users_email=users.email 
                                                    WHERE address_type='2'";

                                                    $query .= " ORDER BY `order_date` DESC ";

                                                    $order_rs = Database::search($query);
                                                    $order_num = $order_rs->num_rows;

                                                    for ($x = 0; $x < $order_num; $x++) {
                                                        $order_data = $order_rs->fetch_assoc();
                                                    ?>
                                                        <tr class="text-center text-nowrap">
                                                            <th scope="row">BZ#0<?php echo $order_data["order_id"]; ?></th>
                                                            <td><?php echo $order_data["first_name"]; ?> <?php echo $order_data["last_name"]; ?></td>
                                                            <td class=""><?php echo $order_data["order_date"]; ?></td>
                                                            <td><span class="badge rounded-pill px-3 py-2 fw-normal text-bg-<?php
                                                                                                                            if ($order_data["order_status"] == "Pending") {
                                                                                                                                echo "info";
                                                                                                                            } elseif ($order_data["order_status"] == "Processing") {
                                                                                                                                echo "warning";
                                                                                                                            } elseif ($order_data["order_status"] == "Returned") {
                                                                                                                                echo "primary";
                                                                                                                            } elseif ($order_data["order_status"] == "Completed") {
                                                                                                                                echo "success";
                                                                                                                            } elseif ($order_data["order_status"] == "Canselled") {
                                                                                                                                echo "danger";
                                                                                                                            }
                                                                                                                            ?>"><?php echo ($order_data["order_status"]) ?></span></td>
                                                            <td class="text-center"><?php echo $order_data["city"]; ?></td>
                                                            <td>Rs. <?php echo $order_data["shipping_cost"]; ?>.00</td>
                                                            <td>Rs. <?php echo $order_data["total_cost"]; ?>.00</td>
                                                            <td class="text-center">
                                                                <button class="btn btn-sm btn-primary" onclick="window.location.href = 'singleOrder.php?order_id=<?php echo $order_data['order_id']; ?>'">View</button>

                                                            </td>
                                                        </tr>
                                                    <?php

                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </di>
                            </div>

                            <div class="row d-none" id="booksReport">
                                <di class="col-12 p-2">
                                    <div class="bg-white pt-3 pb-1 text-center rounded-4">
                                        <h2 class="fw-bold">Books Report</h2>
                                    </div>
                                </di>
                                <di class="col-12 p-2">
                                    <div class="bg-white pt-3 pb-1 d-flex text-center rounded-4">
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <h6>Total Books</h6>
                                            <h2 class="fw-semibold fs-2"><?php echo ($book_num) ?></h2>
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <h6>Total Categories</h6>
                                            <h2 class="fw-semibold fs-2"><?php echo ($category_num) ?></h2>
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <h6>Total Authors</h6>
                                            <h2 class="fw-semibold fs-2"><?php echo ($author_num) ?></h2>
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <h6>Total Languages</h6>
                                            <h2 class="fw-semibold fs-2"><?php echo ($language_num) ?></h2>
                                        </div>
                                    </div>
                                </di>
                                <di class="col-12 p-2">
                                    <div class="bg-white p-4 rounded-4">
                                        <div>
                                            <h5>All Books</h5>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" width="10%">ID</th>
                                                        <th scope="col" width="10%">&nbsp;</th>
                                                        <th scope="col" width="20%">Book Name&nbsp;</th>
                                                        <th scope="col" width="10%" class="px-2">Author</th>
                                                        <th scope="col" width="10%" class="px-2">Language</th>
                                                        <th scope="col" width="10%" class="px-2">Price</th>
                                                        <th scope="col" width="10%" class="text-center">Pages</th>
                                                        <!-- <th scope="col" class="text-center"><i class="bi bi-star-fill"></i></th> -->
                                                        <th scope="col" width="10%" class="px-2">Categories</th>
                                                        <th scope="col" width="10%" class="text-end">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="languageTable">
                                                    <?php
                                                    $book_rs = Database::search("SELECT * FROM `book` INNER JOIN `book_img` ON book_img.book_id=book.id ORDER BY `book_added_date` DESC");
                                                    $book_num = $book_rs->num_rows;


                                                    for ($x = 0; $x < $book_num; $x++) {
                                                        $book_data = $book_rs->fetch_assoc();

                                                        $cat_rs = Database::search("SELECT * FROM `category` INNER JOIN `book_has_category` ON category.id=book_has_category.category_id 
                                                                                                                                WHERE book_has_category.book_id='" . $book_data['id'] . "'");
                                                        $cat_num = $cat_rs->num_rows;

                                                        $author_rs = Database::search("SELECT * FROM `book` INNER JOIN `author` ON book.author_id=author.id WHERE book.id='" . $book_data['id'] . "'");
                                                        $author_num = $author_rs->num_rows;
                                                        $author_data = $author_rs->fetch_assoc();

                                                        $lang_rs = Database::search("SELECT * FROM `book` INNER JOIN `language` ON book.language_id=language.id WHERE book.id='" . $book_data['id'] . "'");
                                                        $lang_num = $lang_rs->num_rows;
                                                        $lang_data = $lang_rs->fetch_assoc();

                                                    ?>
                                                        <tr class="">
                                                            <td>#<?php echo $book_data['id']; ?></td>
                                                            <td><img src="<?php echo $book_data['path']; ?>" height="80px" alt="Book Thumbnail"></td>
                                                            <td class="text-wrap"><?php echo $book_data['book_name']; ?></td>
                                                            <td class="text-nowrap px-2"><?php echo $author_data['author_name']; ?></td>
                                                            <td class="text-nowrap px-2"><?php echo $lang_data['language_name']; ?></td>
                                                            <td class="text-nowrap px-2"><?php if ($book_data['sale_price'] > 0) {
                                                                                                echo ("<s>Rs. $book_data[price].00</s><br>");
                                                                                                echo ("Rs. $book_data[sale_price].00");
                                                                                            } else {
                                                                                                echo ("Rs. $book_data[price].00");
                                                                                            } ?></td>

                                                            <td class="text-center"><?php echo $book_data['pages']; ?></td>
                                                            <td class=""><?php for ($i = 0; $i <  $cat_num; $i++) {
                                                                                $cat_data = $cat_rs->fetch_assoc();
                                                                                echo $cat_data['category_name'] . '<br> ';
                                                                            } ?></td>
                                                            <td class="" id="<?php echo $book_data['id']; ?>">
                                                                <a href="<?php echo "singleBookView.php?id=" . ($book_data['id']) ?>" class="text-primary"><i class="bi bi-eye"></i></a>
                                                                <a href="<?php echo "edit-book.php?id=" . ($book_data['id']) ?>" class="text-success"><i class="bi bi-pencil-square"></i></a>
                                                                <a href="" class="text-danger" data-bs-toggle="modal" data-bs-target="#bookDelete<?php echo $book_data['id']; ?>"><i class="bi bi-trash"></i></a>
                                                                <div class="modal fade" id="bookDelete<?php echo $book_data['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Book</h1>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Are You Sure You Want To Delete This Book?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                <button type="button" class="btn btn-danger" onclick="deleteBook(<?php echo $book_data['id']; ?>)" id="<?php echo $book_data['id']; ?>">Delete Book</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                        </tr>
                                                    <?php

                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </di>
                            </div>

                            <div class="row d-none" id="customersReport">
                                <di class="col-12 p-2">
                                    <div class="bg-white pt-3 pb-1 text-center rounded-4">
                                        <h2 class="fw-bold">Customers Report</h2>
                                    </div>
                                </di>
                                <di class="col-12 p-2">
                                    <div class="bg-white pt-3 pb-1 d-flex text-center rounded-4">
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <h6>Total Customers</h6>
                                            <h2 class="fw-semibold fs-2"><?php echo ($tot_cus_num) ?></h2>
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <h6>Active Customers</h6>
                                            <h2 class="fw-semibold fs-2"><?php echo ($active_cus_num) ?></h2>
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <h6>Male Customers</h6>
                                            <h2 class="fw-semibold fs-2"><?php echo ($male_cus_num) ?></h2>
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <h6>Female Customers</h6>
                                            <h2 class="fw-semibold fs-2"><?php echo ($female_cus_num) ?></h2>
                                        </div>
                                    </div>
                                </di>
                                <di class="col-12 p-2">
                                    <div class="bg-white p-4 rounded-4">
                                        <div>
                                            <h5>All Customers</h5>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr class="text-nowrap">
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Joined Date</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Mobile</th>
                                                        <th scope="col">Birthday</th>
                                                        <th scope="col">City</th>
                                                        <th scope="col" class="text-center">User Stetus</th>
                                                        <th scope="col">Gender</th>
                                                        <th scope="col" class="text-end">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $rs = Database::search("SELECT * FROM `users` INNER JOIN `gender` ON users.gender_id=gender.id INNER JOIN `profile_img` 
                                                    ON users.email=profile_img.users_email WHERE `user_type_id`='2' ORDER BY `joined_date` DESC ");
                                                    $num = $rs->num_rows;


                                                    for ($i = 0; $i < $num; $i++) {
                                                        $d = $rs->fetch_assoc();

                                                        $address_rs = Database::search("SELECT * FROM `users_address` WHERE `users_email`='" . $d["email"] . "' AND `address_type`='1'");
                                                        $address_num = $address_rs->num_rows;
                                                        if ($address_num == 1) {
                                                            $address_data = $address_rs->fetch_assoc();
                                                        }

                                                    ?>
                                                        <tr id="tableRow<?php echo $i ?>" onclick="selectCustomer(this)" class="">
                                                            <!-- <th scope="row"><input type="checkbox" name="select" class="form-check-input" onclick="checkToSelect()" id="checkbooxID"></th> -->
                                                            <td class="text-center"><?php echo $d["id"]; ?></td>
                                                            <td class="text-nowrap"><?php echo $d["first_name"] . " " . $d["last_name"]; ?></td>
                                                            <td class="text-nowrap"><?php echo $d["joined_date"]; ?></td>
                                                            <td><?php echo $d["email"]; ?></td>
                                                            <td><?php echo $d["mobile"]; ?></td>
                                                            <td class="text-nowrap"><?php if (isset($d["birthday"])) {
                                                                                        echo $d["birthday"];
                                                                                    } else {
                                                                                        echo "N/A";
                                                                                    } ?></td>

                                                            <td><?php if ($address_num == 1) {
                                                                    echo $address_data["city"];
                                                                } else {
                                                                    echo "N/A";
                                                                } ?></td>
                                                            <td class="text-center"><span class="badge rounded-pill px-2 py-2 fs-6 fw-normal text-bg-<?php if ($d["status"] == 1) {
                                                                                                                                                            echo ("success");
                                                                                                                                                        } else {
                                                                                                                                                            echo ("danger");
                                                                                                                                                        }
                                                                                                                                                        ?>"><?php if ($d["status"] == 1) {
                                                                                                                                                                echo ("Active");
                                                                                                                                                            } else {
                                                                                                                                                                echo ("Inactive");
                                                                                                                                                            }
                                                                                                                                                            ?></span></td>
                                                            <td class="text-center"><?php echo $d["gender"]; ?></td>
                                                            <td class="">
                                                                <div class="dropstart text-center text-primary">
                                                                    <a type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#">View Customer</a></li>
                                                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#customerChange<?php echo $d["email"]; ?>">Change Stetus</a></li>
                                                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#customerDelete<?php echo $d["email"]; ?>">Delete Customer</a></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="modal fade" id="customerDelete<?php echo $d["email"]; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Customer</h1>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Are You Sure You Want To Delete <?php echo $d["first_name"]; ?>?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                <button type="button" id="<?php echo $d['email']; ?>" onclick="deleteCustomer(this);" class="btn btn-danger">Yes, Delete</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal fade" id="customerChange<?php echo $d["email"]; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="customerChangeLabel<?php echo $d["email"]; ?>" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h1 class="modal-title fs-5" id="customerChangeLabel<?php echo $d["email"]; ?>">Change Stetus</h1>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="d-flex flex-row align-items-stretch gap-2 w-100">
                                                                                    <select class="form-select border-primary  border-2 focus-ring focus-ring-light" id="select<?php echo $d["email"]; ?>">
                                                                                        <option value="0">Change Stetus</option>
                                                                                        <option value="1">Active</option>
                                                                                        <option value="2">Inactive</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                <button class="btn btn-primary" id="<?php echo $d['email']; ?>" onclick="changeStetus(this);" type="button">Apply</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php

                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </di>
                            </div>

                            <div class="row d-none" id="stockReport">
                                <di class="col-12 p-2">
                                    <div class="bg-white pt-3 pb-1 text-center rounded-4">
                                        <h2 class="fw-bold">Stock Report</h2>
                                    </div>
                                </di>
                                <di class="col-12 p-2">
                                    <div class="bg-white pt-3 pb-1 d-flex text-center rounded-4">
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <h6>In Stock</h6>
                                            <h2 class="fw-semibold fs-2"><?php echo ($in_stock_num) ?></h2>
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <h6>Low Stock</h6>
                                            <h2 class="fw-semibold fs-2"><?php echo ($low_stock_num) ?></h2>
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <h6>Out of stock</h6>
                                            <h2 class="fw-semibold fs-2"><?php echo ($out_stock_num) ?></h2>
                                        </div>
                                        <div class="col-6 col-md-3 col-lg-3">
                                            <h6>Total Stock</h6>
                                            <h2 class="fw-semibold fs-2"><?php echo ($total_stock['SUM(quantity)']) ?></h2>

                                        </div>
                                    </div>
                                </di>
                                <di class="col-12 p-2">
                                    <div class="bg-white p-4 rounded-4">
                                        <div>
                                            <h5>All Stock</h5>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr class="text-nowrap">
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Book Name</th>
                                                        <th scope="col">Added Date</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col" class="text-center">User Stetus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $stock_rs = Database::search("SELECT * FROM `book` ");
                                                    $stock_num = $stock_rs->num_rows;


                                                    for ($i = 0; $i < $stock_num; $i++) {
                                                        $stock_d = $stock_rs->fetch_assoc();

                                                        $address_rs = Database::search("SELECT * FROM `users_address` WHERE `users_email`='" . $d["email"] . "' AND `address_type`='1'");
                                                        $address_num = $address_rs->num_rows;
                                                        if ($address_num == 1) {
                                                            $address_data = $address_rs->fetch_assoc();
                                                        }

                                                    ?>
                                                        <tr>
                                                            <!-- <th scope="row"><input type="checkbox" name="select" class="form-check-input" onclick="checkToSelect()" id="checkbooxID"></th> -->
                                                            <td class="text-center"><?php echo $stock_d["id"]; ?></td>
                                                            <td class="text-nowrap"><?php echo $stock_d["book_name"] ?></td>
                                                            <td class="text-nowrap"><?php echo $stock_d["book_added_date"]; ?></td>
                                                            <td class="text-nowrap text-center"><?php echo $stock_d["quantity"]; ?></td>
                                                            <td class="text-center"><span class="badge rounded-pill px-2 py-2 fs-6 fw-normal text-bg-<?php if ($stock_d["quantity"] == 0) {
                                                                                                                                                            echo ("danger");
                                                                                                                                                        } else if ($stock_d["quantity"] <= 5 && $stock_d["quantity"] > 0) {
                                                                                                                                                            echo ("warning");
                                                                                                                                                        } else {
                                                                                                                                                            echo ("success");
                                                                                                                                                        }
                                                                                                                                                        ?>"><?php if ($stock_d["quantity"] == 0) {
                                                                                                                                                                echo ("Out of Stock");
                                                                                                                                                            } else if ($stock_d["quantity"] <= 5 && $stock_d["quantity"] > 0) {
                                                                                                                                                                echo ("Low Stock");
                                                                                                                                                            } else {
                                                                                                                                                                echo ("In Stock");
                                                                                                                                                            }
                                                                                                                                                            ?></span></td>

                                                        </tr>
                                                    <?php

                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </di>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <script src="script.js"></script>
            <script src="bootstrap.bundle.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        </body>

        </html>

<?php
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: login.php");
}

?>
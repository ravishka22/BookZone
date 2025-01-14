<?php
// session_start();
// require "connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body class="">
    <?php

    if (isset($_SESSION["u"])) {

        $email = $_SESSION["u"]["email"];

        $details_rs = Database::search("SELECT * FROM `users` INNER JOIN `gender` ON 
                                    users.gender_id=gender.id INNER JOIN `user_type` ON users.user_type_id=user_type.user_type_id WHERE `email`='" . $email . "'");

        $image_rs = Database::search("SELECT * FROM `profile_img` WHERE `users_email`='" . $email . "'");

        $details_data = $details_rs->fetch_assoc();
        $image_data = $image_rs->fetch_assoc();

    ?>
        <div class="admin-sidebar">
            <div class="admin-sidebar bg-white p-3 fixed-top col-lg-3 overflow-y-scroll vh-100">
                <div class="">
                    <div class="bg-primary align-items-center text-center p-2 text-white mb-2 rounded-3">
                        <h5 class="fw-bold my-2 fs-5"><i class="bi bi-speedometer2"></i>&nbsp; Dashboard</h5>
                    </div>

                    <div class="align-items-center text-center p-2 mb-3">
                        <img src="<?php echo $image_data["path"]; ?>" alt="Default Profile" height="120px" width="120px" class="rounded-circle my-2">
                        <h5 class="w-auto mt-2 mb-0"><?php echo $details_data["first_name"] . " " . $details_data["last_name"]; ?></h5>
                        <span>~ <?php echo $details_data["user_type"]; ?> ~</span>
                    </div>


                    <div class="mb-2 dashbtns">
                        <ul class="nav flex-column gap-2">
                            <li class="btn btn-primary" onclick="window.location.href='admin-dashboard.php'" id="overviewbtn">
                                <a class="w-100"><i class="bi bi-shop"></i>&nbsp; Overview</a>
                            </li>
                            <li class="btn btn-primary" onclick="expandOrders();">
                                <a><i class="bi bi-cart3"></i>&nbsp; Orders &nbsp;</a>
                            </li>
                            <ul class="nav flex-column d-none ps-3 gap-1" id="orders-menu">
                                <li class="btn btn-light" id="orderbtn" onclick="window.location.href='orders.php'">
                                    <a><i class="bi bi-box-seam"></i>&nbsp; View Orders</a>
                                </li>
                                <li class="btn btn-light" id="addorderbtn" onclick="window.location.href='add-orders.php'">
                                    <a><i class="bi bi-cart-plus"></i>&nbsp; Add Orders</a>
                                </li>
                            </ul>
                            <li class="btn btn-primary" onclick="expandBooks();">
                                <a><i class="bi bi-book"></i>&nbsp; Books</a>
                            </li>
                            <ul class="nav flex-column d-none ps-3 gap-1" id="books-menu">
                                <li class="btn btn-light" id="allbooksbtn" onclick="window.location.href='all-books.php'">
                                    <a href="#"><i class="bi bi-book-fill"></i>&nbsp; View Books</a>
                                </li>
                                <li class="btn btn-light" id="addbooksbtn" onclick="window.location.href='add-books.php'">
                                    <a href="#"><i class="bi bi-plus-circle"></i>&nbsp; Add Books</a>
                                </li>
                                <li class="btn btn-light" id="categoriesbtn" onclick="window.location.href='categories.php'">
                                    <a href="#"><i class="bi bi-grid"></i>&nbsp; Categories</a>
                                </li>
                                <li class="btn btn-light" id="languagesbtn" onclick="window.location.href='languages.php'">
                                    <a href="#"><i class="bi bi-translate"></i>&nbsp; Languages</a>
                                </li>
                                <li class="btn btn-light" id="authorsbtn" onclick="window.location.href='authors.php'">
                                    <a href="#"><i class="bi bi-person-lines-fill"></i>&nbsp; Authors</a>
                                </li>
                            </ul>
                            <li class="btn btn-primary" onclick="expandCustomers();">
                                <a><i class="bi bi-person-badge"></i>&nbsp; Customers</a>
                            </li>
                            <ul class="nav flex-column d-none ps-3 gap-1" id="customers-menu">
                                <li class="btn btn-light" id="vcustomerbtn" onclick="window.location.href='customers.php'">
                                    <a href="customers.php"><i class="bi bi-person-lines-fill"></i>&nbsp; View Customers</a>
                                </li>
                                <li class="btn btn-light" id="addcustomerbtn" onclick="window.location.href='add-customers.php'">
                                    <a href="#"><i class="bi bi-person-plus"></i>&nbsp; Add Customers</a>
                                </li>
                            </ul>
                            <li class="btn btn-primary" onclick="window.location.href='reports.php'">
                            <a href="#"><i class="bi bi-file-earmark-text"></i></i>&nbsp; Reports</a>
                            </li>
                            <li class="btn btn-secondary" onclick="window.location.href='index.php'">
                                <a><i class="bi bi-box-arrow-up-right"></i>&nbsp; Visit BookZone</a>
                            </li>
                            <div id="emptydiv" class="d-none m-0"></div>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    <?php

    } else {
    }

    ?>


    <script src="script.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>

</html>
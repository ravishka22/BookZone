<?php

session_start();

include "connection.php";

if (isset($_SESSION["u"])) {
    $user_email = $_SESSION["u"]["email"];
    $user_rs = Database::search("SELECT * FROM `users` INNER JOIN `user_type` ON user_type.user_type_id=users.user_type_id 
    WHERE email='$user_email'");
    $user_data = $user_rs->fetch_assoc();
    if ($user_data["user_type_id"] == 1) {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Books</title>

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="icon" href="resourses/logo.svg" />

</head>

<body class="admin-body" onload="loadBooks();">
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
                        <h2 class="mb-0">All Books</h2>
                    </div>
                    <div class="p-3 d-flex gap-2 align-items-center">
                        <button class="btn btn-primary headerbtn" onclick="window.location.href='add-books.php'" type="button"><i class="bi bi-plus-circle"></i>&nbsp; Add Books</button>
                    </div>
                </div>

                <div class="admin-content p-4">
                    <div class="row mb-4">
                        <div class="d-none alert alert-danger alert-dismissible mb-3" id="viewBookAlertBox" role="alert">
                            <div id="viewBookAlert">

                            </div>
                            <button type="button" class="btn-close" onclick="hideAlert();" aria-label="Close"></button>
                        </div>
                        <div class="p-4 bg-white align-items-center rounded-4">
                            <div class="pb-3 d-flex flex-lg-row flex-md-row flex-column justify-content-between align-items-center gap-3">
                                <div class="d-flex flex-sm-row flex-lg-row flex-md-row flex-row align-items-stretch align-items-lg-center gap-3 w-100">
                                    <div class="d-flex flex-row align-items-stretch gap-2 w-auto">
                                        <select class="form-select border-primary  border-2 focus-ring focus-ring-light" id="authorSelector" type="search">
                                            <option selected value="0">Select Author</option>
                                            <?php

                                            $author_rs = Database::search("SELECT * FROM `author`");
                                            $author_num = $author_rs->num_rows;

                                            for ($x = 0; $x < $author_num; $x++) {
                                                $author_data = $author_rs->fetch_assoc();

                                            ?>
                                                <option value="<?php echo $author_data["id"]; ?>"><?php echo $author_data["author_name"]; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <button class="btn btn-primary" onclick="adminBookFilter();" type="submit">Filter</button>
                                        <button class="btn btn-secondary" onclick="window.location.reload();" type="submit">Reset</button>
                                    </div>
                                </div>
                                <div class="d-flex flex-row align-items-center gap-2 w-100">
                                    <input class="form-control focus-ring focus-ring-light" type="search" name="" id="">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>

                            </div>
                            <div class="row">

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-nowrap table-responsive">
                                        <table class="table align-middle table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">&nbsp;</th>
                                                    <th scope="col">Book Name</th>
                                                    <th scope="col" class="px-2">Author</th>
                                                    <th scope="col" class="px-2">Price</th>
                                                    <th scope="col" class="text-center">Stock</th>
                                                    <th scope="col" class="text-center">&nbsp;&nbsp;<i class="bi bi-star-fill"></i>&nbsp;&nbsp;</th>
                                                    <th scope="col" class="px-2">Categories</th>
                                                    <th scope="col" class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="booksTable">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
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
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
    <title>Languages</title>

    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="icon" href="resourses/logo.svg" />

</head>

<body class="admin-body" onload="loadLanguages();">
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
                        <h2 class="mb-0">Languages</h2>
                    </div>
                    <div class="p-3 d-flex gap-2 align-items-center">
                        <button class="btn btn-primary headerbtn" onclick="window.location.href='add-books.php'" type="button"><i class="bi bi-plus-circle"></i>&nbsp; Add Books</button>
                    </div>
                </div>

                <div class="p-4">
                    <div class="row">
                        <di class="col-12 col-lg-5 col-md-5 p-2">
                            <div class="bg-white p-4 rounded-4">
                                <div class="mb-2">
                                    <h5>Add Languages</h5>
                                </div>
                                <div class="col-12 d-none mb-2" id="msgdiv">
                                    <div class="alert alert-danger" role="alert" id="msg">

                                    </div>
                                </div>
                                <div class="text-body mb-4">
                                    <p>Languages of the books in your store can be managed here. To add languages you can insert them below. To edit a language listed delete the language and add it again.</p>
                                </div>
                                <form onclick="hideLanguageMsg();">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="languageName" placeholder="">
                                        <label for="languageName">Language Name</label>

                                    </div>
                                    <div class="col-12 d-none mb-3" id="languageMsgDiv">
                                        <div class="alert alert-danger" role="alert" id="languageMsg">
                                        </div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <textarea type="text-area" class="form-control" id="languageDisc" placeholder="" rows="4"></textarea>
                                        <label for="languageDisc">Short Discription</label>
                                    </div>
                                    <button type="button" class="btn btn-primary w-auto col-12" onclick="addLanguages();">Add New Language</button>
                                </form>
                            </div>
                        </di>
                        <di class="col-12 col-lg-7 col-md-7 p-2">
                            <div class="bg-white p-4 rounded-4">
                                <div>
                                    <h5>All Language</h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <!-- &nbsp; -->
                                                <th scope="col">Name</th>
                                                <th class="text-center" scope="col">Discription</th>
                                                <th class="text-center" scope="col">Count</th>
                                                <th scope="col" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="languageTable">
                                            
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
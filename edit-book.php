
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
    <title>Edit Book</title>

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
                        <?php

                        if (isset($_GET["id"])) {
                            $bid = $_GET["id"];

                            $book_rs = Database::search("SELECT * FROM `book` INNER JOIN `language` ON book.language_id=language.id 
                                                INNER JOIN `author` ON author.id=book.author_id WHERE book.id = '$bid'");
                            $book_num = $book_rs->num_rows;

                            $bimg_rs = Database::search("SELECT * FROM `book_img` WHERE book_id = '$bid'");
                            $bimg_num = $bimg_rs->num_rows;

                            if ($bimg_num == 1) {
                                $bimg_data = $bimg_rs->fetch_assoc();
                            }

                            if ($book_num == 1) {
                                $book_data = $book_rs->fetch_assoc();
                            }
                        }

                        ?>
                        <a class="navbar-brand d-none d-lg-block" href="index.php">
                            <img src="resourses/logo.svg" alt="Logo" height="50" class="d-inline-block align-text-center">
                        </a>
                        <h2 class="mb-0">Update Book</h2>
                    </div>
                    <div class="p-3 d-flex gap-2 align-items-center">
                        <button class="btn btn-secondary headerbtn" onclick="window.location.reload();" type="button">Reset</button>
                        <button class="btn btn-success headerbtn" id="<?php echo ($bid) ?>" onclick="updateBook(this);" type="button"><i class="bi bi-check-circle"></i>&nbsp; Update Book</button>
                    </div>
                </div>

                <div class="p-4 pb-0">
                    <h4>Edit Book - <?php echo ($book_data["book_name"]); ?></h4>

                </div>

                <div class="p-4 pt-2">
                    <div class="row">
                        <div class="col-12 col-lg-8 col-md-8 p-2">
                            <div class="d-none alert alert-danger alert-dismissible mb-3" id="addBookAlertBox" role="alert">
                                <div id="addBookAlert">

                                </div>
                                <button type="button" class="btn-close" onclick="hideAlert();" aria-label="Close"></button>
                            </div>
                            <div class="bg-white p-4 rounded-4">
                                <div class="mb-4">
                                    <h5>General Information</h5>
                                </div>
                                <form onclick="hideAlert();">
                                    <div class="mb-3">
                                        <label for="bookName" class="form-label">Book Name</label>
                                        <input type="text" class="form-control" id="bookName" value="<?php echo ($book_data["book_name"]); ?>" placeholder="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="bookDisc" class="form-label">Book Discription</label>
                                        <textarea class="form-control" id="bookDisc" placeholder="" rows="6"><?php echo ($book_data["book_discription"]); ?></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="mb-3">
                                                <label for="bookPages" class="form-label">Book Pages</label>
                                                <input type="number" class="form-control" value="<?php echo ($book_data["pages"]); ?>" id="bookPages" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="mb-3">
                                                <label for="bookPublisher" class="form-label">Publisher</label>
                                                <input type="text" class="form-control" id="bookPublisher" value="<?php echo ($book_data["publisher"]); ?>" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="mb-3">
                                                <label for="bookISBN" class="form-label">ISBN</label>
                                                <input type="number" class="form-control" value="<?php echo ($book_data["isbn"]); ?>" id="bookISBN" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="mb-3">
                                                <label for="bookPublishedDate" class="form-label">Book Published Date</label>
                                                <input type="date" class="form-control" value="<?php echo ($book_data["published_date"]); ?>" id="bookPublishedDate" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="mb-3">
                                                <label for="bookLanguage" class="form-label">Language (<span class="text-primary"><?php echo ($book_data["language_name"]); ?></span>)</label>
                                                <select class="form-select" id="bookLanguage" aria-label="Default select example">
                                                    <option selected value="0">Select Language</option>
                                                    <?php
                                                    $language_rs = Database::search("SELECT * FROM `language`");
                                                    $language_num = $language_rs->num_rows;

                                                    for ($x = 0; $x < $language_num; $x++) {
                                                        $language_data = $language_rs->fetch_assoc();

                                                    ?>
                                                        <option value="<?php echo $language_data["id"]; ?>"><?php echo $language_data["language_name"]; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#languageModal">
                                                    Add New
                                                </button>
                                                <div class="modal fade" id="languageModal" tabindex="-1" aria-labelledby="languageModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header border-0">
                                                                <h1 class="modal-title fs-5" id="languageModalLabel">Add New Language</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
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
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer border-0">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary" onclick="addLanguages();">Add Language</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="mb-3">
                                                <label for="bookAuthor" class="form-label">Author (<span class="text-primary"><?php echo ($book_data["author_name"]); ?></span>)</label>
                                                <select class="form-select" id="bookAuthor" aria-label="Default select example">
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
                                                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#authorModal">
                                                    Add New
                                                </button>
                                                <div class="modal fade" id="authorModal" tabindex="-1" aria-labelledby="authorModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header border-0">
                                                                <h1 class="modal-title fs-5" id="authorModalLabel">Add New Author</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form>
                                                                    <div class="form-floating mb-3" onclick="hideauthorMsg();">
                                                                        <input type="text" class="form-control" id="authorName" placeholder="">
                                                                        <label for="authorName">Author Name</label>

                                                                    </div>
                                                                    <div class="col-12 d-none mb-3" id="authorMsgDiv">
                                                                        <div class="alert alert-danger" role="alert" id="authorMsg">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-floating mb-3">
                                                                        <textarea type="text-area" class="form-control" id="authorDisc" placeholder="" rows="4"></textarea>
                                                                        <label for="authorDisc">Short Discription</label>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer border-0">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary" onclick="addAuthors();">Add Author</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="bg-white p-4 rounded-4 my-3">
                                <div class="mb-4">
                                    <h5>Pricing And Stock</h5>
                                </div>
                                <form onclick="hideAlert();">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <label for="bookPrice" class="form-label">Price</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Rs.</span>
                                                <input type="number" id="bookPrice" class="form-control" value="<?php echo ($book_data["price"]); ?>" aria-label="Amount (to the nearest dollar)">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <label for="bookSalePrice" class="form-label">Sale Price</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Rs.</span>
                                                <input type="number" id="bookSalePrice" class="form-control" value="<?php echo ($book_data["sale_price"]); ?>" aria-label="Amount (to the nearest dollar)">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="mb-3">
                                                <label for="bookQty" class="form-label">Stock Quantity</label>
                                                <input type="number" class="form-control" value="<?php echo ($book_data["quantity"]); ?>" id="bookQty" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="mb-3">
                                                <label for="bookSKU" class="form-label">SKU</label>
                                                <input type="text" class="form-control" value="<?php echo ($book_data["sku"]); ?>" id="bookSKU" placeholder="">
                                            </div>
                                        </div>
                                    </div>


                                </form>
                            </div>
                            <div class="bg-white p-4 rounded-4 my-3">
                                <div class="mb-4">
                                    <h5>Shipping</h5>
                                </div>
                                <form onclick="hideAlert();">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <label for="bookWeight" class="form-label">Weight</label>
                                            <div class="input-group mb-3">
                                                <input type="number" id="bookWeight" value="<?php echo ($book_data["weight"]); ?>" class="form-control">
                                                <span class="input-group-text">g</span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <label for="bookDimention" class="form-label">Dimention</label>
                                            <div class="input-group mb-3">
                                                <input type="number" id="bookDimention" value="<?php echo ($book_data["dimention"]); ?>" class="form-control">
                                                <span class="input-group-text">cm<sup>3</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 col-md-4 p-2">
                            <div class="bg-white p-4 rounded-4">
                                <div class="mb-3">
                                    <h5>Upload Image</h5>
                                </div>
                                <div class="">
                                    <div class="text-center align-content-center">
                                        <img class="rounded-3 border border-1" src="<?php echo ($bimg_data["path"]); ?>" width="200px" alt="Book Image" id="bookImg">
                                    </div>
                                    <div class="text-center">
                                        <div class="file btn btn-primary mt-3" onclick="changeBookImage();">
                                            <i class="bi bi-cloud-arrow-up"></i>&nbsp; Upload Book Image
                                            <input type="file" name="file" id="bookImgUploader" value="<?php echo ($bimg_data["path"]); ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-4 my-3">
                                <div class="mb-3">
                                    <h5>Category</h5>
                                </div>
                                <?php
                                $bcat_rs = Database::search("SELECT * FROM `category` INNER JOIN `book_has_category` ON
                                book_has_category.category_id=category.id WHERE book_has_category.`book_id`='$bid'");
                                $bcat_num = $bcat_rs->num_rows;
                                ?>
                                <div class="mb-3">
                                    <h6>Selected Categories</h6>
                                    <?php
                                    for ($x = 0; $x < $bcat_num; $x++) {
                                        $bcat_data = $bcat_rs->fetch_assoc();

                                    ?>
                                        <div class="form-check">
                                            <input class="form-check-input" checked type="checkbox" value="<?php echo $bcat_data["id"]; ?>" id="selecterdCategory">
                                            <label class="form-check-label" for="selecterdCategory">
                                                <?php echo $bcat_data["category_name"]; ?>
                                            </label>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <hr>
                                    <form onclick="hideCategoryMsg();" id="checkboxForm">
                                        <?php
                                        $category_rs = Database::search("SELECT * FROM `category`");
                                        $category_num = $category_rs->num_rows;

                                        for ($x = 0; $x < $category_num; $x++) {
                                            $category_data = $category_rs->fetch_assoc();

                                        ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="<?php echo $category_data["id"]; ?>" id="bookCategory<?php echo $category_data["id"]; ?>">
                                                <label class="form-check-label" for="bookCategory<?php echo $category_data["id"]; ?>">
                                                    <?php echo $category_data["category_name"]; ?>
                                                </label>
                                            </div>
                                        <?php
                                        }
                                        ?>


                                    </form>
                                </div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">
                                    Add New
                                </button>
                                <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header border-0">
                                                <h1 class="modal-title fs-5" id="categoryModalLabel">Add New Category</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form onclick="hideCategoryMsg();">
                                                    <div class="form-floating mb-3" onclick="hideCategoryMsg();">
                                                        <input type="text" class="form-control" id="categoryName" placeholder="">
                                                        <label for="categoryName">Category Name</label>

                                                    </div>
                                                    <div class="col-12 d-none mb-3" id="categoryMsgDiv">
                                                        <div class="alert alert-danger" role="alert" id="categoryMsg">
                                                        </div>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <textarea type="text-area" class="form-control" id="categoryDisc" placeholder="" rows="4"></textarea>
                                                        <label for="categoryDisc">Short Discription</label>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" onclick="addCategories();">Add New Category</button>
                                            </div>
                                        </div>
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
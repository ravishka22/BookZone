<?php

include "connection.php";

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


?>
    <tr class="">
        <td>#<?php echo $book_data['id']; ?></td>
        <td><img src="<?php echo $book_data['path']; ?>" height="80px" alt="Book Thumbnail"></td>
        <td class="text-wrap"><?php echo $book_data['book_name']; ?></td>
        <td class="text-nowrap px-2"><?php echo $author_data['author_name']; ?></td>
        <td class="text-nowrap px-2"><?php if ($book_data['sale_price'] > 0) {
                                            echo ("<s>Rs. $book_data[price].00</s><br>");
                                            echo ("Rs. $book_data[sale_price].00");
                                        } else {
                                            echo ("Rs. $book_data[price].00");
                                        } ?></td>

        <td class="text-center px-2"><span class="badge rounded-pill px-3 py-2 fs-6 fw-normal text-bg-<?php if ($book_data["quantity"] == 0) {
                                                                                                            echo ("danger");
                                                                                                        } else {
                                                                                                            echo ("success");
                                                                                                        }
                                                                                                        ?>"><?php if ($book_data["quantity"] == 0) {
                                                                                                                echo ("Out Of Stock" . " (" . $book_data["quantity"] . ") ");
                                                                                                            } else {
                                                                                                                echo ("In Stock" . " (" . $book_data["quantity"] . ") ");
                                                                                                            }
                                                                                                            ?></span></td>
        <td class="text-center"><a href="" class="text-warning"><i onclick="bookFeatured(this);" id="<?php echo $book_data['id']; ?>" class="<?php if ($book_data["book_status_id"] == 3) {
                                                                                                                                                    echo ("bi bi-star-fill");
                                                                                                                                                } else {
                                                                                                                                                    echo ("bi bi-star");
                                                                                                                                                }
                                                                                                                                                ?>"></i></a></td>
        <td class=""><?php for ($i = 0; $i <  $cat_num; $i++) {
                            $cat_data = $cat_rs->fetch_assoc();
                            echo $cat_data['category_name'] . '<br> ';
                        } ?></td>
        <td class="" id="<?php echo $book_data['id']; ?>">
            <a href="<?php echo "singleBookView.php?id=" . ($book_data['id']) ?>" class="text-primary"><i class="bi bi-eye"></i></a>
            <a href="<?php echo "edit-book.php?id=" . ($book_data['id']) ?>" class="text-success"><i class="bi bi-pencil-square"></i></a>
            <!-- <a href="" class="text-danger" data-bs-toggle="modal" data-bs-target="#bookDelete<?php echo $book_data['id']; ?>"><i class="bi bi-trash"></i></a>
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
            </div> -->
        </td>

    </tr>
<?php
}
?>
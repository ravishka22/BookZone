<?php

include "connection.php";

$rs = Database::search("SELECT * FROM `category`");
$num = $rs->num_rows;


for ($i = 0; $i < $num; $i++) {
    $d = $rs->fetch_assoc();

    $cat_rs = Database::search("SELECT * FROM `book_has_category` WHERE `category_id` = '" . $d['id'] . "' ");
    $cat_num = $cat_rs->num_rows;

?>
    <tr class="">
        <td class="text-nowrap"><?php echo $d['category_name']; ?></td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#categoryDiscription<?php echo $d['id']; ?>">
                View
            </button>
            <div class="modal fade" id="categoryDiscription<?php echo $d['id']; ?>" tabindex="-1" aria-labelledby="categoryDiscriptionLabel<?php echo $d['id']; ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="categoryDiscriptionLabel<?php echo $d['id']; ?>"><?php echo $d['category_name']; ?></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><?php if (!$d['category_discription'] == "") {
                                    echo $d['category_discription'];
                                } else {
                                    echo ("There is no discription for this category.");
                                }
                                ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </td>
        <td class="text-center"><?php echo $cat_num; ?></td>
        <td class="text-center" onclick="deleteCategory(this)" id="<?php echo $d['id']; ?>"><a href=""><i class="bi bi-trash text-danger"></i></a></td>
    </tr>
<?php

}
?>
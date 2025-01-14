<?php

include "connection.php";

$rs = Database::search("SELECT * FROM `author`");
$num = $rs->num_rows;

for ($i = 0; $i < $num; $i++) {
    $d = $rs->fetch_assoc();

    $book_rs = Database::search("SELECT * FROM `book` WHERE `author_id` = '" . $d['id'] . "' ");
    $book_num = $book_rs->num_rows;

?>
    <tr class="">
        <td class="text-nowrap"><?php echo $d['author_name']; ?></td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#authorDiscription<?php echo $d['id']; ?>">
                View
            </button>
            <div class="modal fade" id="authorDiscription<?php echo $d['id']; ?>" tabindex="-1" aria-labelledby="authorDiscriptionLabel<?php echo $d['id']; ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="authorDiscriptionLabel<?php echo $d['id']; ?>"><?php echo $d['author_name']; ?></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><?php if (isset($d['author_discription'])) {
                                    echo $d['author_discription'];
                                } else {
                                    echo ("There is no discription for this author.");
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
        <td class="text-center"><?php echo $book_num ?></td>
        <td class="text-center" onclick="deleteAuthor(this)" id="<?php echo $d['id']; ?>"><a href=""><i class="bi bi-trash text-danger"></i></a></td>
    </tr>
<?php

}
?>
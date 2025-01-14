<?php

session_start();

include "connection.php";

$user_email = $_SESSION["u"]["email"];

$order_rs = Database::search("SELECT * FROM `order` INNER JOIN `order_status` ON order.order_status_id=order_status.order_status_id
WHERE `users_email`='$user_email'");
$order_num = $order_rs->num_rows;

for ($i = 0; $i < $order_num; $i++) {
    $order_data = $order_rs->fetch_assoc();

    $book_rs = Database::search("SELECT * FROM `book` INNER JOIN `order_has_book` ON book.id=order_has_book.book_id 
                                    WHERE `order_order_id`='" . $order_data["order_id"] . "'");
    $book_num = $book_rs->num_rows;

?>
    <tr class="text-center">
        <th scope="row">BZ#0<?php echo ($order_data["order_id"]) ?></th>
        <td>
            <?php echo $book_num ?> Book<?php if ($book_num > 1) {
                                            echo ("1");
                                        } ?> &nbsp;
            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#booksinorder<?php echo ($order_data["order_id"]) ?>">View</button>
            <div class="modal fade" id="booksinorder<?php echo ($order_data["order_id"]) ?>" tabindex="-1" aria-labelledby="booksinorderlabel<?php echo ($order_data["order_id"]) ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="booksinorderlabel<?php echo ($order_data["order_id"]) ?>">BZ#0<?php echo ($order_data["order_id"]) ?></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-start">Book Title</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="cartTable" class="align-middle">
                                    <?php
                                    for ($i = 0; $i < $book_num; $i++) {
                                        $book_data = $book_rs->fetch_assoc();
                                    ?>
                                        <tr style="font-size: 14px;">
                                            <td class="text-start"><?php echo ($book_data["book_name"]); ?> <span class="fw-bold">x <?php echo ($book_data["order_qty"]); ?></span></td>
                                            <td class="text-end text-nowrap fw-semibold">Rs. <?php echo ($book_data["item_total"]) ?>.00</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </td>
        <td><?php echo ($order_data["order_date"]) ?></td>
        <td class="text-center">01</td>
        <td>Rs.100.00</td>
        <td><span class="badge rounded-pill px-3 py-2 fs-6 fw-normal text-bg-<?php
                                                                                if ($order_data["order_status"] == "Pending") {
                                                                                    echo "warning";
                                                                                } elseif ($order_data["order_status"] == "Paid") {
                                                                                    echo "info";
                                                                                } elseif ($order_data["order_status"] == "Processing") {
                                                                                    echo "primary";
                                                                                } elseif ($order_data["order_status"] == "Completed") {
                                                                                    echo "success";
                                                                                } elseif ($order_data["order_status"] == "Canselled") {
                                                                                    echo "danger";
                                                                                }
                                                                                ?>"><?php echo ($order_data["order_status"]) ?></span></td>
        <td class="text-center">
            <button class="btn btn-sm btn-primary">View Invoice</button>

        </td>
    </tr>
    
<?php

}
?>
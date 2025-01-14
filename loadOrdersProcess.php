<?php

include "connection.php";

$search_text = $_POST["text"];
$order_stetus = $_POST["ost"];
$customer = $_POST["customer"];

if (isset($_POST["page"])) {
    $pageno = $_POST["page"];
} else {
    $pageno = 1;
}

$query = "SELECT * FROM `order` INNER JOIN `order_status` ON order_status.order_status_id=order.order_status_id
        INNER JOIN `users` ON order.users_email=users.email INNER JOIN `users_address` ON users_address.users_email=users.email 
        WHERE address_type='1' AND user_type_id='2'";

if (!empty($search_text)) {
    $query .= " AND `order_id` LIKE '%" . $search_text . "%'";
}

if (!empty($order_stetus)) {
    $query .= " AND `order`.`order_status_id`='" . $order_stetus . "'";
}

if (!empty($customer)) {
    $query .= " AND `users_email`='" . $customer . "'";
}

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
        <td>Rs. <?php echo $order_data["total_cost"]; ?>.00</td>
        <td class="text-center">
            <button class="btn btn-sm btn-primary" onclick="window.location.href = 'singleOrder.php?order_id=<?php echo $order_data['order_id']; ?>'">View</button>

        </td>
    </tr>
<?php

}

?>
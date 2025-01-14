<?php

include "connection.php";

$search_text = $_POST["search"];
$gender = $_POST["gender"];
$stetus = $_POST["stetus"];

$query = "SELECT * FROM `users` INNER JOIN `gender` ON users.gender_id=gender.id INNER JOIN `profile_img` 
ON users.email=profile_img.users_email WHERE `user_type_id`='2'";

if (!empty($search_text)) {
    $query .= " AND `first_name` LIKE '%" . $search_text . "%'";
}

if (!empty($stetus)) {
    $query .= " AND `status`='" . $stetus . "'";
}

if (!empty($gender)) {
    $query .= " AND `gender_id`='" . $gender . "'";
}

$query .= " ORDER BY `joined_date` DESC ";

$rs = Database::search($query);
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
        <td><img src="<?php echo $d["path"]; ?>" width="60px" height="60px" class="rounded-circle"></td>
        <td><?php echo $d["first_name"] . " " . $d["last_name"]; ?></td>
        <td class="text-center"><?php echo $d["gender"]; ?></td>
        <td><?php echo $d["email"]; ?></td>
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
        <td><?php echo $d["joined_date"]; ?></td>
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
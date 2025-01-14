<?php

include "connection.php";

session_start();

$email = $_SESSION["u"]["email"];

$address_rs = Database::search("SELECT * FROM `users_address` INNER JOIN 
                                                `district` ON users_address.district_district_id=district.district_id 
                                                INNER JOIN `province` ON 
                                                district.province_id=province.province_id 
                                                WHERE `users_email`='" . $email . "' AND `address_type`='1'");
$address_num = $address_rs->num_rows;
$address_data = $address_rs->fetch_assoc();
$user_district = $address_data["district_id"];

if (isset($_GET["p"])) {
    $province_id = $_GET["p"];

    $district_rs = Database::search("SELECT * FROM `district` WHERE `province_id`='" . $province_id . "'");
    $district_num = $district_rs->num_rows;

    ?>
    <option value="0">Select District</option>
    <?php

    for ($i = 0; $i < $district_num; $i++) {
        $district_data = $district_rs->fetch_assoc();

?>
        <option <?php if($address_num == 1) {if ($district_data["district_id"] == $user_district) {
                ?>selected<?php
                        }}else{echo "";} ?> value='<?php echo $district_data["district_id"]; ?>'>
            <?php echo $district_data["district_name"]; ?>
        </option>
<?php

    }
}

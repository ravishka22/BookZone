<?php

session_start();

if(isset($_SESSION["oid"])){

    $_SESSION["oid"] = null;
    session_destroy();
    echo ("success");

}else {
    echo ("success");
}

?>
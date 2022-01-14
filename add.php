<?php
session_start();
require('functions.php');
require('headers.php');

if(isset($_SESSION["user"])){
    // createInfo(createDbConnection(), "username" , "test@gmail.com", "05012345");
    echo "Welcome ".$_SESSION["user"];
    exit;
}
echo "Ei onnistu";

?>
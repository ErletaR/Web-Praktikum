<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
require("start.php");
var_dump($service->login("Tom", "12345678"));
echo "hallo";
var_dump($service->loadUsers());

?>
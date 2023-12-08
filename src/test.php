<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
require("start.php");
$user = new Model\Friend("Test");
$json = json_encode($user);
$user->set_accepted();
echo $user->get_status();
echo $json . "<br>";
$jsonObject = json_decode($json);
$newUser = Model\Friend::fromJson($jsonObject);
$newUser->set_accepted();
echo $user->get_status();
var_dump($newUser);


?>
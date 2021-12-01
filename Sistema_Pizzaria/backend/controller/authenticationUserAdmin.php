<?php

include('../bd_crud/crud.php');

$path = $_SERVER['SCRIPT_NAME'];
$pathReplace = explode('backend',$path);

$db = new Database();
$db->connect();

$sql = "SELECT name, permission FROM user WHERE email = '" . $_POST["email"] . "' AND password = '" . $_POST["password"] . "';";

$db->sql($sql);

$res = $db->getResult();

if (count($res) > 0) {
  $cookie_name = "user";
  $cookie_value = $res[0]["name"];
  setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

  $cookie_permission = "permission";
  $cookie_value_permission = $res[0]["permission"];
  setcookie($cookie_permission, $cookie_value_permission, time() + (86400 * 30), "/"); // 86400 = 1 day
  header('Location: http://localhost' . $pathReplace[0] . 'frontend/');
} else {
  $cookie_error = "error";
  $cookie_value_error = 'E-mail ou Senha Invalidos';
  setcookie($cookie_error, $cookie_value_error, time() + (5), "/");

  header('Location: http://localhost' . $pathReplace[0] . 'frontend/loginAdmin.php');
}
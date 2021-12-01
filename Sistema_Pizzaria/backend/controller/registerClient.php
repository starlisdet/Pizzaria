<?php

include('../bd_crud/crud.php');

$path = $_SERVER['SCRIPT_NAME'];
$pathReplace = explode('backend',$path);

$date = new DateTime(null, new DateTimeZone('America/Sao_Paulo'));
$db = new Database();
$db->connect();

$table = 'client';
$params = array(
  'name'=> $_POST["name"],
  'email'=> $_POST["email"],
  'password'=> $_POST["password"],
  'telephone'=> $_POST["telephone"],
  'phone'=> $_POST["cellphone"],
  'address'=> $_POST["address"],
  'zip_code'=> $_POST["zipCode"],
  'district'=> $_POST["district"],
  'state'=> $_POST["state"],
  'city'=> $_POST["city"],
  'permission' => 'visitante',
  'created_at'=> date("Y-m-d H:i:s"),
  'updated_at'=> date("Y-m-d H:i:s")
);

$db->insert($table, $params);
$res = $db->getResult();  

header('Location: http://localhost' . $pathReplace[0] . 'frontend/login.php');

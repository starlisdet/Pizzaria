<?php

include('../bd_crud/crud.php');

$path = $_SERVER['SCRIPT_NAME'];
$pathReplace = explode('backend',$path);

$date = new DateTime(null, new DateTimeZone('America/Sao_Paulo'));
$db = new Database();
$db->connect();

$table = 'client';
$where = 'id="' . $_POST["id"] . '"';
$params = array(
  'name'=> $_POST["name"],
  'email'=> $_POST["email"],
  'telephone'=> $_POST["telephone"],
  'phone'=> $_POST["cellphone"],
  'address'=> $_POST["address"],
  'zip_code'=> $_POST["zipCode"],
  'district'=> $_POST["district"],
  'state'=> $_POST["state"],
  'city'=> $_POST["city"],
  'permission' => 'visitante',
  'updated_at'=> date("Y-m-d H:i:s")
);

$db->update($table, $params, $where); // Table name, column names and values, WHERE conditions

$res = $db->getResult();

header('Location: http://localhost' . $pathReplace[0] . 'frontend/clients');

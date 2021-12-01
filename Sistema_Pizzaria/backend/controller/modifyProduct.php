<?php

include('../bd_crud/crud.php');
include('../functions/treatMoney.php');


$path = $_SERVER['SCRIPT_NAME'];
$pathReplace = explode('backend',$path);

$date = new DateTime(null, new DateTimeZone('America/Sao_Paulo'));
$db = new Database();
$db->connect();

$unitary_value = treat($_POST["unitary_value"]);

$table = 'product';
$where = 'id="' . $_POST["id"] . '"';

$params = array (
  'name'=> $_POST["name"],
  'description'=> $_POST["description"],
  'unitary_value'=> $unitary_value,
  'amount'=> $_POST["amount"],
  'updated_at'=> date("Y-m-d H:i:s")
);

$db->update($table, $params, $where); // Table name, column names and values, WHERE conditions

$res = $db->getResult();

header('Location: http://localhost' . $pathReplace[0] . 'frontend');

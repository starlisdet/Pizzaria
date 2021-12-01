<?php

include('../bd_crud/crud.php');
include('../functions/imageUpload.php');
include('../functions/treatMoney.php');

$path = $_SERVER['SCRIPT_NAME'];
$pathReplace = explode('backend',$path);

$date = new DateTime(null, new DateTimeZone('America/Sao_Paulo'));
$db = new Database();
$db->connect();

$url = uploadImage($_FILES);

$unitary_value = treat($_POST["unitary_value"]);

$table = 'product';
$params = array (
  'name_product'=> $_POST["name"],
  'description'=> $_POST["description"],
  'unitary_value'=> $unitary_value,
  'status'=> 1,
  'image'=> $url,
  'amount'=> $_POST["amount"],
  'created_at'=> date("Y-m-d H:i:s"),
  'updated_at'=> date("Y-m-d H:i:s")
);


$db->insert($table, $params);
$res = $db->getResult();  

header('Location: http://localhost' . $pathReplace[0] . 'frontend');

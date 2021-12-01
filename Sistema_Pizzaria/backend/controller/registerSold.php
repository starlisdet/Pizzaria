<?php

include('../bd_crud/crud.php');

$path = $_SERVER['SCRIPT_NAME'];
$pathReplace = explode('backend',$path);

$date = new DateTime(null, new DateTimeZone('America/Sao_Paulo'));
$db = new Database();
$db->connect();

$sale_value = doubleval($_POST["sale_value"]) * intval($_POST["amount"]);

$table = 'sold';
$params = array(
  'id_product'=> intval($_POST["id"]),
  'id_client'=> intval($_POST["id_user"]),
  'amount'=> intval($_POST["amount"]),
  'payment'=> $_POST["payment"],
  'sale_value'=> $sale_value,
  'created_at'=> date("Y-m-d H:i:s"),
  'updated_at'=> date("Y-m-d H:i:s")
);

$db->insert($table, $params);
$res = $db->getResult();

echo("Compra realizada com sucesso <br>");
echo("<a href='http://localhost" . $pathReplace[0] . "frontend'>Voltar</a>");

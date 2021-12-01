<?php

include('../bd_crud/crud.php');
$db = new Database();
$db->connect();

$path = $_SERVER['SCRIPT_NAME'];
$pathReplace = explode('backend',$path);

$table = 'product';
$where = 'id=' . $_GET["id"];

$params = array (
  'status'=> 0
);

$db->update($table, $params, $where); // Table name, column names and values, WHERE conditions


header('Location: http://localhost' . $pathReplace[0] . 'frontend');

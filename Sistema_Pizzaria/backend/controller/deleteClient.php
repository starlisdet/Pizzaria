<?php

include('../bd_crud/crud.php');

$path = $_SERVER['SCRIPT_NAME'];
$pathReplace = explode('backend',$path);

$table = 'client';
$where = 'id=' . $_GET["id"];

$db = new Database();
$db->connect();
$db->delete($table, $where);
$res = $db->getResult();  

header('Location: http://localhost' . $pathReplace[0] . 'frontend/clients.php');

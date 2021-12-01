<?php

// caminho indentificando como se eu estivesse dentro da pasta frontend ???????????????
include('../backend/bd_crud/crud.php');

$db = new Database();
$db->connect();

$table = 'sold';
$lines = array ('product.name_product', 'sold.id', 'sold.created_at', 'sold.payment', 'sold.amount', 'sold.sale_value', 'client.name');
$join = array ('product on product.id = sold.id_product', 'client on client.id = sold.id_client');
$where = null;
$order = 'id DESC';
$limit = null;

$db->select($table, $lines, $join, $where, $order, $limit);

$solds = $db->getResult();

<?php
// Reportar erros
ini_set('display_errors', 1);
error_reporting(E_ALL);
 
// url principal
$home_url="http://localhost/api/";
 
// página dada no parâmetro URL, a página padrão é 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;
 
// definir número de registros por página
$records_per_page = 5;
 
// calcular LIMIT da consulta
$from_record_num = ($records_per_page * $page) - $records_per_page;
?>
<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'layouts/header.php';
require  __DIR__.'/saskaitos.php';

if (!isset($_POST['id'])) {
    include 'layouts/errors.php';
    exit;
}

$saskaitosId = $_POST['id'];
deleteSaskaita($saskaitosId);
// $saskaita = getSaskaitaById($saskaitosId);
// if (!$saskaita) {
//     include 'layouts/errors.php';
//     exit;
// }



?>
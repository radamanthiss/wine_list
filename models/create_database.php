<?php
require_once '../vendor/autoload.php';
include '../controllers/db_connect.php';

$conn = db_connect_initial();

$sql ="CREATE DATABASE IF NOT EXISTS data_wine DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;";
$database = mysqli_query($conn, $sql);
if(!$database){
    echo 'Error to create database </br>';
}
else {
    echo 'Database create successfully </br>';
   
}
?>
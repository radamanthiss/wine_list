<?php
require_once '../vendor/autoload.php';
include '../controllers/db_connect.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$conn = db_connect_initial();
$log = new Logger('Create_database');
$log->pushHandler(new StreamHandler('C:/wamp64/www/list_wine/Log/data_'.date('Y-m-d').'.log', Logger::DEBUG));


$sql ="CREATE DATABASE IF NOT EXISTS data_wine DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;";
$database = mysqli_query($conn, $sql);
if(!$database){
    $error= 'Error to create database ';
    $log->addError("ERROR: ".$error);
    
    echo $error;
}
else {
    $response='Database create successfully ';
    $log->addInfo("Success: ".$response);
    echo $response;
   
}
?>
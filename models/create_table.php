<?php
require_once '../vendor/autoload.php';
include '../controllers/db_connect.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('response');
$log->pushHandler(new StreamHandler('C:/wamp64/www/list_wine/Log/data_'.date('Y-m-d').'.log', Logger::DEBUG));
$conn = db_connect();

$query2 = "CREATE TABLE IF NOT EXISTS `wine` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pubDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
$create_table = mysqli_query($conn, $query2);

if(!$create_table){
    $error = 'Error creating table in database';
    $log->addError($error);
    echo $error;
}
else{
    $response = 'The table was created correctly';
    $log->addInfo($response);
    echo $response;
}
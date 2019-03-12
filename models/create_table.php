<?php
require_once '../vendor/autoload.php';
include '../controllers/db_connect.php';

$conn = db_connect();

$query2 = "CREATE TABLE IF NOT EXISTS `wine` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pubDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
$create_table = mysqli_query($conn, $query2);

if(!$create_table){
    echo 'Error creating table in database';
}
else{
    echo 'The table was created correctly';
}
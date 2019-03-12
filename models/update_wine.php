<?php
require_once '../vendor/autoload.php';
include '../controllers/db_connect.php';



$conn = db_connect();
$query1="SELECT count(*) as total FROM wine";
$conteo = mysqli_query($conn, $query1);
$datos = mysqli_fetch_array($conteo);
$total = $datos["total"];
$affectedRow = 0;

$url ='https://www.winespectator.com/rss/rss?t=dwp';
$feed = file_get_contents($url);
$xml = simplexml_load_string($feed);

if ($total >0){
    $query2 = "TRUNCATE TABLE wine";
    $update = mysqli_query($conn, $query2);
    
    foreach ($xml->channel->item as $item) {
        $date = new DateTime((string)$item->pubDate);
        $title = (string)$item->title;
        $pubDate = $date->format('Y-m-d H:i:s');
        
        $title = $conn->real_escape_string($title);
        
        $sql = "INSERT INTO wine(title,pubDate) VALUES ('$title','$pubDate')";
        $result = mysqli_query($conn, $sql);
        
        if (! empty($result)) {
            $affectedRow ++;
        } else {
            $error_message = mysqli_error($conn);
        }
    }
    $response = "updated wine list";
    
}
else {
    foreach ($xml->channel->item as $item) {
        $date = new DateTime((string)$item->pubDate);
        $title = (string)$item->title;
        $pubDate = $date->format('Y-m-d H:i:s');
        
        $title = $conn->real_escape_string($title);
        
        $sql = "INSERT INTO wine(title,pubDate) VALUES ('$title','$pubDate')";
        $result = mysqli_query($conn, $sql);
        
        if (! empty($result)) {
            $affectedRow ++;
        } else {
            $error_message = mysqli_error($conn);
        }
    }
}
?>

<?php
if ($affectedRow > 0) {
    $message = $affectedRow . " records inserted";
} else {
    $message = "No records inserted";
}

?>
<!doctype html>
<html>
<head>
<title>Update wine list</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Sublime Contact Form Widget Responsive, Login form web template,Flat Pricing tables,Flat Drop downs  Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<style>
.affected-row {
	background: #cae4ca;
	padding: 10px;
	margin-bottom: 20px;
	border: #bdd6bd 1px solid;
	border-radius: 2px;
    color: #6e716e;
}
.error-message {
    background: #eac0c0;
    padding: 10px;
    margin-bottom: 20px;
    border: #dab2b2 1px solid;
    border-radius: 2px;
    color: #5d5b5b;
}
</style>
<link rel="Stylesheet" href="../public/css/common.css" />
<link rel="shortcut icon" href="../public/images/favicon.ico">
</head>
<body>
<main>
<h1>Update wine list</h1>
<div class="affected-row"><?php  echo $response; ?></div>
<div class="affected-row"><?php  echo $message; ?></div>

<?php if (! empty($error_message)) { ?>
<div class="error-message"><?php echo nl2br($error_message); ?></div>
<?php } ?>
</main> 
</body>

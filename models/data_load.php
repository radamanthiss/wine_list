<?php
require_once '../vendor/autoload.php';
include '../controllers/db_connect.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$affectedRow = 0;
$url ='https://www.winespectator.com/rss/rss?t=dwp';
$feed = file_get_contents($url);
$xml = simplexml_load_string($feed);

$conn = db_connect();
$log = new Logger('Charge_Rss');
$log->pushHandler(new StreamHandler('C:/wamp64/www/list_wine/Log/data_'.date('Y-m-d').'.log', Logger::DEBUG));

foreach ($xml->channel->item as $item) {
    $date = new DateTime((string)$item->pubDate);
    $title = (string)$item->title;
    $pubDate = $date->format('Y-m-d H:i:s');
    
    //$title = $conn->real_escape_string($title);
    $data_escape = mysqli_real_escape_string($conn, $title);
    
    $sql = "INSERT INTO wine(title,pubDate) VALUES ('$data_escape','$pubDate')";
    $result = mysqli_query($conn, $sql);
    $str_LogTxt = "DATA: Title: $title , PubDate: $pubDate";
    $log->debug($str_LogTxt);
    if (! empty($result)) {
        $affectedRow ++;
    } else {
        $error_message = mysqli_error($conn);
        $str_LogTxt .= "[ERROR= " . $error_message . "";
        $log->error($str_LogTxt);
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
<title>Charge rss data</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Sublime Contact Form Widget Responsive, Login form web template,Flat Pricing tables,Flat Drop downs  Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<!-- fonts -->
<link href="//fonts.googleapis.com/css?family=Nunito:300,400,700" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Muli:300,400" rel="stylesheet">
<link rel="shortcut icon" href="../public/images/favicon.ico">
<!-- /fonts -->
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
<!-- css -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="Stylesheet" href="../public/css/style.css" />

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body style="padding-top: 50px;">
<h1>Insert Rss Data to database</h1>
<div class="content-w3ls agileits w3 wthree w3-agile w3-agileits agileinfo agile container">
<div class="affected-row"><?php  echo $message; ?></div>
<?php if (! empty($error_message)) { ?>
<div class="error-message"><?php echo nl2br($error_message); ?></div>
<?php } ?>
</div>
</body>
</html>
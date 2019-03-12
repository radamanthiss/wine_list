<?php
require_once '../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$usuario = "root";
$contrasena = "1234";  // en mi caso tengo contraseña pero en casa caso introducidla aquí.
$servidor = "localhost";
$basededatos = "data_wine";

$conn = new mysqli($servidor, $usuario, $contrasena,$basededatos);

$title=($_POST["wines"]);
$title_escape = mysqli_real_escape_string($conn, $title);
$query = "SELECT pubDate FROM wine WHERE title like '%$title_escape%'";
$res=mysqli_query($conn,$query);
$datos = mysqli_fetch_array($res);

$pubDate= $datos["pubDate"];

// inputs
$host = 'rhino.rmq.cloudamqp.com';
$user = 'gnyafmqg';
$pass = 'OSg0J453sOqd0hqmCkIDbIgXB9hYLdli';
$port = 5672;
$exchange = "subscribers";
$queue ='waiters';
$vhost = 'gnyafmqg';
$connection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost);
$channel = $connection->channel();
$channel->queue_declare($queue, false, true, false, false);

$channel->exchange_declare($exchange, 'direct', false, true, false);
$channel->queue_bind($queue, $exchange);
$messageBody = json_encode([
    'title' => $title,
    'pubDate' => $pubDate
]);
$message = new AMQPMessage($messageBody, [
    'content_type' => 'application/json', 
    'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
$channel->basic_publish($message, $exchange);
$channel->close();
$connection->close();


?>
<html>
<head>
<title>Validacion</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Sublime Contact Form Widget Responsive, Login form web template,Flat Pricing tables,Flat Drop downs  Sign up Web Templates, Flat Web Templates, Login signup Responsive web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<!-- fonts -->
<link href="//fonts.googleapis.com/css?family=Nunito:300,400,700" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Muli:300,400" rel="stylesheet">
<!-- /fonts -->

<!-- css -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="Stylesheet" href="../public/css/style.css" />
<link rel="shortcut icon" href="../public/images/favicon.ico">
<!-- /css -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body style="padding-top: 50px;">
<div class="content-w3ls agileits w3 wthree w3-agile w3-agileits agileinfo agile container">
<h1 class="agileits w3 wthree w3-agile w3-agileits agileinfo agile">Mostrar respuesta</h1>

<form action="response.php" method="post" class="form-agileits" id="formulario" name="formulario" >
	<p style="color: ghostwhite;margin-bottom: 1rem;">Seleccione el boton show para saber el estado del pedido realizado</p>
     <div class="form-group" >
        <div class="col-md-12 text-center" >
            <button type="submit" class="btn btn-primary btn-lg" style="margin-bottom: 10px;">Show</button>
        </div>
    </div>
		
</form>

</div>


</body>
</html>


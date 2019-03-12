<?php
require_once '../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// inputs
$host = 'rhino.rmq.cloudamqp.com';
$user = 'gnyafmqg';
$pass = 'OSg0J453sOqd0hqmCkIDbIgXB9hYLdli';
$port = 5672;
$exchange = "subscribers";
$queue ='waiters';
$vhost = 'gnyafmqg';
$login_method = 'AMQPLAIN';
$locale = 'en_US';
$connection_timeout = 3.0;
$read_write_timeout = 120.0;
$heartbeat = 60.0;

$connection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost,false,$login_method,null,$locale,$connection_timeout,$read_write_timeout, null, true, $heartbeat);
$channel = $connection->channel();
$channel->basic_qos(0, '<PREFET_COUNT>', false);

$channel->queue_declare($queue, false, true, false, false);
$channel->exchange_declare($exchange, 'direct', false, true, false);
$channel->queue_bind($queue, $exchange);


function process_message(AMQPMessage $message)
{   
    $messageBody = json_decode($message->body);
    
    $fecha_actual=date('Y-m-d H:i:s');
    $wine = $messageBody->title;
    $date = $messageBody->pubDate;
    
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Validacion</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
        <meta charset="utf-8">
        <link rel="Stylesheet" href="../public/css/common.css" />
        <link rel="shortcut icon" href="../public/images/favicon.ico">
    </head>
    <body>
        <main>
        <h1>Validacion completa</h1>
      	<p>Vino seleccionado: <?php echo $wine ?></p>
    	<?php 
    	if ($date <= $fecha_actual) {
    	    echo '<p>El vino seleccionado se encuentra disponible<p>';
    	}
    	else{
    	    echo '<p>Vino no disponible en estos momentos<p>';
    	}
    	?>
        </main>
       
    </body>
    </html>
    <?php 
    
    $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
    
    if ($message->body === 'quit') {
        $message->delivery_info['channel']->basic_cancel($message->delivery_info['consumer_tag']);
    }
}
$consumerTag = 'local.acer.consumer';
$channel->basic_consume($queue, $consumerTag, false, false, false, false, 'process_message');




//register_shutdown_function('shutdown', $channel, $connection);
while (count($channel->callbacks)) {
    $channel->wait();
    exit();
}

$channel->close();
$connection->close();
?>








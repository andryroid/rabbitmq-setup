<?php
require_once '../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('exchange1', AMQPExchangeType::DIRECT, false, false, false);
$channel->queue_declare('userManagement', false, false, false, true);
$channel->queue_bind('userManagement', 'exchange1', 'isv');
$channel->queue_bind('userManagement', 'exchange1', 'oem_program');
$callback = function ($msg) {
  echo ' [x] Received ', $msg->body, "\n";
};

//$channel->basic_qos(null, 1, null);
$channel->basic_consume('userManagement', '', false, false, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}

$channel->close();
$connection->close();
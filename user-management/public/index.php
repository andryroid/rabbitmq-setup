<?php
require_once '../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exchange\AMQPExchangeType;

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('userManagement', false, false, false, true);
$channel->exchange_declare('exchange1', AMQPExchangeType::DIRECT, false, false, false);
$channel->queue_bind('userManagement', 'exchange1','isv');
$channel->queue_bind('userManagement', 'exchange1','oem_program');
$messageBody = implode(' ', array_slice($argv, 1));
$message = new AMQPMessage($messageBody, array('content_type' => 'application/json', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
$channel->basic_publish($message,'exchange1','oem_program');

$channel->close();
$connection->close();
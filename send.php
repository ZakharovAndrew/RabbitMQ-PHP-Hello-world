<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Connection\AMQPMessage;

$connection = new AMQPStreamConnection(RABBIT_HOST, RABBIT_PORT, RABBIT_USER, RABBIT_PASSWORD);
$channel = $connection->channel();
$channel->queue_declare('hello-world', false, false, false, false);
$msg = new AMQPMessage('Hello world!');
$channel->basic_publish($msg, '', 'hello-world');

echo 'Send "Hello world!"' . PHP_EOL;

$channel->close();
$connection->close();
<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
$connection = new AMQPStreamConnection(RABBIT_HOST, RABBIT_PORT, RABBIT_USER, RABBIT_PASSWORD);
$channel = $connection->channel();

$channel->queue_declare('hello-world', false, false, false, false);

echo 'Waiting for message. To exit press CTRL+C'.PHP_EOL;

$callback = function($msg) {
    echo 'MESSAGE: ' . $msg->body . PHP_EOL;
};

$channel->basic_consume('hello-world', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
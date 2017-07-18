<?php

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * DESCRIPTION
 * ---------------------------------------------------------------------------------------------------------------------
 * This file contains the example of using Socket clients.
 *
 * ---------------------------------------------------------------------------------------------------------------------
 * USAGE
 * ---------------------------------------------------------------------------------------------------------------------
 * To run this example in CLI from project root use following syntax
 *
 * $> php ./example/socket_only_client.php
 *
 * ---------------------------------------------------------------------------------------------------------------------
 */

require_once __DIR__ . '/bootstrap/autoload.php';

use Dazzle\Loop\Model\SelectLoop;
use Dazzle\Loop\Loop;
use Dazzle\Socket\Socket;
use Dazzle\Socket\SocketInterface;

$loop = new Loop(new SelectLoop);

$socket = new Socket('tcp://127.0.0.1:2080', $loop);

$socket->on('data', function(SocketInterface $client, $data) use(&$buffer) {
    printf("%s\n", $data);
    $client->close();
});
$socket->on('close', function() use($loop) {
    $loop->stop();
});

$loop->onStart(function() use($socket) {
    $socket->write('Hello!');
});

$loop->start();

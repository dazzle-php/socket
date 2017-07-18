<?php

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * DESCRIPTION
 * ---------------------------------------------------------------------------------------------------------------------
 * This file contains the example of using Socket clients with secure SSL connection.
 *
 * ---------------------------------------------------------------------------------------------------------------------
 * USAGE
 * ---------------------------------------------------------------------------------------------------------------------
 * To run this example in CLI from project root use following syntax
 *
 * $> php ./example/socket_only_server.php
 *
 * ---------------------------------------------------------------------------------------------------------------------
 */

require_once __DIR__ . '/bootstrap/autoload.php';

use Dazzle\Loop\Model\SelectLoop;
use Dazzle\Loop\Loop;
use Dazzle\Socket\SocketInterface;
use Dazzle\Socket\SocketListener;

$loop = new Loop(new SelectLoop);

$server = new SocketListener('tcp://127.0.0.1:2080', $loop);

$server->on('connect', function($server, SocketInterface $client) {
    printf("New secure connection #%s from %s!\n", $res = $client->getResourceId(), $client->getLocalAddress());

    $client->on('data', function(SocketInterface $client, $data) use(&$buffer) {
        printf("%s\n", $data);
        $client->write('secret answer!');
    });
    $client->on('close', function() use($res) {
        printf("Closed connection #$res\n");
    });
});
$server->start();

$loop->start();

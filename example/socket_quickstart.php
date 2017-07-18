<?php

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * DESCRIPTION
 * ---------------------------------------------------------------------------------------------------------------------
 * This file contains the example of using Socket component to send messages between client and listeners with IPv4.
 *
 * ---------------------------------------------------------------------------------------------------------------------
 * USAGE
 * ---------------------------------------------------------------------------------------------------------------------
 * To run this example in CLI from project root use following syntax
 *
 * $> php ./example/socket_quickstart.php
 *
 * Following flags are supported to test example:
 *
 * --mode  : define whether socket or client should be created, default: standard, supported: [ client, server ]
 *
 * Remember that to see working communication, you need to create server and at least one client!
 *
 * $> php ./example/socket_quickstart.php --mode=server
 * $> php ./example/socket_quickstart.php --mode=client
 *
 * ---------------------------------------------------------------------------------------------------------------------
 */

$mode = 'client';

require_once __DIR__ . '/bootstrap/autoload.php';

use Dazzle\Loop\Model\SelectLoop;
use Dazzle\Loop\Loop;
use Dazzle\Socket\Socket;
use Dazzle\Socket\SocketInterface;
use Dazzle\Socket\SocketListener;

$loop = new Loop(new SelectLoop);

if ($mode === 'server')
{
    $server = new SocketListener('tcp://127.0.0.1:2080', $loop);

    $server->on('connect', function($server, SocketInterface $client) {
        $client->write("Hello!\n");
        $client->write("Welcome to Dazzle server!\n");
        $client->write("Tell me a range and I will randomize a number for you!\n\n");

        $client->on('data', function(SocketInterface $client, $data) use(&$buffer) {
            $client->write("Your number is: " . rand(...explode('-', $data)));
        });
    });
    $server->start();
}

if ($mode === 'client')
{
    $socket = new Socket('tcp://127.0.0.1:2080', $loop);
    $socket->on('data', function($socket, $data) {
        printf("%s", $data);
    });
    $socket->write('1-100');
}

$loop->start();

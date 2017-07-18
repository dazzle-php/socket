<?php

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * DESCRIPTION
 * ---------------------------------------------------------------------------------------------------------------------
 * This file contains the example of using Socket component to send messages between client and listeners with IPv6.
 *
 * ---------------------------------------------------------------------------------------------------------------------
 * USAGE
 * ---------------------------------------------------------------------------------------------------------------------
 * To run this example in CLI from project root use following syntax
 *
 * $> php ./example/socket_conn_tcp_ipv6.php
 *
 * Following flags are supported to test example:
 *
 * --mode  : define whether socket or client should be created, default: standard, supported: [ client, server ]
 *
 * Remember that to see working communication, you need to create server and at least one client!
 *
 * $> php ./example/socket_conn_tcp_ipv6.php --mode=server
 * $> php ./example/socket_conn_tcp_ipv6.php --mode=client
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
    $server = new SocketListener('tcp://[::1]:2080', $loop);

    $server->on('connect', function($server, SocketInterface $client) {
        printf("New connection #%s from %s!\n", $res = $client->getResourceId(), $client->getLocalAddress());

        $client->on('data', function($client, $data) use(&$buffer) {
            printf("Received message=\"%s\"\n", $data);
        });
        $client->on('close', function() use($res) {
            printf("Closed connection #$res\n");
        });
    });
    $server->start();
}

if ($mode === 'client')
{
    $socket = new Socket('tcp://[::1]:2080', $loop);
    $socket->on('close', function() use($loop) {
        printf("Server has closed the connection!\n");
        $loop->stop();
    });

    $loop->addPeriodicTimer(1, function() use($socket) {
        $socket->write('Hello World!');
    });
}

$loop->start();

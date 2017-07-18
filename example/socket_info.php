<?php

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * DESCRIPTION
 * ---------------------------------------------------------------------------------------------------------------------
 * This file contains the example of using methods created for getting the information about the incoming/outcoming
 * socket connections.
 *
 * ---------------------------------------------------------------------------------------------------------------------
 * USAGE
 * ---------------------------------------------------------------------------------------------------------------------
 * To run this example in CLI from project root use following syntax
 *
 * $> php ./example/socket_info.php
 *
 * Following flags are supported to test example:
 *
 * --mode  : define whether socket or client should be created, default: standard, supported: [ client, server ]
 *
 * Remember that to see working communication, you need to create server and at least one client!
 *
 * $> php ./example/socket_info.php --mode=server
 * $> php ./example/socket_info.php --mode=client
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

        printf("%s\n", str_repeat('-', 42));
        printf("%s\n", 'Client info:');
        printf("%s\n", str_repeat('-', 42));
        printf("%-20s%s\n", 'Resource ID:', '#' . $client->getResourceId());
        printf("%-20s%s\n", 'Local endpoint:', $client->getLocalEndpoint());
        printf("%-20s%s\n", 'Local protocol:', $client->getLocalProtocol());
        printf("%-20s%s\n", 'Local address:', $client->getLocalAddress());
        printf("%-20s%s\n", 'Local host:', $client->getLocalHost());
        printf("%-20s%s\n", 'Local port:', $client->getLocalPort());
        printf("%-20s%s\n", 'Remote endpoint:', $client->getRemoteEndpoint());
        printf("%-20s%s\n", 'Remote protocol:', $client->getRemoteProtocol());
        printf("%-20s%s\n", 'Remote address:', $client->getRemoteAddress());
        printf("%-20s%s\n", 'Remote host:', $client->getRemoteHost());
        printf("%-20s%s\n", 'Remote port:', $client->getRemotePort());
        printf("%s\n", str_repeat('-', 42));

        $client->close();
    });
    $server->start();
}

if ($mode === 'client')
{
    $socket = new Socket('tcp://127.0.0.1:2080', $loop);
    $socket->on('close', function() use($loop) {
        $loop->stop();
    });
}

$loop->start();

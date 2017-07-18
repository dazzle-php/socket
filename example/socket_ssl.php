<?php

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * DESCRIPTION
 * ---------------------------------------------------------------------------------------------------------------------
 * This file contains the example of using Socket component to send messages between client and listeners using secure
 * SSL connection.
 *
 * ---------------------------------------------------------------------------------------------------------------------
 * USAGE
 * ---------------------------------------------------------------------------------------------------------------------
 * To run this example in CLI from project root use following syntax
 *
 * $> php ./example/socket_ssl.php
 *
 * Following flags are supported to test example:
 *
 * --mode  : define whether socket or client should be created, default: standard, supported: [ client, server ]
 *
 * Remember that to see working communication, you need to create server and at least one client!
 *
 * $> php ./example/socket_ssl.php --mode=server
 * $> php ./example/socket_ssl.php --mode=client
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
    // additional supported configuration options:
    // ssl_method
    // ssl_name
    // ssl_verify_sign
    // ssl_verify_peer
    // ssl_verify_depth
    $config = [
        'ssl'        => true,
        'ssl_cert'   => __DIR__ . '/ssl/_ssl_cert.pem',
        'ssl_key'    => __DIR__ . '/ssl/_ssl_key.pem',
        'ssl_secret' => 'secret',
    ];
    $server = new SocketListener('tcp://127.0.0.1:2080', $loop, $config);

    $server->on('connect', function($server, SocketInterface $client) {
        printf("New secure connection #%s from %s!\n", $res = $client->getResourceId(), $client->getLocalAddress());

        $client->on('data', function(SocketInterface $client, $data) use(&$buffer) {
            printf("Received question=\"%s\"\n", $data);
            $client->write('secret answer!');
        });
        $client->on('close', function() use($res) {
            printf("Closed connection #$res\n");
        });
    });
    $server->start();
}

if ($mode === 'client')
{
    // additional supported configuration options:
    // ssl_method
    // ssl_name
    // ssl_verify_sign
    // ssl_verify_peer
    // ssl_verify_depth
    $config = [
        'ssl' => true
    ];
    $socket = new Socket('tcp://127.0.0.1:2080', $loop, $config);

    $socket->on('data', function(SocketInterface $client, $data) use(&$buffer) {
        printf("Received answer=\"%s\"\n", $data);
    });
    $socket->on('close', function() use($loop) {
        printf("Server has closed the connection!\n");
        $loop->stop();
    });

    $loop->addPeriodicTimer(1, function() use($socket) {
        $socket->write('secret question!');
    });
}

$loop->start();

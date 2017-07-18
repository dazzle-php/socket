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
 * $> php ./example/socket_ssl_only_server.php
 *
 * ---------------------------------------------------------------------------------------------------------------------
 */

require_once __DIR__ . '/bootstrap/autoload.php';

use Dazzle\Loop\Model\SelectLoop;
use Dazzle\Loop\Loop;
use Dazzle\Socket\SocketInterface;
use Dazzle\Socket\SocketListener;

$loop = new Loop(new SelectLoop);

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
        printf("%s\n", $data);
        $client->write('secret answer!');
    });
    $client->on('close', function() use($res) {
        printf("Closed connection #$res\n");
    });
});
$server->start();

$loop->start();

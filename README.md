# Dazzle Async Socket

[![Build Status](https://travis-ci.org/dazzle-php/socket.svg)](https://travis-ci.org/dazzle-php/socket)
[![Code Coverage](https://scrutinizer-ci.com/g/dazzle-php/socket/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/dazzle-php/socket/?branch=master)
[![Code Quality](https://scrutinizer-ci.com/g/dazzle-php/socket/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dazzle-php/socket/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/dazzle-php/socket/v/stable)](https://packagist.org/packages/dazzle-php/socket) 
[![Latest Unstable Version](https://poser.pugx.org/dazzle-php/socket/v/unstable)](https://packagist.org/packages/dazzle-php/socket) 
[![License](https://poser.pugx.org/dazzle-php/socket/license)](https://packagist.org/packages/dazzle-php/socket/license)

> **Note:** This repository is part of [Dazzle Project](https://github.com/dazzle-php/dazzle) - the next-gen library for PHP. The project's purpose is to provide PHP developers with a set of complete tools to build functional async applications. Please, make sure you read the attached README carefully and it is guaranteed you will be surprised how easy to use and powerful it is. In the meantime, you might want to check out the rest of our async libraries in [Dazzle repository](https://github.com/dazzle-php) for the full extent of Dazzle experience.

<br>
<p align="center">
<img src="https://raw.githubusercontent.com/dazzle-php/dazzle/master/media/dazzle-x125.png" />
</p>

## Description

Dazzle Socket is a component that implements asynchronous tcp, udp and unix socket handling for PHP. The library also provides interface for implementing self inter-process communication via external services.

## Feature Highlights

Dazzle Socket features:

* Asynchronous handling of incoming and outcoming messages,
* Support for TCP, UDP and Unix sockets,
* ...and more.

## Provided Example(s)

### Quickstart

Server file which accepts the range in format of $min-$max and returns randomized number.

```php
$loop = new Loop(new SelectLoop);
$server = new SocketListener('tcp://127.0.0.1:2080', $loop);

$server->on('connect', function($server, SocketInterface $client) {
    $client->write("Hello!\n");
    $client->write("Welcome to Dazzle server!\n");
    $client->write("Tell me a range and I will randomize a number for you!\n\n");

    $client->on('data', function(SocketInterface $client, $data) use(&$buffer) {
        $client->write("Your number is: " . rand(...explode('-', $data)));
    });
});

$loop->onStart(function() use($server) {
    $server->start();
});
$loop->start();
```

Client file which sends the $min-$max format to the above server and gets the response.

```php
$loop = new Loop(new SelectLoop);
$socket = new Socket('tcp://127.0.0.1:2080', $loop);

$socket->on('data', function($socket, $data) {
    printf("%s", $data);
});
$socket->write('1-100');

$loop->start();
```

### Additional

Additional examples can be found in [example](https://github.com/dazzle-php/socket/tree/master/example) directory. Below is the list of provided examples as a reference and preferred consumption order:

- [Quickstart](https://github.com/dazzle-php/socket/blob/master/example/events_quickstart.php)
- [Using socket client](https://github.com/dazzle-php/socket/blob/master/example/socket_only_client.php)
- [Using socket server](https://github.com/dazzle-php/socket/blob/master/example/socket_only_server.php)
- [Creating TCP IPv4 client-server connection](https://github.com/dazzle-php/socket/blob/master/example/socket_conn_tcp.php)
- [Creating TCP IPv6 client-server connection](https://github.com/dazzle-php/socket/blob/master/example/socket_conn_tcp_ipv6.php)
- [Creating UNIX socket client-server connection](https://github.com/dazzle-php/socket/blob/master/example/socket_conn_unix.php)
- [Getting connection info](https://github.com/dazzle-php/socket/blob/master/example/socket_info.php)
- [Using secure SSL socket client](https://github.com/dazzle-php/socket/blob/master/example/socket_ssl_only_client.php)
- [Using secure SSL socket server](https://github.com/dazzle-php/socket/blob/master/example/socket_ssl_only_server.php)
- [Creating secure SSL client-server connection](https://github.com/dazzle-php/socket/blob/master/example/socket_ssl.php)

If any of the above examples has left you confused, please take a look in the [tests](https://github.com/dazzle-php/socket/tree/master/test) directory as well.

## Requirements

Dazzle Socket requires:

* PHP-5.6 or PHP-7.0+,
* UNIX or Windows OS.

## Installation

To install this library make sure you have [composer](https://getcomposer.org/) installed, then run following command:

```
$> composer require dazzle-php/socket
```

## Tests

Tests can be run via:

```
$> vendor/bin/phpunit -d memory_limit=1024M
```

## Versioning

Versioning of Dazzle libraries is being shared between all packages included in [Dazzle Project](https://github.com/dazzle-php/dazzle). That means the releases are being made concurrently for all of them. On one hand this might lead to "empty" releases for some packages at times, but don't worry. In the end it is far much easier for contributors to maintain and -- what's the most important -- much more straight-forward for users to understand the compatibility and inter-operability of the packages.

## Contributing

Thank you for considering contributing to this repository! 

- The contribution guide can be found in the [contribution tips](https://github.com/dazzle-php/socket/blob/master/CONTRIBUTING.md). 
- Open tickets can be found in [issues section](https://github.com/dazzle-php/socket/issues). 
- Current contributors are listed in [graphs section](https://github.com/dazzle-php/socket/graphs/contributors)
- To contact the author(s) see the information attached in [composer.json](https://github.com/dazzle-php/socket/blob/master/composer.json) file.

## License

Dazzle Socket is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

<hr>
<p align="center">
<i>"Everything is possible. The impossible just takes longer."</i> ― Dan Brown
</p>


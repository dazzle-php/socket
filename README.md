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
<img src="https://avatars0.githubusercontent.com/u/29509136?v=3&s=150" />
</p>

## Description

Dazzle Socket is a component that implements asynchronous tcp, udp and unix socket handling for PHP. The library also provides interface for implementing self inter-process communication via external services.

## Feature Highlights

Dazzle Socket features:

* Asynchronous handling of incoming and outcoming messages,
* Support for TCP, UDP and Unix sockets,
* ...and more.

## Requirements

* PHP-5.6 or PHP-7.0+,
* UNIX or Windows OS.

## Installation

```
$> composer require dazzle-php/socket
```

## Tests

```
$> vendor/bin/phpunit -d memory_limit=1024M
```

## Contributing

Thank you for considering contributing to this repository! The contribution guide can be found in the [contribution tips][1].

## License

Dazzle Framework is open-sourced software licensed under the [MIT license][2].

[1]: https://github.com/dazzle-php/socket/blob/master/CONTRIBUTING.md
[2]: http://opensource.org/licenses/MIT

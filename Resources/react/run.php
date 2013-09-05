#!/usr/bin/env php
<?php

require __DIR__.'/../../../../../../vendor/autoload.php';

$port = isset($argv[1]) ? $argv[1] : 1337;
$masterAddress = isset($argv[2]) ? $argv[2] : '127.0.0.1';
$loop = React\EventLoop\Factory::create();
$socket = new React\Socket\Server($loop);
$connections = new \SplObjectStorage();

$socket->on('connection', function (\React\Socket\Connection $newConnection) use ($connections, $masterAddress) {
    file_put_contents('/tmp/log', $newConnection->getRemoteAddress()."\n", FILE_APPEND);
    $connections->attach($newConnection);
    file_put_contents('/tmp/log', ($newConnection->isReadable()?'r':'')."\n", FILE_APPEND);
    file_put_contents('/tmp/log', ($newConnection->isWritable()?'w':'')."\n", FILE_APPEND);
    $status = $newConnection->write('hello');
    file_put_contents('/tmp/log', ($status?'ok':'ko')."\n", FILE_APPEND);

    // broadcasts data from application
    if ($masterAddress === $newConnection->getRemoteAddress()) {
        $newConnection->on('data', function ($data) use ($connections, $newConnection, $masterAddress) {
            /** @var \React\Socket\Connection $clientConnection */
            foreach ($connections as $clientConnection) {
                if ($masterAddress !== $clientConnection->getRemoteAddress()) {
                    $clientConnection->write($data);
                }
            }
        });
    }

    // ping-pong
    $newConnection->on('data', function ($data) use ($newConnection) {
        if ('ping' === $data) {
            $newConnection->write('pong');
        }
    });

    // connection closed
    $newConnection->on('end', function () use ($connections, $newConnection) {
        $connections->detach($newConnection);
    });
});

echo "Socket server listening on port $port.\n";
echo "You can connect to it by running: nc localhost $port\n";

$socket->listen($port);
$loop->run();

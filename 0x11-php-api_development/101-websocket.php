<?php
/**
 * 101-websocket.php
 *
 * Simple WebSocket server using Ratchet.
 */

require dirname(__DIR__) . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;

class Chat implements MessageComponentInterface {
    public function onOpen(ConnectionInterface $conn) {
        echo "New connection\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "Received: $msg\n";
        $from->send("Echo: $msg");
    }

    public function onClose(ConnectionInterface $conn) {
        echo "Connection closed\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}

$server = IoServer::factory(
    new HttpServer(new Chat()),
    8080
);

echo "WebSocket server started on port 8080\n";
$server->run();
?>
/**
 * Run with: php 101-websocket.php
 * Client can connect using WebSocket client libraries in JS or Python.
 */


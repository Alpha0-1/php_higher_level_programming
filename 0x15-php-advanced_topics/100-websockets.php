<?php
/**
 * Demonstrates WebSocket implementation in PHP
 * 
 * Note: Requires Ratchet library (composer require cboden/ratchet)
 */

// Basic WebSocket server implementation
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class Chat implements MessageComponentInterface
{
    private SplObjectStorage $clients;

    public function __construct()
    {
        $this->clients = new SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) - 1;
        echo sprintf(
            'Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $msg,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send("Client {$from->resourceId} says: $msg");
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

// To run the server (uncomment to use):
// $server = IoServer::factory(
//     new HttpServer(
//         new WsServer(
//             new Chat()
//         )
//     ),
//     8080
// );
// echo "WebSocket server running on port 8080\n";
// $server->run();

/**
 * WebSocket client example (using Ratchet's client component)
 * 
 * Note: Requires ratchet/pawl (composer require ratchet/pawl)
 */
// 
// use Ratchet\Client\WebSocket;
// 
// function connectToWebSocket()
// {
//     $loop = React\EventLoop\Factory::create();
//     $reactConnector = new React\Socket\Connector($loop);
//     $connector = new Ratchet\Client\Connector($loop, $reactConnector);
// 
//     $connector('ws://localhost:8080')
//         ->then(function(WebSocket $conn) {
//             echo "Connected to WebSocket server\n";
// 
//             $conn->on('message', function($msg) use ($conn) {
//                 echo "Received: {$msg}\n";
//             });
// 
//             $conn->on('close', function($code = null, $reason = null) {
//                 echo "Connection closed ({$code} - {$reason})\n";
//             });
// 
//             // Send a message every 2 seconds
//             $loop = React\EventLoop\Factory::create();
//             $loop->addPeriodicTimer(2, function() use ($conn) {
//                 $conn->send("Hello from client at " . date('H:i:s'));
//             });
//             $loop->run();
//         }, function(\Exception $e) use ($loop) {
//             echo "Could not connect: {$e->getMessage()}\n";
//             $loop->stop();
//         });
// 
//     $loop->run();
// }
// 
// // Uncomment to run client
// // connectToWebSocket();

/**
 * Alternative: Using Amp's WebSocket client
 * 
 * Note: Requires amphp/websocket-client
 * composer require amphp/websocket-client
 */
// 
// use Amp\Websocket\Client;
// use Amp\Websocket\Message;
// 
// Amp\Loop::run(function () {
//     $connection = yield Client\connect('ws://localhost:8080');
// 
//     yield $connection->send('Hello from Amp client!');
// 
//     /** @var Message $message */
//     while ($message = yield $connection->receive()) {
//         $payload = yield $message->buffer();
//         echo "Received: {$payload}\n";
//     }
// });

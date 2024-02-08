<?php
include "../../config/StageServer.php";
include "../../utils/Chat.php";
include "../../utils/headers.php";
require '../../vendor/autoload.php';
// require_once("../../config/Config.php");


use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;

class MyWebSocketServer implements MessageComponentInterface {
    protected $clients;
    protected $conn;


    public function __construct($conn) {
        $this->clients = new \SplObjectStorage;
        $this->conn=$conn;
  
    }

    public function onOpen(ConnectionInterface $connection) {
        $this->clients->attach($connection);
        echo "New connection! ({$connection->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        // Handle incoming messages
        $chat = new Chat($this->conn);
        if ($msg === 'getHistory') {
            $history = $chat->fetchMessageHistory();
            $from->send(json_encode($history));
        } else {
            $userId=3;
            $from=3;
            $to="Admin";
            $acceptKey="32";
            
            $chat->saveMessageToDatabase($userId,$from,$acceptKey,$to,$msg);
            foreach ($this->clients as $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $connection) {
        $this->clients->detach($connection);
        echo "Connection {$connection->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $connection, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $connection->close();
    }

 
}

// Start the WebSocket server
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new MyWebSocketServer($conn)
        )
    ),
    8080
);

$server->run();

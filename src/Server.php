<?php

declare(strict_types=1);

namespace ApDev\WebSocket;

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use SplObjectStorage;
use Symfony\Component\Console\Output\OutputInterface;

class Server implements MessageComponentInterface
{
    /** @var SplObjectStorage */
    private $clients;
    /** @var OutputInterface */
    private $output;

    public function __construct(OutputInterface $output)
    {
        $this->clients = new SplObjectStorage();
        $this->output = $output;
    }

    public function onOpen(ConnectionInterface $conn): void
    {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg): void
    {
        foreach ($this->clients as $client) {
            if ($from === $client) {
                $this->output->writeln("Message received: $msg");
                $client->send('received');
            }
        }
    }

    public function onClose(ConnectionInterface $conn): void
    {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, Exception $e): void
    {
        $conn->close();
    }
}

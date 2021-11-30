<?php

declare(strict_types=1);

namespace ApDev\WebSocket\Command\Server;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WebSocket\Server;

class RunCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('server:run');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $server = new Server(['port' => 8080, 'timeout' => 3600]);
        $server->accept();

        while ($message = $server->receive()) {
            $output->writeln("Received message \"$message\"");
        }

        $server->close();

        return Command::SUCCESS;
    }
}

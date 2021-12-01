<?php

declare(strict_types=1);

namespace ApDev\WebSocket\Command\Server;

use ApDev\WebSocket\Server;
use Ratchet\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('server:run');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $app = new App('localhost', 8080, '0.0.0.0');

        $app->route('/', new Server($output), ['*']);

        $app->run();

        return Command::SUCCESS;
    }
}

<?php
namespace App\Command;

use App\Service\ZooBotAPI;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command {

    public static $defaultName = 'zoobot:test';
    private ZooBotAPI $zooBotAPI;

    public function __construct(ZooBotAPI $zooBotAPI)
    {
        $this->zooBotAPI = $zooBotAPI;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Testing functions');
    }

    protected function execute(InputInterface$input, OutputInterface $output): int
    {
        $output->writeln('');
        $output->writeln('--Running Test--');
        $output->writeln(dump($this->zooBotAPI->getToken()));
        return Command::SUCCESS;
    }
}
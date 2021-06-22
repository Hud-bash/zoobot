<?php
namespace App\Command;

use App\Service\ZooBotSQL;
use App\Service\ZooName;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command {

    public static $defaultName = 'zoobot:test';
    private ZooName $zooName;
    private ZooBotSQL $zooBotSQL;

    public function __construct(ZooName $zooName,ZooBotSQL $zooBotSQL)
    {
        $this->zooName = $zooName;
        $this->zooBotSQL = $zooBotSQL;

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
        $output->writeln($this->zooBotSQL->UpdateMarket());
        return Command::SUCCESS;
    }
}
<?php
namespace App\Command;

use App\Service\ZooBotAPI;
use App\Service\ZooBotSQL;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command {

    public static $defaultName = 'zoo:test';
    private ZooBotAPI $zooBotAPI;
    private ZooBotSQL $zooBotSQL;

    public function __construct(ZooBotAPI $zooBotAPI,ZooBotSQL $zooBotSQL)
    {
        $this->zooBotAPI = $zooBotAPI;
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
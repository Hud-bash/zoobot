<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\ZooBotSQL;

class ZooBotSnipeCommand extends Command {

    public static $defaultName = 'zoobot:snipe';
    private ZooBotSQL $zooBotSQL;

    public function __construct(ZooBotSQL $zooBotSQL)
    {
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
        $output->writeln('--Running Test Command--');
        $output->writeln($this->zooBotSQL->UpdateMarket());
        return Command::SUCCESS;
    }
}
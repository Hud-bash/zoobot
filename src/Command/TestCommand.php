<?php
namespace App\Command;

use App\Service\WanAPI;
use App\Service\ZooBotSQL;
use App\Service\ZooName;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command {

    public static $defaultName = 'zoobot:test';
    private ZooName $zooName;
    private ZooBotSQL $zooBotSQL;
    private WanAPI $wanAPI;

    public function __construct(ZooName $zooName,ZooBotSQL $zooBotSQL, WanAPI $wanAPI)
    {
        $this->zooName = $zooName;
        $this->zooBotSQL = $zooBotSQL;
        $this->wanAPI = $wanAPI;

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
        $output->writeln($this->wanAPI->GetTokenId('0x6e11655d6aB3781C6613db8CB1Bc3deE9a7e111F'));
        return Command::SUCCESS;
    }
}
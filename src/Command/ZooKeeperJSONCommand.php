<?php
namespace App\Command;

use App\Service\ZooBotAPI;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ZooKeeperJSONCommand extends Command
{
    public static $defaultName = 'zoo:getjson';
    private ZooBotAPI $zapi;

    public function __construct(ZooBotAPI $zapi)
    {
        $this->zapi = $zapi;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Update JSON from zookeeper RPC server');
    }

    protected function execute(InputInterface$input, OutputInterface $output): int
    {
        $this->zapi->GetNft();
        $this->zapi->GetChestHistory();
        $this->zapi->GetMarketHistory();
        $this->zapi->GetMarket();
        $this->zapi->GetNftLock();
        $this->zapi->GetToken();
        return Command::SUCCESS;
    }
}
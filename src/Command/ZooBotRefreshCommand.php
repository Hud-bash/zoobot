<?php
namespace App\Command;

use App\Service\ZooName;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\ZooBotSQL;

class ZooBotRefreshCommand extends Command {

    public static $defaultName = 'zoo:update';
    private ZooBotSQL $zooBotSQL;
    private ZooName $zooName;

    public function __construct(ZooBotSQL $zooBotSQL, ZooName $zooName)
    {
        $this->zooBotSQL = $zooBotSQL;
        $this->zooName = $zooName;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Update all datatables from zookeeper');
    }

    protected function execute(InputInterface$input, OutputInterface $output): int
    {
        $output->writeln('');
        $output->writeln('--Running Refresh--');
        $output->writeln($this->zooBotSQL->UpdateNft());
        $output->writeln($this->zooBotSQL->UpdateNftLock());
        $output->writeln($this->zooBotSQL->UpdateMarket());
        $output->writeln($this->zooBotSQL->UpdateMarketHistory());
        $output->writeln($this->zooBotSQL->UpdateChestHistory());
        $output->writeln($this->zooBotSQL->UpdateToken());
        $output->writeln($this->zooName->UpdateNullNames());

        return Command::SUCCESS;
    }
}
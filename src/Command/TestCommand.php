<?php
namespace App\Command;

use App\Service\ZooName;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command {

    public static $defaultName = 'zoobot:test';
    private ZooName $zooName;

    public function __construct(ZooName $zooName)
    {
        $this->zooName = $zooName;

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
        $output->writeln($this->zooName->GenerateName());
        return Command::SUCCESS;
    }
}
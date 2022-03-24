<?php

namespace App\Command\Importer;

use App\Service\Importer\ImportCustomerService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'importer:import-customers',
    description: 'A command allows you to import customers to our database from your provided provider.',
)]
class ImportCustomersCommand extends Command
{
    /**
     * @see Command
     */
    public function __construct(
        protected ImportCustomerService $importer
    ) {
        parent::__construct();
    }

    /**
     * @see Command
     */
    protected function configure(): void
    {
        $this->setDescription('A command allows you to import customers to our database from your provided provider.')
            ->addArgument('providerId', InputArgument::OPTIONAL, 'Id of the data provider', 'randomuser');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $providerId = $input->getArgument('providerId');

        $io->info(sprintf('Running importer for provider [%s].', $providerId));

        $this->importer->run($providerId);

        $io->success('Customers has imported successfully');

        return Command::SUCCESS;
    }
}

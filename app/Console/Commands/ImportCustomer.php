<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Importer\ImportCustomerService;

class ImportCustomer extends Command
{
    /**
     * @inheritDoc
     */
    protected $signature = 'import:customers';

    /**
     * @inheritDoc
     */
    protected $description = 'A command to import customers from the application data provider';

    /**
     * Handle command
     *
     * @return void
     */
    public function handle(ImportCustomerService $importer): void
    {
        $this->info('Starting customer import.');

        // execute
        $importer->run();

        $this->info('Customers imported successfully.');
    }
}
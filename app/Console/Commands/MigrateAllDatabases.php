<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateAllDatabases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:all {--refresh : Drop all tables and re-run migrations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate all individual databases';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database_connections = ['task_tech_db', 'task_accounts_db', 'task_sales_db', 'task_inquiry_db', 'task_feedback_db'];
        $command = $this->option('refresh') ? 'migrate:refresh' : 'migrate';

        foreach ($database_connections as $connection) {
            $this->info("Running {$command} on database: {$connection}");
            
            try {
                $this->call($command, [
                    '--database' => $connection,
                    '--path' => 'database/migrations',
                    '--force' => true,
                ]);
                $this->info("✓ {$connection} migrated successfully");
            } catch (\Exception $e) {
                $this->error("✗ Failed to migrate {$connection}: " . $e->getMessage());
            }
        }

        $this->info('All databases migration process completed!');
    }
}

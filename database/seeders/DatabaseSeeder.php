<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;
use Database\Factories\TicketFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $entryCount = 10;
        $types = [
            'technical_issues' => 'task_tech_db',
            'account_billing' => 'task_accounts_db',
            'product_service' => 'task_sales_db',
            'general_inquiry' => 'task_inquiry_db',
            'feedback' => 'task_feedback_db',
        ];
        
        foreach ($types as $type => $connection) {
            for ($i = 0; $i < $entryCount; $i++) {
                $ticket = Ticket::factory()->make(['type' => $type]);
                Ticket::on($connection)->create($ticket->toArray());
            }
        }
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;
use Database\Factories\TicketFactory;
use App\Helpers\TypeHelper;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $entryCount = 2;
        
        foreach (TypeHelper::getAllTypes() as $type => $connection) {
            for ($i = 0; $i < $entryCount; $i++) {
                $ticket = Ticket::factory()->make(['type' => $type]);
                Ticket::on($connection)->create($ticket->toArray());
            }
        }
        $this->call(UserSeeder::class);
    }
}

<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{   
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            OrganizerSeeder::class,
            AttendeeSeeder::class,
            EventSeeder::class,
        ]);
    }
}

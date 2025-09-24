<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class OrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 2 organizers
        $organizers = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@eventorganizer.com',
                'password' => Hash::make('password123'),
                'role' => 'organizer',
                'privacy_policy_accepted' => true,
                'privacy_policy_accepted_at' => now(),
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael@eventorganizer.com',
                'password' => Hash::make('password123'),
                'role' => 'organizer',
                'privacy_policy_accepted' => true,
                'privacy_policy_accepted_at' => now(),
            ]
        ];

        foreach ($organizers as $organizer) {
            User::create($organizer);
        }
    }
}
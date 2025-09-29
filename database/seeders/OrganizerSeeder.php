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
        // Create 5 organizers
        $organizers = [
            [
                'first_name' => 'Sarah',
                'last_name'=> 'Johnson',
                'email' => 'sarah@guebs.com',
                'password' => Hash::make('aa000000'),
                'role' => 'organizer',
                'privacy_policy_accepted' => true,
                'privacy_policy_accepted_at' => now(),
            ],
            [
                'first_name' => 'Michael',
                'last_name'=> 'Chen',
                'email' => 'michael@guebs.com',
                'password' => Hash::make('aa000000'),
                'role' => 'organizer',
                'privacy_policy_accepted' => true,
                'privacy_policy_accepted_at' => now(),
            ],
            [
                'first_name' => 'Emma',
                'last_name'=> 'Williams',
                'email' => 'emma@guebs.com',
                'password' => Hash::make('aa000000'),
                'role' => 'organizer',
                'privacy_policy_accepted' => true,
                'privacy_policy_accepted_at' => now(),
            ],
            [
                'first_name' => 'David',
                'last_name'=> 'Rodriguez',
                'email' => 'david@guebs.com',
                'password' => Hash::make('aa000000'),
                'role' => 'organizer',
                'privacy_policy_accepted' => true,
                'privacy_policy_accepted_at' => now(),
            ],
            [
                'first_name' => 'Kevin',
                'last_name'=> 'Foo',
                'email' => 'kevin@guebs.com',
                'password' => Hash::make('aa000000'),
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
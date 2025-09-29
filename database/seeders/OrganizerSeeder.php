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
                'name' => 'Sarah Johnson',
                'email' => 'sarah@guebs.com',
                'password' => Hash::make('aa000000'),
                'role' => 'organizer',
                'privacy_policy_accepted' => true,
                'privacy_policy_accepted_at' => now(),
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael@guebs.com',
                'password' => Hash::make('aa000000'),
                'role' => 'organizer',
                'privacy_policy_accepted' => true,
                'privacy_policy_accepted_at' => now(),
            ],
            [
                'name' => 'Emma Williams',
                'email' => 'emma@guebs.com',
                'password' => Hash::make('aa000000'),
                'role' => 'organizer',
                'privacy_policy_accepted' => true,
                'privacy_policy_accepted_at' => now(),
            ],
            [
                'name' => 'David Rodriguez',
                'email' => 'david@guebs.com',
                'password' => Hash::make('aa000000'),
                'role' => 'organizer',
                'privacy_policy_accepted' => true,
                'privacy_policy_accepted_at' => now(),
            ],
            [
                'name' => 'Kevin Foo',
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
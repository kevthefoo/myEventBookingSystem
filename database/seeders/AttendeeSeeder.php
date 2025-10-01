<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AttendeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 organizers
        $attendee = [
            'first_name' => 'Kevin',
            'last_name'=> 'Foo',
            'email' => 'kevthefoo@gmail.com',
            'password' => Hash::make('aa000000'),
            'role' => 'Attendee',
            'privacy_policy_accepted' => true,
            'privacy_policy_accepted_at' => now(),
        ];

        User::create($attendee);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Event;


class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $events = [
            [
                'title' => 'Griffith Programming Club: Python Workshop',
                'description' => 'Learn Python fundamentals with hands-on coding exercises. Perfect for beginners and intermediate programmers. Laptops provided.',
                'date' => '2025-09-27',
                'time' => '14:00',
                'location' => 'Griffith University - IT Building, Room 2.15',
                'capacity' => 40,
            ],
            [
                'title' => 'Drama Society: Shakespeare Night Performance',
                'description' => 'Annual Shakespeare performance featuring scenes from Hamlet and Romeo & Juliet. Open to all students and staff.',
                'date' => '2025-10-01',
                'time' => '19:00',
                'location' => 'Griffith University - Performing Arts Theatre',
                'capacity' => 200,
            ],
            [
                'title' => 'Environmental Club: Campus Cleanup Day',
                'description' => 'Join us for our monthly campus cleanup initiative. Help make Griffith University more sustainable. Free lunch provided!',
                'date' => '2025-10-04',
                'time' => '09:00',
                'location' => 'Griffith University - Main Campus Courtyard',
                'capacity' => 80,
            ],
            [
                'title' => 'Chess Club Championship Tournament',
                'description' => 'Annual Griffith University Chess Championship. Open to all skill levels. Prizes for top 3 winners.',
                'date' => '2025-10-08',
                'time' => '13:00',
                'location' => 'Griffith University - Student Centre, Level 1',
                'capacity' => 60,
            ],
            [
                'title' => 'Photography Society: Wildlife Photography Walk',
                'description' => 'Explore the beautiful Griffith University campus and surrounding areas. Learn wildlife photography techniques from our expert members.',
                'date' => '2025-10-12',
                'time' => '08:00',
                'location' => 'Griffith University - Nathan Campus, Nature Reserve',
                'capacity' => 25,
            ],
            [
                'title' => 'Debate Society: Inter-University Debate Competition',
                'description' => 'Watch Griffith University debate team compete against top universities. Topic: "Social Media has a Net Positive Impact on Society"',
                'date' => '2025-10-15',
                'time' => '18:30',
                'location' => 'Griffith University - Law Building, Moot Court',
                'capacity' => 120,
            ],
            [
                'title' => 'Music Society: Open Mic Night',
                'description' => 'Showcase your musical talents! Open to singers, musicians, poets, and comedians. Sign-ups start at 6 PM.',
                'date' => '2025-10-19',
                'time' => '18:00',
                'location' => 'Griffith University - Student Bar & Cafe',
                'capacity' => 100,
            ],
            [
                'title' => 'Gaming Club: Esports Tournament - League of Legends',
                'description' => 'Griffith University Gaming Club presents our biggest esports tournament of the semester. Team registration required.',
                'date' => '2025-10-22',
                'time' => '15:00',
                'location' => 'Griffith University - Computer Labs, Building N44',
                'capacity' => 80,
            ],
            [
                'title' => 'Entrepreneurship Society: Startup Pitch Competition',
                'description' => 'Present your startup ideas to real investors and industry experts. $5000 prize for the winning pitch!',
                'date' => '2025-10-26',
                'time' => '17:00',
                'location' => 'Griffith University - Business Building, Auditorium',
                'capacity' => 150,
            ],
            [
                'title' => 'International Students Club: Cultural Food Festival',
                'description' => 'Experience flavors from around the world! Students from different countries will showcase their traditional cuisines.',
                'date' => '2025-10-29',
                'time' => '11:00',
                'location' => 'Griffith University - Main Lawn Area',
                'capacity' => 300,
            ]
        ];

        $organizers = User::where('role', 'organizer')->pluck('id');

        foreach ($events as $eventData) {
            $event = Event::create([
                ...$eventData,
                'organizer_id' => $organizers->random()
            ]);
        }
    }
}
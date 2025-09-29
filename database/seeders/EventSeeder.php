<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run(): void
    {
                $events = [
            // Original 10 events
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
                'capacity' => 200,
            ],
            [
                'title' => 'Science Society: Chemistry Lab Workshop',
                'description' => 'Hands-on chemistry experiments and demonstrations. Learn about organic compounds and chemical reactions in a safe lab environment.',
                'date' => '2025-11-02',
                'time' => '10:00',
                'location' => 'Griffith University - Science Building, Lab 3.12',
                'capacity' => 30,
            ],
            [
                'title' => 'Film Club: Documentary Screening Night',
                'description' => 'Screening of award-winning documentaries followed by discussion. This month: "The Social Dilemma" and "Blackfish".',
                'date' => '2025-11-05',
                'time' => '19:30',
                'location' => 'Griffith University - Media Arts Centre, Theatre A',
                'capacity' => 75,
            ],
            [
                'title' => 'Business Society: Networking Mixer',
                'description' => 'Connect with industry professionals, alumni, and fellow students. Formal attire required. Light refreshments provided.',
                'date' => '2025-11-08',
                'time' => '18:00',
                'location' => 'Griffith University - Business Building, Conference Room',
                'capacity' => 90,
            ],
            [
                'title' => 'Yoga Club: Outdoor Meditation Session',
                'description' => 'Relaxing outdoor yoga and meditation session. Perfect for stress relief during exam season. Bring your own mat.',
                'date' => '2025-11-12',
                'time' => '07:00',
                'location' => 'Griffith University - Botanical Gardens',
                'capacity' => 50,
            ],
            [
                'title' => 'Engineering Society: Robotics Competition',
                'description' => 'Build and program robots to complete various challenges. Teams of 3-4 students. Components and tools provided.',
                'date' => '2025-11-15',
                'time' => '09:00',
                'location' => 'Griffith University - Engineering Workshop, Building G25',
                'capacity' => 64,
            ],
            [
                'title' => 'Literature Club: Poetry Reading Evening',
                'description' => 'Share your original poetry or read works from famous poets. Open to all writing enthusiasts. Snacks and tea provided.',
                'date' => '2025-11-18',
                'time' => '17:30',
                'location' => 'Griffith University - Library, Quiet Study Area',
                'capacity' => 35,
            ],
            [
                'title' => 'Dance Society: Ballroom Dancing Workshop',
                'description' => 'Learn basic ballroom dancing steps including waltz, tango, and foxtrot. No partner required - we rotate!',
                'date' => '2025-11-22',
                'time' => '16:00',
                'location' => 'Griffith University - Sports Centre, Dance Studio',
                'capacity' => 40,
            ],
            [
                'title' => 'Cooking Club: International Cuisine Night',
                'description' => 'Learn to cook dishes from around the world. This session: Italian pasta and Japanese sushi making.',
                'date' => '2025-11-25',
                'time' => '18:30',
                'location' => 'Griffith University - Hospitality Training Kitchen',
                'capacity' => 20,
            ],
            [
                'title' => 'Art Society: Painting Workshop - Landscapes',
                'description' => 'Acrylic painting workshop focusing on landscape techniques. All materials provided. Suitable for beginners.',
                'date' => '2025-11-29',
                'time' => '14:00',
                'location' => 'Griffith University - Art Studios, Room 2.08',
                'capacity' => 25,
            ],
            [
                'title' => 'Marketing Club: Social Media Strategy Seminar',
                'description' => 'Learn effective social media marketing strategies from industry experts. Certificate of participation provided.',
                'date' => '2025-12-02',
                'time' => '13:30',
                'location' => 'Griffith University - Business Lecture Theatre',
                'capacity' => 120,
            ],
            [
                'title' => 'Tennis Club: Doubles Tournament',
                'description' => 'Annual doubles tennis tournament. Register with your partner or we will match you with someone of similar skill level.',
                'date' => '2025-12-05',
                'time' => '08:30',
                'location' => 'Griffith University - Tennis Courts',
                'capacity' => 32,
            ],
            [
                'title' => 'Psychology Society: Mental Health Awareness Workshop',
                'description' => 'Important workshop on mental health awareness and stress management techniques for university students.',
                'date' => '2025-12-08',
                'time' => '11:00',
                'location' => 'Griffith University - Health Sciences Building, Lecture Hall',
                'capacity' => 100,
            ],
            [
                'title' => 'Astronomy Club: Stargazing Night',
                'description' => 'Night of stargazing with professional telescopes. Learn about constellations and planets. Weather permitting.',
                'date' => '2025-12-12',
                'time' => '20:00',
                'location' => 'Griffith University - Observatory Roof',
                'capacity' => 15,
            ],
            [
                'title' => 'Fashion Society: Sustainable Fashion Show',
                'description' => 'Showcase of sustainable and eco-friendly fashion designs by students. Followed by discussion on fast fashion impact.',
                'date' => '2025-12-15',
                'time' => '19:00',
                'location' => 'Griffith University - Student Centre Atrium',
                'capacity' => 180,
            ],
            [
                'title' => 'Computer Science Society: AI and Machine Learning Workshop',
                'description' => 'Introduction to artificial intelligence and machine learning concepts. Hands-on coding session with Python.',
                'date' => '2025-12-18',
                'time' => '10:00',
                'location' => 'Griffith University - Computer Labs, Building N16',
                'capacity' => 45,
            ],
            [
                'title' => 'Volleyball Club: Beach Tournament',
                'description' => 'Beach volleyball tournament at nearby Currumbin Beach. Transport provided. Bring sunscreen and water!',
                'date' => '2025-12-22',
                'time' => '09:00',
                'location' => 'Currumbin Beach - South Patrol Area',
                'capacity' => 24,
            ],
            [
                'title' => 'History Society: Archaeological Site Visit',
                'description' => 'Educational visit to local historical sites and archaeological digs. Learn about Queensland\'s colonial history.',
                'date' => '2026-01-05',
                'time' => '08:00',
                'location' => 'Brisbane Historical Sites (Bus departure from campus)',
                'capacity' => 30,
            ],
            [
                'title' => 'Debate Club: Public Speaking Workshop',
                'description' => 'Improve your public speaking and presentation skills. Great for overcoming stage fright and building confidence.',
                'date' => '2026-01-08',
                'time' => '15:00',
                'location' => 'Griffith University - Student Centre, Meeting Room 3',
                'capacity' => 40,
            ],
            [
                'title' => 'Environmental Club: Sustainability Fair',
                'description' => 'Learn about sustainable living practices, renewable energy, and environmental conservation. Interactive exhibits.',
                'date' => '2026-01-12',
                'time' => '10:00',
                'location' => 'Griffith University - Outdoor Plaza',
                'capacity' => 150,
            ],
            [
                'title' => 'Mathematics Society: Problem Solving Competition',
                'description' => 'Test your mathematical problem-solving skills in this friendly competition. Prizes for top performers.',
                'date' => '2026-01-15',
                'time' => '14:00',
                'location' => 'Griffith University - Mathematics Building, Room 2.15',
                'capacity' => 60,
            ],
            [
                'title' => 'Cultural Society: Multicultural Night',
                'description' => 'Celebration of diverse cultures with traditional music, dance performances, and cultural displays from around the world.',
                'date' => '2026-01-18',
                'time' => '18:00',
                'location' => 'Griffith University - Great Hall',
                'capacity' => 300,
            ],
            [
                'title' => 'Study Group: Final Exam Preparation',
                'description' => 'Collaborative study session for final exams. Share notes, practice problems, and study techniques with fellow students.',
                'date' => '2026-01-22',
                'time' => '13:00',
                'location' => 'Griffith University - Library, Group Study Rooms',
                'capacity' => 80,
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
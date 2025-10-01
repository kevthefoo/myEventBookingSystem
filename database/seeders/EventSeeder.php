<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Event;
use App\Models\Category;

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
                'time' => '14:00',
                'location' => 'IT Building, Room 2.15',
                'capacity' => 40,
                'categories' => ['Technology']
            ],
            [
                'title' => 'Drama Society: Shakespeare Night Performance',
                'description' => 'Annual Shakespeare performance featuring scenes from Hamlet and Romeo & Juliet. Open to all students and staff.',
                'time' => '19:00',
                'location' => 'Performing Arts Theatre',
                'capacity' => 200,
                'categories' => ['Arts & Culture']
            ],
            [
                'title' => 'Environmental Club: Campus Cleanup Day',
                'description' => 'Join us for our monthly campus cleanup initiative. Help make Griffith University more sustainable. Free lunch provided!',
                'time' => '09:00',
                'location' => 'Main Campus Courtyard',
                'capacity' => 80,
                'categories' => ['Social & Networking', 'Health & Wellness']
            ],
            [
                'title' => 'Chess Club Championship Tournament',
                'description' => 'Annual Griffith University Chess Championship. Open to all skill levels. Prizes for top 3 winners.',
                'time' => '13:00',
                'location' => 'Student Centre, Level 1',
                'capacity' => 60,
                'categories' => ['Entertainment']
            ],
            [
                'title' => 'Photography Society: Wildlife Photography Walk',
                'description' => 'Explore the beautiful Griffith University campus and surrounding areas. Learn wildlife photography techniques from our expert members.',
                'time' => '08:00',
                'location' => 'Nathan Campus, Nature Reserve',
                'capacity' => 25,
                'categories' => ['Arts & Culture']
            ],
            [
                'title' => 'Debate Society: Inter-University Debate Competition',
                'description' => 'Watch Griffith University debate team compete against top universities. Topic: "Social Media has a Net Positive Impact on Society"',
                'time' => '18:30',
                'location' => 'Law Building, Moot Court',
                'capacity' => 120,
                'categories' => ['Academic']
            ],
            [
                'title' => 'Music Society: Open Mic Night',
                'description' => 'Showcase your musical talents! Open to singers, musicians, poets, and comedians. Sign-ups start at 6 PM.',
                'time' => '18:00',
                'location' => 'Student Bar & Cafe',
                'capacity' => 100,
                'categories' => ['Arts & Culture', 'Entertainment']
            ],
            [
                'title' => 'Gaming Club: Esports Tournament - League of Legends',
                'description' => 'Griffith University Gaming Club presents our biggest esports tournament of the semester. Team registration required.',
                'time' => '15:00',
                'location' => 'Computer Labs, Building N44',
                'capacity' => 80,
                'categories' => ['Entertainment', 'Technology']
            ],
            [
                'title' => 'Entrepreneurship Society: Startup Pitch Competition',
                'description' => 'Present your startup ideas to real investors and industry experts. $5000 prize for the winning pitch!',
                'time' => '17:00',
                'location' => 'Business Building, Auditorium',
                'capacity' => 150,
                'categories' => ['Career Development']
            ],
            [
                'title' => 'International Students Club: Cultural Food Festival',
                'description' => 'Experience flavors from around the world! Students from different countries will showcase their traditional cuisines.',
                'time' => '11:00',
                'location' => 'Main Lawn Area',
                'capacity' => 200,
                'categories' => ['Arts & Culture', 'Social & Networking']
            ],
            [
                'title' => 'Science Society: Chemistry Lab Workshop',
                'description' => 'Hands-on chemistry experiments and demonstrations. Learn about organic compounds and chemical reactions in a safe lab environment.',
                'time' => '10:00',
                'location' => 'Science Building, Lab 3.12',
                'capacity' => 30,
                'categories' => ['Academic']
            ],
            [
                'title' => 'Film Club: Documentary Screening Night',
                'description' => 'Screening of award-winning documentaries followed by discussion. This month: "The Social Dilemma" and "Blackfish".',
                'time' => '19:30',
                'location' => 'Media Arts Centre, Theatre A',
                'capacity' => 75,
                'categories' => ['Arts & Culture']
            ],
            [
                'title' => 'Business Society: Networking Mixer',
                'description' => 'Connect with industry professionals, alumni, and fellow students. Formal attire required. Light refreshments provided.',
                'time' => '18:00',
                'location' => 'Business Building, Conference Room',
                'capacity' => 90,
                'categories' => ['Social & Networking', 'Career Development']
            ],
            [
                'title' => 'Yoga Club: Outdoor Meditation Session',
                'description' => 'Relaxing outdoor yoga and meditation session. Perfect for stress relief during exam season. Bring your own mat.',
                'time' => '07:00',
                'location' => 'Botanical Gardens',
                'capacity' => 50,
                'categories' => ['Health & Wellness']
            ],
            [
                'title' => 'Engineering Society: Robotics Competition',
                'description' => 'Build and program robots to complete various challenges. Teams of 3-4 students. Components and tools provided.',
                'time' => '09:00',
                'location' => 'Engineering Workshop, Building G25',
                'capacity' => 64,
                'categories' => ['Technology']
            ],
            [
                'title' => 'Literature Club: Poetry Reading Evening',
                'description' => 'Share your original poetry or read works from famous poets. Open to all writing enthusiasts. Snacks and tea provided.',
                'time' => '17:30',
                'location' => 'Library, Quiet Study Area',
                'capacity' => 35,
                'categories' => ['Arts & Culture']
            ],
            [
                'title' => 'Dance Society: Ballroom Dancing Workshop',
                'description' => 'Learn basic ballroom dancing steps including waltz, tango, and foxtrot. No partner required - we rotate!',
                'time' => '16:00',
                'location' => 'Sports Centre, Dance Studio',
                'capacity' => 40,
                'categories' => ['Sports & Fitness', 'Arts & Culture']
            ],
            [
                'title' => 'Cooking Club: International Cuisine Night',
                'description' => 'Learn to cook dishes from around the world. This session: Italian pasta and Japanese sushi making.',
                'time' => '18:30',
                'location' => 'Hospitality Training Kitchen',
                'capacity' => 20,
                'categories' => ['Arts & Culture', 'Social & Networking']
            ],
            [
                'title' => 'Art Society: Painting Workshop - Landscapes',
                'description' => 'Acrylic painting workshop focusing on landscape techniques. All materials provided. Suitable for beginners.',
                'time' => '14:00',
                'location' => 'Art Studios, Room 2.08',
                'capacity' => 25,
                'categories' => ['Arts & Culture']
            ],
            [
                'title' => 'Marketing Club: Social Media Strategy Seminar',
                'description' => 'Learn effective social media marketing strategies from industry experts. Certificate of participation provided.',
                'time' => '13:30',
                'location' => 'Business Lecture Theatre',
                'capacity' => 120,
                'categories' => ['Career Development', 'Technology']
            ],
            [
                'title' => 'Tennis Club: Doubles Tournament',
                'description' => 'Annual doubles tennis tournament. Register with your partner or we will match you with someone of similar skill level.',
                'time' => '08:30',
                'location' => 'Tennis Courts',
                'capacity' => 32,
                'categories' => ['Sports & Fitness']
            ],
            [
                'title' => 'Psychology Society: Mental Health Awareness Workshop',
                'description' => 'Important workshop on mental health awareness and stress management techniques for university students.',
                'time' => '11:00',
                'location' => 'Health Sciences Building, Lecture Hall',
                'capacity' => 100,
                'categories' => ['Health & Wellness', 'Academic']
            ],
            [
                'title' => 'Astronomy Club: Stargazing Night',
                'description' => 'Night of stargazing with professional telescopes. Learn about constellations and planets. Weather permitting.',
                'time' => '20:00',
                'location' => 'Observatory Roof',
                'capacity' => 15,
                'categories' => ['Academic']
            ],
            [
                'title' => 'Fashion Society: Sustainable Fashion Show',
                'description' => 'Showcase of sustainable and eco-friendly fashion designs by students. Followed by discussion on fast fashion impact.',
                'time' => '19:00',
                'location' => 'Student Centre Atrium',
                'capacity' => 180,
                'categories' => ['Arts & Culture', 'Health & Wellness']
            ],
            [
                'title' => 'Computer Science Society: AI and Machine Learning Workshop',
                'description' => 'Introduction to artificial intelligence and machine learning concepts. Hands-on coding session with Python.',
                'time' => '10:00',
                'location' => 'Computer Labs, Building N16',
                'capacity' => 45,
                'categories' => ['Technology', 'Academic']
            ],
            [
                'title' => 'Volleyball Club: Beach Tournament',
                'description' => 'Beach volleyball tournament at nearby Currumbin Beach. Transport provided. Bring sunscreen and water!',
                'time' => '09:00',
                'location' => 'Currumbin Beach - South Patrol Area',
                'capacity' => 24,
                'categories' => ['Sports & Fitness']
            ],
            [
                'title' => 'History Society: Archaeological Site Visit',
                'description' => 'Educational visit to local historical sites and archaeological digs. Learn about Queensland\'s colonial history.',
                'time' => '08:00',
                'location' => 'Brisbane Historical Sites (Bus departure from campus)',
                'capacity' => 30,
                'categories' => ['Academic']
            ],
            [
                'title' => 'Debate Club: Public Speaking Workshop',
                'description' => 'Improve your public speaking and presentation skills. Great for overcoming stage fright and building confidence.',
                'time' => '15:00',
                'location' => 'Student Centre, Meeting Room 3',
                'capacity' => 40,
                'categories' => ['Career Development', 'Academic']
            ],
            [
                'title' => 'Environmental Club: Sustainability Fair',
                'description' => 'Learn about sustainable living practices, renewable energy, and environmental conservation. Interactive exhibits.',
                'time' => '10:00',
                'location' => 'Outdoor Plaza',
                'capacity' => 150,
                'categories' => ['Social & Networking', 'Health & Wellness']
            ],
            [
                'title' => 'Mathematics Society: Problem Solving Competition',
                'description' => 'Test your mathematical problem-solving skills in this friendly competition. Prizes for top performers.',
                'time' => '14:00',
                'location' => 'Mathematics Building, Room 2.15',
                'capacity' => 60,
                'categories' => ['Academic']
            ],
            [
                'title' => 'Cultural Society: Multicultural Night',
                'description' => 'Celebration of diverse cultures with traditional music, dance performances, and cultural displays from around the world.',
                'time' => '18:00',
                'location' => 'Great Hall',
                'capacity' => 300,
                'categories' => ['Arts & Culture', 'Social & Networking']
            ],
            [
                'title' => 'Study Group: Final Exam Preparation',
                'description' => 'Collaborative study session for final exams. Share notes, practice problems, and study techniques with fellow students.',
                'time' => '13:00',
                'location' => 'Library, Group Study Rooms',
                'capacity' => 80,
                'categories' => ['Academic']
            ]
        ];

        $organizers = User::where('role', 'organizer')->pluck('id');

        foreach ($events as $eventData) {
            // Extract categories from event data
            $categories = $eventData['categories'];
            unset($eventData['categories']); // Remove categories from event data

            // Create the event
            $event = Event::create([
                'uuid' => Str::uuid(),
                'date' =>fake()->dateTimeBetween('2025-10-25', '2026-3-15')->format('Y-m-d'),
                ...$eventData,
                'organizer_id' => $organizers->random(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Attach categories to the event
            foreach ($categories as $categoryName) {
                $category = Category::where('name', $categoryName)->first();
                if ($category) {
                    $event->categories()->attach($category->id);
                }
            }
        }
    }
}
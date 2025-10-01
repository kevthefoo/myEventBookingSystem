<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Academic',
                'slug'=> 'academic',
                'color' => '#3B82F6',
                'icon' => '📚',
                'description' => 'Educational events, workshops, and academic activities'
            ],
            [
                'name' => 'Sports & Fitness',
                'slug'=> 'sports-fitness',
                'color' => '#EF4444',
                'icon' => '⚽',
                'description' => 'Sports events, fitness activities, and outdoor adventures'
            ],
            [
                'name' => 'Arts & Culture',
                'slug'=> 'arts-culture',
                'color' => '#8B5CF6',
                'icon' => '🎨',
                'description' => 'Creative workshops, cultural events, and artistic performances'
            ],
            [
                'name' => 'Technology',
                'slug'=> 'technology',
                'color' => '#10B981',
                'icon' => '💻',
                'description' => 'Tech talks, coding workshops, and innovation events'
            ],
            [
                'name' => 'Social & Networking',
                'slug'=> 'social-networking',
                'color' => '#F59E0B',
                'icon' => '🤝',
                'description' => 'Networking events, social gatherings, and community building'
            ],
            [
                'name' => 'Career Development',
                'slug'=> 'career-development',
                'color' => '#6366F1',
                'icon' => '🚀',
                'description' => 'Career workshops, job fairs, and professional development'
            ],
            [
                'name' => 'Entertainment',
                'slug'=> 'entertainment',
                'color' => '#EC4899',
                'icon' => '🎉',
                'description' => 'Fun events, parties, games, and entertainment activities'
            ],
            [
                'name' => 'Health & Wellness',
                'slug'=> 'health-wellness',
                'color' => '#14B8A6',
                'icon' => '🧘',
                'description' => 'Wellness workshops, mental health events, and healthy living'
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }
    }
}
<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryFilteringTest extends TestCase
{
    use RefreshDatabase;

    protected $organizer;
    protected $categories;
    
    protected function setUp(): void
    {
        parent::setUp();
        
    }

    public function test_events_page_shows_category_filters()
    {
        $event = Event::factory()->create();
        $categories = Category::factory()->create(['name'=> 'Sports']);

        $event->categories()->attach( $categories->id);

        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('Sports');
    }

    public function test_organizer_can_add_new_category()
    {
        $organizer = User::factory()->create(['role' => 'organizer']);

        $categoryData = [
            'name' => 'New Test Category',
            'slug' => 'ntc',
            'color' => '#FF5733',
            'icon' => '🆕',
            'description' => 'A brand new test category',
            'is_active' => true
        ];

        $response = $this->actingAs($organizer)
            ->post('/addcategory', $categoryData);

        $response->assertJson([
            'success' => true,
            'message' => 'Category created successfully!'
        ]);

        // Check category was created in database
        $this->assertDatabaseHas('categories', [
            'name' => 'New Test Category',
            'slug' => 'ntc',
            'color' => '#FF5733',
            'icon' => '🆕',
            'description' => 'A brand new test category',
            'is_active' => true
        ]);
    }
}
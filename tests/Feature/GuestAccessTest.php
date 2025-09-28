<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Event;
use App\Models\User;

class GuestAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test organizer
        $organizer = User::create([
            'name' => 'Test Organizer',
            'email' => 'organizer@test.com',
            'password' => bcrypt('password'),
            'role' => 'organizer',
        ]);

        // Create test events
        Event::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'title' => 'Future Event 1',
            'description' => 'Test event description',
            'date' => now()->addDays(7)->format('Y-m-d'),
            'time' => '14:00:00',
            'location' => 'Test Location',
            'capacity' => 50,
            'organizer_id' => $organizer->id,
        ]);

        Event::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'title' => 'Future Event 2',
            'description' => 'Test event description 2',
            'date' => now()->addDays(14)->format('Y-m-d'),
            'time' => '15:00:00',
            'location' => 'Test Location 2',
            'capacity' => 30,
            'organizer_id' => $organizer->id,
        ]);
    }

    public function test_a_guest_can_view_the_paginated_list_of_upcoming_events()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Future Event 1');
        $response->assertSee('Future Event 2');
        $response->assertSee('Test Location');
    }

    public function test_a_guest_can_view_a_specific_event_details_page()
    {
        $event = Event::first();

        $response = $this->get("/events/{$event->uuid}");

        $response->assertStatus(200);
        $response->assertSee($event->title);
        $response->assertSee($event->description);
        $response->assertSee($event->location);
    }

    public function test_a_guest_is_redirected_when_accessing_protected_routes()
    {
        // Test protected routes that require authentication
        $protectedRoutes = [
            '/mybookings',
            '/eventmanager',
            '/admin/dashboard',
        ];

        foreach ($protectedRoutes as $route) {
            $response = $this->get($route);
            
            // Should redirect to login or show unauthorized message
            $this->assertTrue(
                $response->status() === 302 || 
                $response->status() === 401 || 
                $response->status() === 403
            );
        }
    }

    public function test_a_guest_cannot_see_action_buttons_on_event_details_page()
    {
        $event = Event::first();

        $response = $this->get("/events/{$event->uuid}");

        $response->assertStatus(200);
        // Should not see booking buttons or edit buttons
        $response->assertDontSee('Book This Event');
        $response->assertDontSee('Edit Event');
        $response->assertDontSee('Delete Event');
        // Should see login prompt instead
        $response->assertSee('Please log in to book');
    }
}
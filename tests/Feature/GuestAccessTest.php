<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Event;
use App\Models\User;

class GuestAccessTest extends TestCase
{
    use RefreshDatabase;

    protected $organizer;
    protected $user;
    protected $event_1;
    protected $event_2;
        
    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test organizer
        $this->organizer = User::factory()->create([
            'role' => 'organizer',
        ]);

        // Create test events
        $this->event_1 = Event::factory()->create([
            'organizer_id' => $this->organizer->id,
        ]);

        $this->event_2 = Event::factory()->create([
            'organizer_id' => $this->organizer->id,
        ]);
    }

    public function test_a_guest_can_view_the_paginated_list_of_upcoming_events()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee($this->event_1->title);
        $response->assertSee($this->event_2->title);
        $response->assertSee($this->event_1->location);
        $response->assertSee($this->event_2->location);
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

        $response = $this->get("/events/{$this->event_1->uuid}");

        $response->assertStatus(200);

        // Should not see booking buttons or edit buttons
        $response->assertDontSee('Book This Event');
        $response->assertDontSee('Edit Event');
        $response->assertDontSee('Delete Event');
        
        // Should see login prompt instead
        $response->assertSee('Please log in to book');
    }
}
<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;

class OrganiserActionsTest extends TestCase
{
    use RefreshDatabase;

    protected $organizer;
    protected $user;
    protected $event;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test organizer
        $this->organizer = User::create([
            'first_name' => 'Test Organizer First Name',
            'last_name' => 'Test Organizer Last Name',
            'email' => 'organizer@test.com',
            'password' => bcrypt('password'),
            'role' => 'organizer',
        ]);

        // Create regular user
        $this->user = User::create([
            'first_name' => 'New User First Name',
            'last_name' => 'New User Last Name',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'role' => 'Attendee',
        ]);



        // Create test event
        $this->event = Event::create([
            'uuid' => Str::uuid(),
            'title' => 'Test Event',
            'description' => 'Test event description',
            'date' => now()->addDays(7)->format('Y-m-d'),
            'time' => '14:00:00',
            'location' => 'Test Location',
            'capacity' => 50,
            'organizer_id' => $this->organizer->id,
        ]);
    }

    public function test_an_organiser_can_access_the_dashboard()
    {
        $response = $this->actingAs($this->organizer)->get('/admin/dashboard');

        $response->assertStatus(200);
 
        $response->assertSee('Total Events');
        $response->assertSee('Total Bookings');
        $response->assertSee('Upcoming Events');
        $response->assertSee('Total Capacity');

    }

    public function test_an_organiser_can_create_a_new_event()
    {
        $category = Category::create([
        'name' => 'Sports & Fitness',
        'slug' => 'sports-fitness',
        'color' => '#123456',
        'icon' => '🏀',
        'description' => 'Sports events',
        'is_active' => true,
        ]);

        $eventData = [
            'title' => 'New Test Event',
            'description' => 'New test event description',
            'date' => now()->addDays(1)->format('Y-m-d'),
            'time' => '16:00',
            'location' => 'New Test Location',
            'capacity' => 75,
            'categories' => [$category->id]
        ];

        $response = $this->actingAs($this->organizer)
            ->post('/eventmanager/create', $eventData);

        $response->assertRedirect('/eventmanager');
        $response->assertSessionHas('success', 'Event created successfully!');
        
        $this->assertDatabaseHas('events', [
            'title' => 'New Test Event',
            'location' => 'New Test Location',
            'capacity' => 75,
            'organizer_id' => $this->organizer->id,
        ]);
    }

    public function test_event_creation_fails_with_validation_errors()
    {
        $invalidData = [
            'title' => '', // Required field empty
            'description' => '',
            'date' => 'invalid-date',
            'time' => 'invalid-time',
            'location' => '',
            'capacity' => -5, // Invalid capacity
        ];

        $response = $this->actingAs($this->organizer)
            ->post('/eventmanager/create', $invalidData);

        $response->assertStatus(302); // Redirect back with errors
        $response->assertSessionHasErrors(['title', 'date', 'time', 'location', 'capacity']);
        
        // Should not create event in database
        $this->assertDatabaseMissing('events', [
            'title' => '',
            'organizer_id' => $this->organizer->id,
        ]);
    }

    public function test_an_organiser_can_update_their_own_event()
    {
        $category = Category::create([
        'name' => 'Sports & Fitness',
        'slug' => 'sports-fitness',
        'color' => '#123456',
        'icon' => '🏀',
        'description' => 'Sports events',
        'is_active' => true,
        ]);

        $updatedData = [
            'title' => 'Updated Event Title',
            'description' => 'Updated description',
            'date' => now()->addDays(10)->format('Y-m-d'),
            'time' => '15:30',
            'location' => 'Updated Location',
            'capacity' => 100,
            'categories' => [$category->id]
        ];

        $response = $this->actingAs($this->organizer)
            ->put("/eventmanager/edit/{$this->event->uuid}", $updatedData);

        $response->assertRedirect('/eventmanager');
        $response->assertSessionHas('success', 'Event updated successfully with categories!');
        
        $this->assertDatabaseHas('events', [
            'id' => $this->event->id,
            'title' => 'Updated Event Title',
            'location' => 'Updated Location',
            'capacity' => 100,
        ]);
    }

    public function test_an_organiser_cannot_update_another_organisers_event()
    {
        // Create another organizer and their event
        $otherOrganizer = User::create([
            'first_name' => 'Other Organizer First Name',
            'last_name' => 'Other Organizer Last Name',
            'email' => 'other@test.com',
            'password' => bcrypt('password'),
            'role' => 'organizer',
        ]);

        $otherEvent = Event::create([
            'uuid' => Str::uuid(),
            'title' => 'Other Event',
            'description' => 'Other event description',
            'date' => now()->addDays(7)->format('Y-m-d'),
            'time' => '14:00:00',
            'location' => 'Other Location',
            'capacity' => 30,
            'organizer_id' => $otherOrganizer->id,
        ]);

        $updatedData = [
            'title' => 'Hacked Title',
            'description' => 'Hacked description',
            'date' => now()->addDays(10)->format('Y-m-d'),
            'time' => '15:30',
            'location' => 'Hacked Location',
            'capacity' => 100,
        ];

        $response = $this->actingAs($this->organizer)
            ->put("/eventmanager/edit/{$otherEvent->uuid}", $updatedData);

        // Should return 403 Forbidden or redirect with error
        $this->assertTrue(
            $response->status() === 403 || 
            $response->status() === 302
        );
        
        // Event should remain unchanged
        $this->assertDatabaseHas('events', [
            'id' => $otherEvent->id,
            'title' => 'Other Event',
            'location' => 'Other Location',
            'organizer_id' => $otherOrganizer->id,
        ]);
    }

    public function test_an_organiser_can_delete_their_event_without_bookings()
    {
        $response = $this->actingAs($this->organizer)
            ->delete("/eventmanager/delete/{$this->event->uuid}");

        $response->assertRedirect('/eventmanager');
        $response->assertSessionHas('success', 'Event deleted successfully!');
        
        $this->assertDatabaseMissing('events', [
            'id' => $this->event->id,
        ]);
    }

    public function test_an_organiser_cannot_delete_event_with_existing_bookings()
    {
        // Add a booking to the event
        DB::table('event_attendees')->insert([
            'event_id' => $this->event->id,
            'user_id' => $this->user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($this->organizer)
            ->delete("/eventmanager/delete/{$this->event->uuid}");

        $response->assertRedirect('/eventmanager');
        $response->assertSessionHas('error', 'Cannot delete event with existing bookings. Please contact attendees first.');
        
        // Event should still exist
        $this->assertDatabaseHas('events', [
            'id' => $this->event->id,
            'title' => 'Test Event',
        ]);
    }
}
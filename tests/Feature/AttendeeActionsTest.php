<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Str;

use Tests\TestCase;
use App\Models\Event;
use App\Models\User;
use App\Models\Booking;

class AttendeeActionsTest extends TestCase
{
    use RefreshDatabase;

    protected $organizer;
    protected $event;
    protected $fullEvent;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test organizer
        $this->organizer = User::create([
            'first_name' => 'Test Organizer',
            'last_name' => 'last_name',
            'email' => 'organizer@test.com',
            'password' => bcrypt('password'),
            'role' => 'organizer',
        ]);

        // Create test events
        $this->event = Event::create([
            'uuid' => Str::uuid(),
            'title' => 'Test Event',
            'description' => 'Test event description',
            'date' => now()->addDays(7)->format('Y-m-d'),
            'time' => '14:00:00',
            'location' => 'Test Location',
            'capacity' => 2,
            'organizer_id' => $this->organizer->id,
        ]);

        // Create a full event for capacity testing
        $this->fullEvent = Event::create([
            'uuid' => Str::uuid(),
            'title' => 'Full Event',
            'description' => 'Full event description',
            'date' => now()->addDays(7)->format('Y-m-d'),
            'time' => '15:00:00',
            'location' => 'Test Location 2',
            'capacity' => 1,
            'organizer_id' => $this->organizer->id,
        ]);

        // Fill the full event
        $attendee = User::create([
            'first_name' => 'Other Attendee',
            'last_name' => 'last_name',
            'email' => 'other@test.com',
            'password' => bcrypt('password'),
            'role' => 'Attendee',
        ]);

        DB::table('event_attendees')->insert([
            'event_id' => $this->fullEvent->id,
            'user_id' => $attendee->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_a_user_can_register_with_valid_data()
    {
        $response = $this->post('/register', [
            'first_name' => 'New User First Name',
            'last_name' => 'New User Last Name',
            'email' => 'newuser@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'privacy_policy_accepted' => true,
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@test.com',
            'role' => 'Attendee',
        ]);
    }

    public function test_a_user_can_log_in_and_log_out()
    {
        $user = User::create([
            'first_name' => 'New User First Name',
            'last_name' => 'New User Last Name',
            'email' => 'testuser@test.com',
            'password' => bcrypt('password'),
            'role' => 'Attendee',
        ]);

        // Test login
        $response = $this->post('/login', [
            'email' => 'testuser@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);

        // Test logout
        $response = $this->post('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_a_logged_in_user_can_book_an_event()
    {
        $user = User::create([
            'first_name' => 'New User First Name',
            'last_name' => 'New User Last Name',
            'email' => 'testuser@test.com',
            'password' => bcrypt('password'),
            'role' => 'Attendee',
        ]);

        $response = $this->actingAs($user)
            ->post("/events/{$this->event->uuid}/book");

        $response->assertRedirect("/events/{$this->event->uuid}");
        $response->assertSessionHas('success', 'You have successfully booked this event!');
        
        $this->assertDatabaseHas('event_attendees', [
            'event_id' => $this->event->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_a_logged_in_user_can_cancel_a_booking()
    {
        // Create a user and event
        $user = User::create([
            'first_name' => 'New User First Name',
            'last_name' => 'New User Last Name',
            'email' => 'testuser@test.com',
            'password' => bcrypt('password'),
            'role' => 'Attendee',
        ]);

        $event = $this->event;

        $this->actingAs($user)
            ->post("/events/{$this->event->uuid}/book");
        
        $response = $this->actingAs($user)
            ->delete("/events/{$event->uuid}/cancel");

        // Assert booking is deleted
        $response->assertSessionHas('success', 'Booking cancelled successfully.');
    }

    public function test_a_logged_in_user_can_view_their_bookings()
    {
        $user = User::create([
            'first_name' => 'New User First Name',
            'last_name' => 'New User Last Name',
            'email' => 'testuser@test.com',
            'password' => bcrypt('password'),
            'role' => 'Attendee',
        ]);

        // Book an event
        DB::table('event_attendees')->insert([
            'event_id' => $this->event->id,
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/mybookings');

        $response->assertStatus(200);
        $response->assertSee($this->event->title);
        $response->assertSee($this->event->location);
    }

    public function test_a_user_cannot_book_the_same_event_twice()
    {
        $user = User::create([
            'first_name' => 'New User First Name',
            'last_name' => 'New User Last Name',
            'email' => 'testuser@test.com',
            'password' => bcrypt('password'),
            'role' => 'Attendee',
        ]);

        // First booking
        $this->actingAs($user)
            ->post("/events/{$this->event->uuid}/book");

        // Second booking attempt
        $response = $this->actingAs($user)
            ->post("/events/{$this->event->uuid}/book");

        $response->assertRedirect("/events/{$this->event->uuid}");
        $response->assertSessionHas('error', 'You have already booked this event.');
        
        // Should only have one booking record
        $this->assertEquals(1, DB::table('event_attendees')
            ->where('event_id', $this->event->id)
            ->where('user_id', $user->id)
            ->count());
    }

    public function test_a_user_cannot_book_an_event_at_full_capacity()
    {
        $user = User::create([  
            'first_name' => 'New User First Name',
            'last_name' => 'New User Last Name',
            'email' => 'testuser@test.com',
            'password' => bcrypt('password'),
            'role' => 'Attendee',
        ]);

        $response = $this->actingAs($user)
            ->post("/events/{$this->fullEvent->uuid}/book");

        $response->assertRedirect("/events/{$this->fullEvent->uuid}");
        $response->assertSessionHas('error', 'Sorry, this event is fully booked. No more spots available.');
        
        $this->assertDatabaseMissing('event_attendees', [
            'event_id' => $this->fullEvent->id,
            'user_id' => $user->id,
        ]);
    }
}
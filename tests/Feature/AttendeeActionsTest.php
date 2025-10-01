<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Str;

use Tests\TestCase;
use App\Models\Event;
use App\Models\User;

class AttendeeActionsTest extends TestCase
{
    use RefreshDatabase;

    protected $organizer;
    protected $attendee_1;
    protected $attendee_2;
    protected $event;
    protected $fullEvent;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test organizer
        $this->organizer = User::factory()->create([
            'role' => 'organizer',
        ]);

        // Create test attendee
        $this->attendee_1 = User::factory()->create([
            'role' => 'Attendee',
            'password' => 'password123',
        ]);

        $this->attendee_2 = User::factory()->create([
            'role' => 'Attendee',
        ]);

        // Create test events
        $this->event = Event::factory()->create([
            'organizer_id' => $this->organizer->id,
        ]);

        // Create a full event for capacity testing
        $this->fullEvent = Event::factory()->create([
            'capacity' => 1,
            'organizer_id' => $this->organizer->id,
        ]);

        // Fill the full event with attendee_1
        DB::table('event_attendees')->insert([
            'event_id' => $this->fullEvent->id,
            'user_id' => $this->attendee_1->id,
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
        // Test login
        $response = $this->post('/login', [
            'email' => $this->attendee_1->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($this->attendee_1);

        // Test logout
        $response = $this->post('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_a_logged_in_user_can_book_an_event()
    {
        $response = $this->actingAs($this->attendee_1)
            ->post("/events/{$this->event->uuid}/book");

        $response->assertRedirect("/events/{$this->event->uuid}");
        $response->assertSessionHas('success', 'You have successfully booked this event!');
        
        $this->assertDatabaseHas('event_attendees', [
            'event_id' => $this->event->id,
            'user_id' => $this->attendee_1->id,
        ]);
    }

    public function test_a_logged_in_user_can_cancel_a_booking()
    {
        $this->actingAs($this->attendee_1)
            ->post("/events/{$this->event->uuid}/book");
        
        $response = $this->actingAs($this->attendee_1)
            ->delete("/events/{$this->event->uuid}/cancel");

        // Assert booking is deleted
        $response->assertSessionHas('success', 'Booking cancelled successfully.');
    }

    public function test_a_logged_in_user_can_view_their_bookings()
    {
        $response = $this->actingAs($this->attendee_1)->get('/mybookings');

        $response->assertStatus(200);
        $response->assertSee($this->fullEvent->title);
        $response->assertSee($this->fullEvent->location);
    }

    public function test_a_user_cannot_book_the_same_event_twice()
    {
        // First booking
        $this->actingAs($this->attendee_1)
            ->post("/events/{$this->event->uuid}/book");

        // Second booking attempt
        $response = $this->actingAs($this->attendee_1)
            ->post("/events/{$this->event->uuid}/book");

        $response->assertRedirect("/events/{$this->event->uuid}");
        $response->assertSessionHas('error', 'You have already booked this event.');
        
        // Should only have one booking record
        $this->assertEquals(1, DB::table('event_attendees')
            ->where('event_id', $this->event->id)
            ->where('user_id', $this->attendee_1->id)
            ->count());
    }

    public function test_a_user_cannot_book_an_event_at_full_capacity()
    {

        $response = $this->actingAs($this->attendee_2)
            ->post("/events/{$this->fullEvent->uuid}/book");

        $response->assertRedirect("/events/{$this->fullEvent->uuid}");
        $response->assertSessionHas('error', 'Sorry, this event is fully booked. No more spots available.');
        
        $this->assertDatabaseMissing('event_attendees', [
            'event_id' => $this->fullEvent->id,
            'user_id' => $this->attendee_2->id,
        ]);
    }
}
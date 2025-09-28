<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Register');
        $response->assertSee('Privacy Policy');
        $response->assertSee('Terms of Service');
    }

    public function test_new_users_can_register_with_valid_data_and_agreements()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'privacy_policy_accepted' => true,
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'Test User',
            'role' => 'Attendee',
        ]);
        $this->assertAuthenticated();
    }

    public function test_registration_fails_without_privacy_policy_agreement()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            // privacy agreement missing
        ]);

        $response->assertStatus(302); // Redirect back with errors
        $response->assertSessionHasErrors(['privacy_policy_accepted']);
        $this->assertDatabaseMissing('users', [
            'email' => 'test@example.com',
        ]);
        $this->assertGuest();
    }

    public function test_registration_fails_without_all_required_fields()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'privacy_policy_accepted' => true,
        ]);

        $response->assertStatus(302); // Redirect back with errors
        $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseMissing('users', [
            'email' => 'test@example.com',
        ]);
        $this->assertGuest();
    }

    public function test_registration_fails_with_invalid_email()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password',
            'password_confirmation' => 'password',
            'privacy_policy_accepted' => true,
        ]);

        $response->assertStatus(302); // Redirect back with errors
        $response->assertSessionHasErrors(['email']);
        $this->assertDatabaseMissing('users', [
            'email' => 'invalid-email',
        ]);
        $this->assertGuest();
    }

    public function test_registration_fails_with_duplicate_email()
    {
        // Create existing user
        User::create([
            'name' => 'Existing User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'Attendee',
        ]);

        $response = $this->post('/register', [
            'name' => 'New User',
            'email' => 'test@example.com', // Duplicate email
            'password' => 'password',
            'password_confirmation' => 'password',
            'privacy_policy_accepted' => true,
        ]);

        $response->assertStatus(302); // Redirect back with errors
        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_registration_fails_with_password_mismatch()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'different-password',
            'privacy_policy_accepted' => true,
        ]);

        $response->assertStatus(302); // Redirect back with errors
        $response->assertSessionHasErrors(['password']);
        $this->assertDatabaseMissing('users', [
            'email' => 'test@example.com',
        ]);
        $this->assertGuest();
    }
}
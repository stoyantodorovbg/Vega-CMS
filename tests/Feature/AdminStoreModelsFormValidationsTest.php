<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminStoreModelsFormValidationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_form_validation()
    {
        $this->authenticate(null, 'admins');

        $this->post(route('admin-users.store'), [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => ''
        ])->assertSessionHasErrors([
            'name' => 'The name field is required.',
            'email' => 'The email field is required.',
            'password' => 'The password field is required.'
        ]);

        $this->post(route('admin-users.store'), [
            'name' => 'ttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttt',
            'email' => '44',
            'password' => '333333333333',
            'password_confirmation' => '4433333333333'
        ])->assertSessionHasErrors([
            'name' => 'The name may not be greater than 30 characters.',
            'email' => 'The email must be a valid email address.',
            'password' => 'The password confirmation does not match.'
        ]);

        $this->post(route('admin-users.store'), [
            'name' => 'test',
            'email' => 'test@email.com',
            'password' => '11111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111',
            'password_confirmation' => '44444444444'
        ])->assertSessionHasErrors([
            'password' => 'The password may not be greater than 50 characters.'
        ]);

        factory(User::class)->create([
            'email' => 'test@email.com',
        ]);

        $this->post(route('admin-users.store'), [
            'name' => 'test',
            'email' => 'test@email.com',
            'password' => 'testpass',
            'password_confirmation' => 'testpass'
        ])->assertSessionHasErrors([
            'email' => 'The email has already been taken.'
        ]);

        $this->post(route('admin-users.store'), [
            'name' => 'test',
            'email' => 'test1@email.com',
            'password' => 'test',
            'password_confirmation' => 'test'
        ])->assertSessionHasErrors([
            'password' => 'The password must be at least 5 characters.'
        ]);
    }
}

<?php

namespace Tests\Feature;

use Castcast\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfirmEmailTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_confirm_email()
    {
        
        // create user

        //sent that email

        //make a get request to the confirm endpoint

        //assert that user is confirmed
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->get("/register/confirm/?token={$user->confirm_token}")
            ->assertRedirect('/')
            ->assertSessionHas('success', 'Your email has been confirmed.');

        $this->assertTrue($user->fresh()->isConfirmed());
    }

    public function test_a_user_is_redirected_if_token_is_wrong()
    {
        $user = factory(User::class)->create();

        $this->get("/register/confirm/?token=WRONG_TOKEN")
            ->assertRedirect('/')
            ->assertSessionHas('error', 'Confirmation token not recognised.');

        $this->assertTrue($user->fresh()->isConfirmed());
    }
}

<?php

namespace Tests\Feature;

use Mail;
use Tests\TestCase;
use Castcast\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Castcast\Mail\ConfirmYourEmail;

class RegistrationTest extends TestCase
{   
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_has_a_default_username_after_registration()
    {

        $this->withoutExceptionHandling();

        $this->post('/register', [
           'name' => 'hari hari',
           'email' => 'hari@smart.com',
           'password'=> 'secret'  
        ])->assertRedirect();

        $this->assertDatabaseHas('users',[
            'username' => str_slug('hari hari')
        ]);
    }

    public function test_a_user_has_a_token_after_registration()
    {
         Mail::fake();

        //register new user
          $this->post('/register', [
           'name' => 'hari hari',
           'email' => 'hari@smart.com',
           'password'=> 'secret'  
        ])->assertRedirect(); 

        $user = User::find(1);
        $this->assertNotNull($user->confirm_token);
        
        $this->assertFalse($user->isConfirmed());

    }

    public function test_an_email_is_sent_to_newly_registrated_users()
    {

        $this->withoutExceptionHandling();

        Mail::fake();

        //register new user
          $this->post('/register', [
           'name' => 'hari hari',
           'email' => 'hari@smart.com',
           'password'=> 'secret'  
        ])->assertRedirect(); 
        //assert that a particul email was sent

        Mail::assertSent(ConfirmYourEmail::class);

    }
}

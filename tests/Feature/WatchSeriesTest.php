<?php

namespace Tests\Feature;

use Castcast\Lesson;
use Castcast\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WatchSeriesTest extends TestCase
{
   use RefreshDatabase;

   public function test_a_user_can_complete_a_series(){
       
       $this->withoutExceptionHandling();

       $this->flushRedis();
       //user
       $user = factory(User::class)->create();

       $this->actingAs($user);
       // series => 2
       $lesson = factory(Lesson::class)->create();
       $lesson2 = factory(Lesson::class)->create(['series_id' => 1]);
       // post -> complete->lessons

       $response = $this->post("/series/complete-lesson/{$lesson->id}", []);
       
       //assert has
       $response->assertStatus(200);

       $response->assertJson([
           'status' => 'ok'
       ]);

       $this->assertTrue(
           $user->hasCompletedLesson($lesson)
       );

       $this->assertFalse(
           $user->hasCompletedLesson($lesson2)
       );
       // resp

       // status resp
   }
}

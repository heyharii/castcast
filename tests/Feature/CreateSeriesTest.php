<?php

namespace Tests\Feature;

use Config;
use Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Castcast\User;


class CreateSeriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_create_a_series()
    {
        $this->withoutExceptionHandling();

        $this->loginAdmin();

        Storage::fake(config('filesystems.default'));
        
        $this->post('/admin/series', [
            'title' => 'vue js for the best',
            'description' => 'the best vue cast ever',
            'image' => UploadedFile::fake()->image('image-series.png')
        ])->assertRedirect()
        ->assertSessionHas('success', 'Series created successfully.');

        Storage::disk(config('filesystems.default'))->assertExists(
            'public/series/' . str_slug('vue js for the best') . '.png'
        );

        $this->assertDatabaseHas('series',[
            'slug' => str_slug('vue js for the best')
        ]);
    }

    public function test_a_series_must_be_created_with_a_title()
    {
        $this->loginAdmin();

        $this->post('/admin/series', [
            'description' => 'the best vue cast ever',
            'image' => UploadedFile::fake()->image('image-series.png')
        ])
        ->assertSessionHasErrors('title');
    }

    public function test_a_series_must_be_created_with_a_description()
    {
        $this->loginAdmin();
        
        $this->post('/admin/series', [
            'title' => 'the best vue cast ever',
            'image' => UploadedFile::fake()->image('image-series.png')
        ])
        ->assertSessionHasErrors('description');
    }

     public function test_a_series_must_be_created_with_an_image()
    {
        $this->loginAdmin();
        
        $this->post('/admin/series', [
            'title' => 'the best vue cast ever',
            'description' => 'the best vue cast ever',
        ])
        ->assertSessionHasErrors('image');
    }


     public function test_a_series_must_be_created_with_an_image_which_is_actually_an_image()
    {
        $this->loginAdmin();
        
        $this->post('/admin/series', [
            'title' => 'the best vue cast ever',
            'description' => 'the best vue cast ever',
            'image' => 'STRING_INVALID_IMAGE'
        ])
        ->assertSessionHasErrors('image');
    }

    public function test_only_administrator_can_create_series()
    {
        //user 
        $this->actingAs(
            factory(User::class)->create()
        );
        //visit endpoint
        $this->post('admin/series')->assertSessionHas('error','You are not authorized to perform this action');
        //assert we are redirected
    }
}

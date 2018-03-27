<?php

use Faker\Generator as Faker;

$factory->define(Castcast\Lesson::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->sentence(5),
        'description' => $faker->paragraph(3),
        'series_id' => function(){
            return factory(\Castcast\Series::class)->create()->id;
        },
        'episode_number' => 100,
        'video_id' => '260152988'
    ];
});

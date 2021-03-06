<?php

use App\Task;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Task::class, function (Faker $faker) {
    return [
        'body' => $faker->text,
        'completed' => true,
        'project_id' => function () {
            return factory(App\Project::class)->create()->id;
        }
    ];
});

$factory->state(Task::class, 'incomplete', [
   'completed' => false
]);

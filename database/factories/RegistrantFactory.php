<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Registrant;
use Faker\Generator as Faker;

$factory->define(Registrant::class, function () {
    return [
        'name' => $this->name(),
        'email' => $this->unique()->safeEmail(),
        'created_at'=> $this->dateTimeThisMonth($max = 'now', $timezone = null)  
    ];
});

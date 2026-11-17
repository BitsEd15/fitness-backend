<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TrainingTypeSeeder::class,
            MuscleGroupSeeder::class,
            ExerciseSeeder::class,
            ExerciseRelationsSeeder::class,
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exercise;
use App\Models\TrainingType;
use App\Models\MuscleGroup;

class ExerciseRelationsSeeder extends Seeder
{
    public function run(): void
    {
        // Находим упражнения
        $bench = Exercise::where('name', 'Жим штанги лёжа')->first();
        $pullup = Exercise::where('name', 'Подтягивания')->first();
        $burpee = Exercise::where('name', 'Берпи')->first();

        // Находим типы тренировок
        $strength = TrainingType::where('name', 'Силовая')->first();
        $cardio = TrainingType::where('name', 'Кардио')->first();
        $functional = TrainingType::where('name', 'Функциональная')->first();

        // Находим группы мышц
        $chest = MuscleGroup::where('name', 'Общая грудь')->first();
        $triceps = MuscleGroup::where('name', 'Трицепс')->first();
        $lats = MuscleGroup::where('name', 'Широчайшие')->first();
        $biceps = MuscleGroup::where('name', 'Бицепс')->first();

        // Жим лёжа → Силовая + Грудь, Трицепс
        $bench->trainingTypes()->syncWithoutDetaching([$strength->id]);
        $bench->muscleGroups()->syncWithoutDetaching([$chest->id, $triceps->id]);

        // Подтягивания → Силовая + Широчайшие, Бицепс
        $pullup->trainingTypes()->syncWithoutDetaching([$strength->id]);
        $pullup->muscleGroups()->syncWithoutDetaching([$lats->id, $biceps->id]);

        // Берпи → Кардио + Функциональная + Грудь, Широчайшие, Бицепс бедра
        $legs = MuscleGroup::where('name', 'Ноги')->first();
        $burpee->trainingTypes()->syncWithoutDetaching([$cardio->id, $functional->id]);
        $burpee->muscleGroups()->syncWithoutDetaching([$chest->id, $lats->id, $legs->id]);
    }
}
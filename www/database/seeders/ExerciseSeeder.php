<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exercise;

class ExerciseSeeder extends Seeder
{
    public function run(): void
    {
        Exercise::firstOrCreate(
            ['name' => 'Жим штанги лёжа'],
            [
                'short_description' => 'Базовое упражнение для развития грудных мышц.',
                'full_description' => 'Лёжа на скамье, возьмите штангу широким хватом. Опустите штангу до касания груди, затем выжмите вверх.',
            ]
        );

        Exercise::firstOrCreate(
            ['name' => 'Подтягивания'],
            [
                'short_description' => 'Базовое упражнение для широчайших мышц спины.',
                'full_description' => 'Повисните на турнике широким хватом. Подтянитесь, пока подбородок не окажется над перекладиной, затем опуститесь.',
            ]
        );

        Exercise::firstOrCreate(
            ['name' => 'Берпи'],
            [
                'short_description' => 'Интенсивное упражнение на всё тело.',
                'full_description' => 'Из положения стоя присядьте, упор лёжа, отжимание, прыжок ног к рукам, выпрыгивание вверх с хлопком над головой.',
            ]
        );
    }
}
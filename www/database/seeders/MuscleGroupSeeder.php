<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MuscleGroup;

class MuscleGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Сначала создаём главные категории (без parent_id)
        $chest = MuscleGroup::firstOrCreate(['name' => 'Грудь']);
        $back = MuscleGroup::firstOrCreate(['name' => 'Спина']);
        $legs = MuscleGroup::firstOrCreate(['name' => 'Ноги']);
        $arms = MuscleGroup::firstOrCreate(['name' => 'Руки']);
        $shoulders = MuscleGroup::firstOrCreate(['name' => 'Плечи']);
        $core = MuscleGroup::firstOrCreate(['name' => 'Пресс и Кор']);
        $neck = MuscleGroup::firstOrCreate(['name' => 'Шея']);

        // Теперь создаём подкатегории, указывая parent_id
        // Грудь
        MuscleGroup::firstOrCreate(['name' => 'Верх груди', 'parent_id' => $chest->id]);
        MuscleGroup::firstOrCreate(['name' => 'Низ груди', 'parent_id' => $chest->id]);
        MuscleGroup::firstOrCreate(['name' => 'Общая грудь', 'parent_id' => $chest->id]);

        // Спина
        MuscleGroup::firstOrCreate(['name' => 'Широчайшие', 'parent_id' => $back->id]);
        MuscleGroup::firstOrCreate(['name' => 'Трапеция', 'parent_id' => $back->id]);
        MuscleGroup::firstOrCreate(['name' => 'Поясница', 'parent_id' => $back->id]);

        // Ноги
        MuscleGroup::firstOrCreate(['name' => 'Квадрицепс', 'parent_id' => $legs->id]);
        MuscleGroup::firstOrCreate(['name' => 'Бицепс бедра', 'parent_id' => $legs->id]);
        MuscleGroup::firstOrCreate(['name' => 'Ягодицы', 'parent_id' => $legs->id]);
        MuscleGroup::firstOrCreate(['name' => 'Икры', 'parent_id' => $legs->id]);

        // Руки
        MuscleGroup::firstOrCreate(['name' => 'Бицепс', 'parent_id' => $arms->id]);
        MuscleGroup::firstOrCreate(['name' => 'Трицепс', 'parent_id' => $arms->id]);
        MuscleGroup::firstOrCreate(['name' => 'Предплечья', 'parent_id' => $arms->id]);

        // Плечи
        MuscleGroup::firstOrCreate(['name' => 'Передняя дельта', 'parent_id' => $shoulders->id]);
        MuscleGroup::firstOrCreate(['name' => 'Средняя дельта', 'parent_id' => $shoulders->id]);
        MuscleGroup::firstOrCreate(['name' => 'Задняя дельта', 'parent_id' => $shoulders->id]);

        // Пресс
        MuscleGroup::firstOrCreate(['name' => 'Верх пресса', 'parent_id' => $core->id]);
        MuscleGroup::firstOrCreate(['name' => 'Низ пресса', 'parent_id' => $core->id]);
        MuscleGroup::firstOrCreate(['name' => 'Косые мышцы', 'parent_id' => $core->id]);
    }
}
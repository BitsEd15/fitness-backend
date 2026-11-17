<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrainingType;

class TrainingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Силовая', 'Кардио', 'Круговая', 'Функциональная'];

        foreach ($types as $type) {
            TrainingType::firstOrCreate(['name' => $type]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;


class ExerciseController extends Controller
{
    public function index(Request $request)
    {
        $exercises = Exercise::query()
            ->with(['trainingTypes', 'muscleGroups'])
            ->when($request->has('training_type_id'), function ($query) use ($request) {
                $query->whereHas('trainingTypes', function ($q) use ($request) {
                    $q->where('training_types.id', $request->input('training_type_id'));
                });
            })
            ->when($request->has('muscle_group_id'), function ($query) use ($request) {
                $query->whereHas('muscleGroups', function ($q) use ($request) {
                    $q->where('muscle_groups.id', $request->input('muscle_group_id'));
                });
                // where() — фильтрует по полям текущей таблицы
                // whereHas() — фильтрует по полям связанной таблицы (через связь моделей
            })
            ->get();
        return response()->json($exercises);
    }
    public function show($id)
    {
        $exercise = Exercise::with(['trainingTypes', 'muscleGroups'])->findOrFail($id);
        return response()->json($exercise);
    }
}

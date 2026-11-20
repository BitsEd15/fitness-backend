<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Http\Requests\StoreExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;

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
    public function show(Exercise $exercise)
    {
        return response()->json($exercise->load(['trainingTypes', 'muscleGroups']));
    }
    public function store(StoreExerciseRequest $request)
    {

        $data = $request->validated();

        // 2. Извлекаем массивы ID в отдельные переменные.
        // Используем ?? [], чтобы если массива вдруг нет, там был пустой массив, а не null.
        $trainingTypeIds = $data['training_type_ids'] ?? [];
        $muscleGroupIds = $data['muscle_group_ids'] ?? [];
        
        // 3. УДАЛЯЕМ эти ключи из основного массива $data.
        // Почему? Потому что в таблице exercises НЕТ колонок с названиями training_type_ids.
        // Если мы передадим их в метод create(), Laravel попытается их записать и выдаст 
        // ошибку MassAssignmentException, так как их нет в $fillable модели Exercise.
        unset($data['training_type_ids'], $data['muscle_group_ids']);

        // 4. Создаем запись упражнения. 
        $exercise = Exercise::create($data);

        // 5. Привязываем связи. 
        // Метод attach() берет массив ID и создает записи в промежуточной таблице 
        // (например, exercise_muscle_group), связывая id упражнения и id группы мышц.
        $exercise->trainingTypes()->attach($trainingTypeIds);
        $exercise->muscleGroups()->attach($muscleGroupIds);

        // 6. Возвращаем ответ. 
        // Метод load() делает "жадную загрузку" связей для УЖЕ созданного объекта $exercise,
        // чтобы в JSON-ответе сразу приехали и данные упражнения, и массивы связанных типов/групп.
        return response()->json($exercise->load(['trainingTypes', 'muscleGroups']), 201);
    }
    public function update(UpdateExerciseRequest $request, Exercise $exercise)
    {
        $data = $request->validated();

        $trainingTypeIds = $data['training_type_ids'] ?? null;
        $muscleGroupIds = $data['muscle_group_ids'] ?? null;

        unset($data['training_type_ids'], $data['muscle_group_ids']);

        $exercise->update($data);

        //  Обновляем связи с помощью sync().
        // В чем разница между attach() и sync()?
        // attach() просто ДОБАВЛЯЕТ новые связи. Если вызвать его дважды с одним и тем же ID, 
        // могут возникнуть дубликаты (или ошибка базы данных).
        // sync() делает "синхронизацию". Он смотрит на переданный массив и делает так, 
        // чтобы в базе остались ТОЛЬКО эти ID. Старые, которых нет в массиве, он удалит.
        // Это идеально для обновления, когда пользователь мог убрать галочку с какой-то группы мышц.
        if ($trainingTypeIds !== null) {
            $exercise->trainingTypes()->sync($trainingTypeIds);
        }
        
        if ($muscleGroupIds !== null) {
            $exercise->muscleGroups()->sync($muscleGroupIds);
        }

    return response()->json($exercise->load(['trainingTypes', 'muscleGroups']));
    }
    public function destroy(Exercise $exercise)
    {
        $exercise->delete();
        return response()->noContent();
    }
}

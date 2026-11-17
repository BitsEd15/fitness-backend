<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\ServicePriceController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ExerciseController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Публичные маршруты
Route::get('/services',[ServiceController::class, 'index']);
Route::post('/admin/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1');//throttle:5,1 это ограничение частоты: не больше 5 запросов в минуту (первая цифра это количество, вторая это минуты). Для входа это защита от перебора пароля: после пятой попытки Laravel отвечает 429 «Too Many Requests». Счёт ведётся по IP-адресу.

// Только для админа
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/me', fn (Request $request) => $request->user()->only('name', 'email'));
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('services', AdminServiceController::class)->except('show');
    // Route::apiResource(...) создаёт сразу набор стандартных маршрутов для одного 
    // ресурса вместо четырёх отдельных строк. ->except('show') убирает маршрут 
    // «получить одну услугу»: админ-странице хватает общего списка, и лишних маршрутов 
    // не нужно. Посмотреть результат можно командой 
    // php artisan route:list --path=admin/services.
    Route::apiResource('services.prices', ServicePriceController::class)//'services.prices': точка означает вложенность, «prices внутри services».Из каждого слова Laravel делает имя параметра в единственном числе: services → {service}, prices → {price}.
    ->shallow()//называется мелкой вложенностью (shallow nesting): родитель остаётся в адресе только там, где без него не обойтись. убирает родителя у одиночных маршрутов
    ->only(['store', 'update', 'destroy']);//Он оставляет из набора только перечисленные методы: store, update, destroy. Остальные два (index и show) нам не нужны: цены уже приходят вложенными в GET /admin/services, а отдельно читать одну цену никто не будет.
});

//Публичный маршрут для статей
Route::prefix('articles')->group(function(){
    Route::get('/',[ArticleController::class,'index']);
    Route::get('/{id}',[ArticleController::class,'show']);
});


//Публичный маршрут для упражнений
Route::prefix('exercises')->group(function(){
    Route::get('/',[ExerciseController::class,'index']);
    Route::get('/{id}',[ExerciseController::class,'show']);
});

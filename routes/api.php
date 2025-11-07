<?php

use App\Http\Controllers\Api\WoltController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['prefix'=>'wolt'],function(){
    
    Route::post('/authorization',[WoltController::class,'authorization']);

    Route::post('/order',[WoltController::class,'store']);

});

Route::fallback(function (Request $request) {
    // Проверяем, ожидает ли клиент JSON (например, API-запрос)
    if ($request->expectsJson()) {
        return response()->json([
            'error' => 'Страница не найдена',
            'code' => 404,
        ], 404);
    }

    // Для обычных web-запросов — возвращаем шаблон 404
    return response()->view('errors.404', [], 404);
});
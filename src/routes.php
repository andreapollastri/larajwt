<?php


Route::group(['prefix' => 'api', 'middleware' => 'api'], function () {
    Route::post('/auth', [\Andr3a\Larajwt\Http\Controllers\JwtController::class, 'login']);
    Route::get('/auth', [\Andr3a\Larajwt\Http\Controllers\JwtController::class, 'me'])->middleware(['jwt']);
    Route::patch('/auth', [\Andr3a\Larajwt\Http\Controllers\JwtController::class, 'refresh']);
    Route::delete('/auth', [\Andr3a\Larajwt\Http\Controllers\JwtController::class, 'logout'])->middleware(['jwt']);

    if (file_exists(app_path('Http/Controllers/JwtController.php'))) {
        Route::post('/auth', [\App\Http\Controllers\JwtController::class, 'login']);
        Route::get('/auth', [\App\Http\Controllers\JwtController::class, 'me'])->middleware(['jwt']);
        Route::patch('/auth', [\App\Http\Controllers\JwtController::class, 'refresh']);
        Route::delete('/auth', [\App\Http\Controllers\JwtController::class, 'logout'])->middleware(['jwt']);
    }
});

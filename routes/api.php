<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::get('/', function () {
        return response()->json([
            'message' => 'Welcome to the API Bank Jawaban',
        ]);
    });
    Route::get('/unauthenticated', function () {
        return response()->json([
            'message' => 'Unauthenticated.',
        ], 401);
    })->name('unauthenticated');
    Route::post("auth/register", [ApiAuthController::class, 'register'])->name("register");
    Route::post("auth/login", [ApiAuthController::class, 'login'])->name("login");
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

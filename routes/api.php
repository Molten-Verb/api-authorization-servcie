<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\InviteController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/invite')
    ->controller(InviteController::class)
    ->group (function () {
Route::post('/company', 'inviteCompany');
Route::post('/user', 'inviteUser');
Route::post('/activate', 'activateUser');
});

Route::post('/login', [AuthController::class, 'login']);

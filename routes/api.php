<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalaryIncrementController;

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

Route::post('/v1/calculate-increment-rate', [SalaryIncrementController::class, 'calculateIncrementRate'])->name('api.v1.calculate.increment.rate');
<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UnitsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::apiResource('/units', UnitsController::class)
					->only(['index', 'store', 'update', 'destroy', 'show']);

Route::apiResource('/categories', CategoriesController::class)
					->only(['store', 'destroy']);


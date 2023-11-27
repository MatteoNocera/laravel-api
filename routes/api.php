<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Project;
use App\Http\Controllers\Api\ProjectController;

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


/* Route::get('projects', function () {
    return response()->json([
        'status' => 'success',
        'result' => Project::all()
    ]);
}); */

Route::get('/projects', [ProjectController::class, 'index']);

Route::get('projects/{project:slug}', [ProjectController::class, 'show']);

Route::get('/latests', [ProjectController::class, 'latests']);

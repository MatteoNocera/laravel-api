<?php

use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TechnologyController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Api\GitHubController;
use App\Http\Controllers\ProfileController;
use App\Mail\NewMail;
use App\Models\Lead;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('/welcome');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name("admin.")->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/projects/trashed', [ProjectController::class, 'trashed'])->name('trashed');

    Route::get('/restore/{id}', [ProjectController::class, 'restore'])->name('restore');

    Route::delete('/forceDelete/{id}', [ProjectController::class, 'forceDelete'])->name('forceDelete');


    Route::resource('projects', ProjectController::class)->parameters(['projects' => 'project:slug']);

    Route::resource('/types', TypeController::class)->parameters(['types' => 'type:slug']);

    Route::resource('/technologies', TechnologyController::class)->parameters(['technologies' => 'technology:slug']);

    Route::get('fetch-repos', [GitHubController::class, 'fetchRepo'])->name('gitHub.fetch');
});

Route::get('/mailable', function () {
    $lead = Lead::find(1);

    return new NewMail($lead);
});



Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

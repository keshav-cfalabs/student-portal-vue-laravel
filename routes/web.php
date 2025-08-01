<?php

use App\Http\Controllers\students\StudentController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';


Route::middleware('auth')->group(function () {
    Route::resource('students', StudentController::class);

});



Route::get('asdd', function(){
$schemaManager = DB::connection()->getDoctrineSchemaManager();
$tables = $schemaManager->listTableNames();
dd($tables);
});
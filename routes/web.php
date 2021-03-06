<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ContactsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get("/files", [FileController::class, "index"])->middleware('auth')->name('files');
Route::get("/files/create", [FileController::class, "create"])->middleware('auth');
Route::post("/files", [FileController::class, "store"])->middleware('auth');

Route::get("/contacts", [ContactsController::class, "index"])->middleware('auth')->name('contacts');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

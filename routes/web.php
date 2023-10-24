<?php

use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//midleware test route
Route::get('/put', function () {
    session()->put('user_id', 1);
    //print_r(session()->all());die;
    return redirect('/in');
});
Route::get('/in', function () {
    echo "in";
});
Route::get('/out', function () {
    session()->forget('user_id');
    return redirect('/');
});
Route::get('/pias', [ProfileController::class, 'getInfo'])->middleware('guard');

Route::get('/no-access', function () {
    echo "You can not access this page. Login First.";
    //return redirect('/in');
});

require __DIR__.'/auth.php';

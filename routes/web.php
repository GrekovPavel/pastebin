<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\loginController;

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

Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('/login', [loginController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [loginController::class, 'store'])->middleware('guest');

Route::post('/logout', [loginController::class, 'destroy'])->middleware('auth')->name('logout');


Route::view('/dashboard', 'dashboard')->middleware('auth')->name('dashboard');

Route::get('/', 'PasteController@index')->name('paste');

Route::get('/{hash}', 'PasteController@paste')->name('form.paste');



Route::post('/submit', 'PasteController@submit');


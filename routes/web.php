<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/flush-cache', function () {
    $exitCode = Artisan::call('modelCache:clear');
    return 'Done';
});

Route::get('/flush-cache-permission', function () {
    $exitCode = Artisan::call('cache:forget spatie.permission.cache');
    return 'Done';
});

// Redirect all to the front-end router
Route::get('/{pattern?}', function () {
    return view('welcome');
})->where('pattern', '.*');

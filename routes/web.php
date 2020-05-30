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
    $exitCode = Artisan::call('php artisan cache:forget spatie.permission.cache');
    return 'Done';
});

Route::get('/flush-cache-permission', function () {
    $exitCode = Artisan::call('php artisan cache:forget spatie.permission.cache');
    return 'Done';
});


Route::get('/geolocation/{room}', function ($room) {
    return view('geolocation');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register/{type}', function ($type) {
    if ($type == "person") {
        return view('register_person');
    } else {
        return view('register_empegat');
    }
});

Route::post('register_save/{type}', 'GeoLocationController@insert');

Route::get('/geolocation_result/{room}/{lat}/{long}', function ($room, $lat, $long) {

    $datalocate = array(
        ["code" => "000000", "roomname" => "สำนักงานกลาง อาคาร ท.100 ห้อง 396"],
        ["code" => "002", "roomname" => "383 ท.100"]
    );

    $user_ip = Request::ip();
    echo "IP: " . $user_ip;
    echo "<br>";
    echo "Room: " . $datalocate[0]["roomname"];
    echo "<br>";
    echo "Date: " . date('Y-m-d');
    echo "<br>";
    echo "Time: " . date('H:i:s');
    echo "<br><br>";
    echo "Location: " . $lat . "," . $long;
});

// Redirect all to the front-end router
Route::get('/{pattern?}', function () {
    return view('welcome');
})->where('pattern', '.*');

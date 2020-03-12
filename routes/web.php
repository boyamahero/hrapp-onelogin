<?php

use Illuminate\Support\Facades\Redis;
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

Route::get('/test', function() {
    $data = \App\WLSavedata::where('PERNR','590006')->first();
    $data->ZZOFTEL = '64452';
    $data->save();

//      \App\WLSavedata::updateOrInsert(
//        ['PERNR' => '590006'],
//        ['ZZOFTEL' => '64452'
//    ]);    
//    $data = \App\WLSavedata::where('PERNR','590006')->first();

    // dd($data);
    // $data = \App\Person::where('PS_Code','00590006')->get();
    // $client = new Predis\Client();
    // $client->set('foo','bar');
    // dd($client);
    // $data = $client->get('foo');

    // $redis = Redis::connection();
    return view('home',compact('data'));
});

Route::get('/flush-cache', function() {
    $exitCode = Artisan::call('modelCache:clear');
    return 'Done';
});

// Redirect all to the front-end router
Route::get('/{pattern?}', function() {
    return view('welcome');
})->where('pattern', '.*');

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


Route::get('/geolocation/{room}', function($room) {
    

$datalocate = array
(
	["code"=> "001","roomname"=> "สำนักงานกลาง อาคาร ท.100 ห้อง 396"],
	["code"=> "002","roomname"=> "383 ท.100"]
);
$homepage = file_get_contents('https://career.egat.co.th/geo.html');
$user_ip = Request::ip();


echo "IP: ".$user_ip; 
echo "<br>";
// echo "Room: ".$_GET["room"]; 
echo "Room: ".$datalocate[0]["roomname"]; 
echo "<br>";
echo "Date: ".date('Y-m-d');
echo "<br>";
echo "Time: ".date('H:i:s');
echo "<br><br>";
echo "Location: ".$homepage;

});

// Redirect all to the front-end router
Route::get('/{pattern?}', function() {
    return view('welcome');
})->where('pattern', '.*');

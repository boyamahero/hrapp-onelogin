<?php

use App\User;
use App\Employee;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('jwt.verify')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function () {
  return response()->json([
    'data' => 'Test api response'
  ]);
});

Route::get('/employees/{id}', function($id){
  return User::where('username',$id)->with('employee')->get();
});

Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

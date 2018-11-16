<?php

use App\User;
use App\Category;
use App\Employee;
use App\Competency;
use App\Infographic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

Route::middleware(['jwt.verify'])->group(function () {

  Route::get('/user', 'EmployeesController@user');

  Route::get('/search/{keyword}', 'EmployeesController@search');

  Route::get('/manpower/{level?}/{abb?}', 'EmployeesController@manpower');


});

Route::get('/competencies/{id}', function ($id) {
  return response()->json([
    'data' => User::where('username',$id)->with('competencies')->get()
  ]);
});

Route::get('/images/{id}/{hash}', 'EmployeesController@images');

Route::get('/employee/{id}', 'EmployeesController@show');

Route::get('/info-categories', function () {
  return Category::all();
});

Route::get('/info-categories/{id}', function ($id) {
  return Infographic::where('category_id',$id)->get();
});

Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

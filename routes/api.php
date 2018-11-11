<?php

use App\User;
use App\Category;
use App\Employee;
use App\Infographic;
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
    return $request->user()->employee()->first();
});

Route::get('/test', function () {
  return response()->json([
    'data' => 'Test api response'
  ]);
});

Route::get('/employee/{id}', function ($id) {
  return Employee::where('id',$id)->first();
});

Route::get('/info-categories', function () {
  return Category::all();
});

Route::get('/info-categories/{id}', function ($id) {
  return Infographic::where('category_id',$id)->get();
});

Route::get('/search/{keyword}', function ($keyword) {
  return Employee::whereLike(['name','id','deputy_abb','assistant_abb','division_abb','department_abb','section_abb'], $keyword)
    ->where('status','!=','0')
    ->orderBy('employee_subgroup','desc')
    ->orderBy('senior')
    ->paginate(5);
});

Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

<?php

use App\User;
use App\Category;
use App\Employee;
use App\Competency;
use App\Infographic;
use App\Kpi;
use App\HistoryWork;
use App\Vision;
use App\Portfolio;
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

Route::get('/portfolioInfo/{id}', function ($id) {
  $historyWorks = HistoryWork::select('works_date', 'works_dsc')
      ->where('emp_code',$id)->take(5)
      ->orderBy('works_no','desc')
      ->get();
  $vision = Vision::select('vision', 'cause', 'objective', 'empn_approver')
      ->where('Empn',$id)->take(1)
      ->where('id_approval','=','0')
      ->orderBy('id','desc')
      ->get();
  $portfolio = Portfolio::select('achievement', 'finish_year', 'result')
      ->where('empn',$id)
      ->where('id_approval','=','0')->take(5)
      ->orderBy('finish_year','desc')
      ->orderBy('is_favorite','desc')
      ->get();    
  $yearnow = date("Y") + 543;
  $year1 =  $yearnow - 1;
  $year2 =  $yearnow - 2; 
  $avgKPIScore = DB::connection('HRDatabase')->table('TBP_KPI')
      ->select(DB::raw('AVG(SCORE100) as avg_kpi_score, TEST_YR'))
      ->where('EMPN06',$id)
      ->whereIn('TEST_YR',[$year2,$year1,$yearnow])
      ->groupBy('TEST_YR')
      ->get();
  $avgAllKPIScore = DB::connection('HRDatabase')->table('TBP_KPI')
      ->select(DB::raw('AVG(SCORE100) as avg_all_kpi_score'))
      ->where('EMPN06',$id)
      ->whereIn('TEST_YR',[$year2,$year1,$yearnow])
      ->get();
  return response()->json([
    'data' => [$historyWorks, $vision, $portfolio,$avgKPIScore,$avgAllKPIScore]
  ]);
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

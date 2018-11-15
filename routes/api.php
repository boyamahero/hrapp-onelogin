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

Route::middleware('jwt.verify')->get('/user', function (Request $request) {
    return $request->user()->employee()->first();
});

Route::get('/test', function () {
  return response()->json([
    'data' => 'Test api response'
  ]);
});

Route::get('/competencies/{id}', function ($id) {
  return response()->json([
    'data' => User::where('username',$id)->with('competencies')->get()
  ]);
});

Route::get('/employee/{id}', function ($id) {
  return User::where('username',$id)->with('employee')->get();
});

Route::get('/info-categories', function () {
  return Category::all();
});

Route::get('/info-categories/{id}', function ($id) {
  return Infographic::where('category_id',$id)->get();
});

Route::middleware('jwt.verify')->get('/search/{keyword}', function ($keyword) {
  return Employee::select('id','name','position_abb','org_path','building','room','phone','deputy_abb','assistant_abb','division_abb','department_abb','section_abb','status','employee_subgroup','senior')->whereLike(['name','id','deputy_abb','assistant_abb','division_abb','department_abb','section_abb'], $keyword)
    ->where('status','!=','0')
    ->orderBy('employee_subgroup','desc')
    ->orderBy('senior')
    ->paginate(10);
});

Route::middleware('jwt.verify')->get('/manpower/{level?}/{abb?}', function ($level = null, $abb = null) {

  switch ($level) {
    case "1":
      $orgs = DB::connection('HRDatabase')->table('Employees')
                ->select(DB::raw('count(*) as employee_count, assistant_abb'))
                ->where('status','!=','0')->whereIn('employee_group',[1,2,5])
                ->where('deputy_abb',$abb)
                ->groupBy('assistant_abb')
                ->get();
      break;
    case "2":
      $orgs = DB::connection('HRDatabase')->table('Employees')
                ->select(DB::raw('count(*) as employee_count, division_abb'))
                ->where('status','!=','0')->whereIn('employee_group',[1,2,5])
                ->where('assistant_abb',$abb)
                ->groupBy('division_abb')
                ->get();
      break;
    case "3":
      $orgs = DB::connection('HRDatabase')->table('Employees')
                ->select(DB::raw('count(*) as employee_count, department_abb'))
                ->where('status','!=','0')->whereIn('employee_group',[1,2,5])
                ->where('division_abb',$abb)
                ->groupBy('department_abb')
                ->get();
        break;
    case "4":
      $orgs = DB::connection('HRDatabase')->table('Employees')
              ->select(DB::raw('count(*) as employee_count, section_abb'))
              ->where('status','!=','0')->whereIn('employee_group',[1,2,5])
              ->where('department_abb',$abb)
              ->groupBy('section_abb')
              ->get();
        break;
    default:
        $orgs = DB::connection('HRDatabase')->table('Employees')
                ->select(DB::raw('count(*) as employee_count, deputy_abb'))
                ->where('status','!=','0')->whereIn('employee_group',[1,2,5])
                ->groupBy('deputy_abb')
                ->get();
      }

  return response()->json([
      'data' => $orgs
  ]);
});

Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

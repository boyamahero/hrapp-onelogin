<?php
use App\Education;
use App\Kpi;
use App\Bkpi;
use App\User;
use App\Vision;
use App\Category;
use App\Employee;
use App\Portfolio;
use App\Competency;
use App\HistoryWork;
use App\Infographic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\Employee as EmployeeResource;

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

  Route::get('/employees/{keyword}', function ($keyword) {
    return new EmployeeCollection(Employee::whereLike(['name','id','deputy_abb','assistant_abb','division_abb','department_abb','section_abb'], $keyword)
    ->where('status','!=','0')
    ->whereIn('employee_group',[1,2,5,9])
    ->orderBy('org_egat_id')
    ->orderBy('employee_subgroup','desc')
    ->orderBy('senior')
    ->paginate(50));
  });

  Route::get('/manpower/{level?}/{abb?}', 'EmployeesController@manpower');
  
  Route::get('/portfolioInfo', 'PortfoliosController@show');

  Route::get('/employee', 'EmployeesController@show');
  
  Route::get('/medical-expenses/{year?}', 'MedicalExpensesController@show');

  
  Route::get('/permission', function(){
    auth()->user()->assignRole('admin');
  });

});


Route::get('/retire-next/{year?}/{abb?}', 'EmployeesController@retire');

Route::get('/employees/{id}', function ($id) {
  return new EmployeeResource(Employee::find($id));
});

Route::get('/images/{id}/{hash}', 'EmployeesController@images');

// Route::get('/employee/{id}', 'EmployeesController@show');

Route::get('/info-categories', function () {
  return Category::all();
});

Route::get('/info-categories/{id}', function ($id) {
  return Infographic::where('category_id',$id)->get();
});

Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

<?php

use App\Kpi;
use App\Bkpi;
use App\User;
use App\Vision;
use App\Category;
use App\Employee;
use App\Education;
use App\Portfolio;
use Carbon\Carbon;
use App\Competency;
use App\HistoryWork;
use App\Infographic;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

  Route::get('/employees/{keyword}', 'EmployeesController@search')->where('keyword', '(.*)');;

  Route::get('/manpower/{level?}/{abb?}', 'EmployeesController@manpower');

  Route::get('/portfolioInfo', 'PortfoliosController@show');

  Route::get('/employee', 'EmployeesController@show');

  Route::get('/salary', 'EmployeesController@salary');

  Route::get('/medical-expenses/{year?}', 'MedicalFeeController@show');

  Route::get('/medical-fees/{year?}', 'MedicalFeeController@show');

  //worklocation 

  Route::get('/getwltype', 'WorklocationController@getwltype');

  Route::get('/gettempwl', 'WorklocationController@gettempwl');

  Route::get('/getwllist/{type}', 'WorklocationController@getwllist');

  Route::get('/getwladdress/{wlcode}', 'WorklocationController@getwladdress');

  Route::post('/saveWlupdate', 'WorklocationController@saveWlupdate');
  Route::post('/saveWlupdateByBP', 'WorklocationController@saveWlupdateByBP');

  Route::get('/images/{id}/{width?}/{height?}', 'EmployeesController@images');

  Route::middleware('log_access_mobile_phone:api')->get('/mobile-phone/{employee_code}', 'MobilePhoneLogController@show');

  
  //hrapi
});

Route::middleware(['auth.role:hrreport'])->group(function () {
  Route::get('/persons', 'HRAPIController@persons');
});

// for emergency contact person
Route::get('/requiredEmergencyContactPerson/{employeeCode}', 'TempLocationController@exist');


Route::get('/retire-next/{year?}/{abb?}', 'EmployeesController@retire');

// Route::get('/employee/{id}', 'EmployeesController@show');

Route::get('/info-categories', function () {
  return Category::all();
});

Route::get('/info-categories/{id}', function ($id) {
  return Infographic::where('category_id', $id)->get();
});

Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');



Route::get('/wfh/{dateFrom?}', function ($dateFrom = null) {

  if (!$dateFrom) {
    $dateFrom = Carbon::now()->format('Ymd');
  }
  $client = new Client();
  $response = $client->get("https://edms.egat.co.th/Public/API/EDMSAPI.php?action=GetWHMonthlyAllDept&sdate=" . $dateFrom . "&edate=" . $dateFrom . "&
        type=xml");
  $body = $response->getBody()->getContents();

  echo preg_replace('//', '', $body);
});


Route::get('/hrapi', function () {

  $client = new \GuzzleHttp\Client();
  $response = $client->get(
    'https://hrapi.egat.co.th/api/v1/persons',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '. env('HR_API_TOKEN'),
        ],
        'query' => [
            // 'filter[MainOrganizationName]'=> 'อจส.',
            'filter[PersonCode]'=> '00592825',
            'include'=> 'positions.organization',
            'paginate'=> '50',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
});

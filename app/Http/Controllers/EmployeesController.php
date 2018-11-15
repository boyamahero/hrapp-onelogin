<?php

namespace App\Http\Controllers;

use App\User;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeesController extends Controller
{
    public function user(Request $request)
    {
        return $request->user()->employee()->first();
    }

    public function show($id)
    {
        return User::where('username',$id)->with('employee')->get();
    }

    public function search($keyword)
    {
        return Employee::select('id','name','position_abb','org_path','building','room','phone','deputy_abb','assistant_abb','division_abb','department_abb','section_abb','status','employee_subgroup','senior')->whereLike(['name','id','deputy_abb','assistant_abb','division_abb','department_abb','section_abb'], $keyword)
                ->where('status','!=','0')
                ->orderBy('employee_subgroup','desc')
                ->orderBy('senior')
                ->paginate(10);
    }

    public function manpower($level = null, $abb = null)
    {
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
    }
}

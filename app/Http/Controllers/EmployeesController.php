<?php

namespace App\Http\Controllers;

use App\User;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\EmployeeCollection;

class EmployeesController extends Controller
{
    public function user(Request $request)
    {
        return $request->user()->employee()->first();
    }

    public function images($id,$hash)
    {
        if ($hash !== base64_encode( substr(sprintf("%06d", $id),0,3) ).env('APP_SECRET','HrApP').base64_encode( substr(sprintf("%06d", $id),3,3) ) )
            return null;

        $emp = Employee::where('id',$id)
        ->where('status','!=','0')
        ->first();
        header('Content-type: image/jpeg');
        echo file_get_contents('http://10.20.56.21/IMAGE/WINFOMA/PERSON/DATA/DATA'.substr($emp->docuname,1,4).'/'.$emp->docuname.'.jpg');
    }

    public function show()
    {

        $user = Employee::where('id',auth()->user()->username)->first();
        return response()->json([
            'data' => $user
        ]);
    }

    public function search($keyword)
    {
        $levelMin = request()->query('levelMin');
        $levelMax = request()->query('levelMax');
        $onlyBoss = request()->query('onlyBoss');

        $query = Employee::whereLike(['name','id','deputy_abb','assistant_abb','division_abb','department_abb','section_abb'], $keyword)
                        ->where('status','!=','0')
                        ->whereIn('employee_group',[1,2,5,9]);
                             
        if ($levelMin || $levelMax) {
            $query->whereBetween('employee_subgroup',  [$levelMin, $levelMax]);
        }
        if ($onlyBoss) {
            $query->where('priority', '!='  ,"");
        }      
        
        $query = $query->orderBy('org_egat_id')
                ->orderBy('employee_type_priority')
                ->orderBy('senior');

        return new EmployeeCollection($query->paginate(50));
    }

    public function manpower($level = null, $abb = null)
    {
        switch ($level) {
            case "1":
              $orgs = DB::connection('HRDatabase')->table('Employees')
                        ->select(DB::raw('count(*) as employee_count, assistant_abb'))
                        ->where('status','!=','0')->whereIn('employee_group',[1,2,5,9])
                        ->where('deputy_abb',$abb)
                        ->groupBy('assistant_abb')
                        ->get();
              break;
            case "2":
              $orgs = DB::connection('HRDatabase')->table('Employees')
                        ->select(DB::raw('count(*) as employee_count, division_abb'))
                        ->where('status','!=','0')->whereIn('employee_group',[1,2,5,9])
                        ->where('assistant_abb',$abb)
                        ->groupBy('division_abb')
                        ->get();
              break;
            case "3":
              $orgs = DB::connection('HRDatabase')->table('Employees')
                        ->select(DB::raw('count(*) as employee_count, department_abb'))
                        ->where('status','!=','0')->whereIn('employee_group',[1,2,5,9])
                        ->where('division_abb',$abb)
                        ->groupBy('department_abb')
                        ->get();
                break;
            case "4":
              $orgs = DB::connection('HRDatabase')->table('Employees')
                      ->select(DB::raw('count(*) as employee_count, section_abb'))
                      ->where('status','!=','0')->whereIn('employee_group',[1,2,5,9])
                      ->where('department_abb',$abb)
                      ->groupBy('section_abb')
                      ->get();
                break;
            default:
                $orgs = DB::connection('HRDatabase')->table('Employees')
                        ->select(DB::raw('count(*) as employee_count, deputy_abb'))
                        ->where('status','!=','0')->whereIn('employee_group',[1,2,5,9])
                        ->groupBy('deputy_abb')
                        ->get();
              }
        
        return response()->json([
              'data' => $orgs
          ]);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  integer  $year is year of thai date
     * @return json object
     */
    public function retire($numberOfYear = 1, $abb = null)
    {        
        $years = [];
        $year = date("m") >= 10 ? date("Y")+544 : date("Y")+543;
        
        for ($i = 0;$i < $numberOfYear;$i++) {
            array_push($years,$year+$i);
        }
        
        $currentCount = Employee::where('status','!=','0')->whereIn('employee_group',[1,2,5,9])->count();
        $retireYears = Employee::query();

        foreach($years as $year){
            $retireYears->orWhere('retire_thai_date', 'LIKE', '%'.$year.'%')->where('status','!=','0')->whereIn('employee_group',[1,2,5,9]);
        };
        $retireYears = $retireYears->get();
        $retireSum = $retireYears->count('id');

        $retireYears = $retireYears->groupBy(function ($item, $key) {
                return substr($item['retire_thai_date'], -4);
            });
        
            
        $retireYears = $retireYears->map(function($year){
            $retireCount = $year->count('id');
            return [
                'count' => $retireCount,
                'deputy_abb' => $year->groupBy('deputy_abb')->map(function($deputy) {
                    return $deputy->count('id');
                })
            ];
        });

        return response()->json([
            'current_count' => $currentCount,
            'retire_total' => $retireSum,
            'retire_years' => $retireYears,
        ]);
    }
}

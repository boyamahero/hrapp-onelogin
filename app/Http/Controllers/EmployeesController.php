<?php

namespace App\Http\Controllers;

use App\User;
use Throwable;
use App\Document;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use App\Http\Resources\EmployeeCollection;

class EmployeesController extends Controller
{
    public function salary(Request $request)
    {
        return $request->user()->salaries()->paginate(5);
    }

    public function user(Request $request)
    {
        $roles = $request->user()->roles;
        $permissions = $request->user()->getAllPermissions();
        return $request->user()->employee()->with('templocation')->first()->setAttribute('roles', $roles)->setAttribute('permissions', $permissions);
    }

    public function images($id, $width=75, $height=90)
    {
        
        try {
            $document = Document::where('employee_code', $id)->where('document_subtype', '1')->first();
            $image_path = 'http://hrerp.egat.co.th/images/' . $document->document_subtype . '/' . $document->document_name . '.' . $document->document_extension;
            $img = Image::make($image_path)->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            return $img->encode('jpg');
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'ไม่พบรูปผู้ปฏิบัติงาน'
            ], 400);
        }
    }

    // public function images($id, $hash)
    // {
    //     $texts = explode('-', $hash);

    //     if ($texts[1]  !== base64_encode(substr(sprintf("%06d", $id), 0, 3)) . env('APP_SECRET', 'HrApP') . base64_encode(substr(sprintf("%06d", $id), 3, 3)))
    //         return null;

    //     try {
    //         $document = Document::where('employee_code', $id)->where('document_subtype', '1')->first();
    //         $image_path = 'http://hrerp.egat.co.th/images/' . $document->document_subtype . '/' . $document->document_name . '.' . $document->document_extension;
    //         $img = Image::make($image_path)->text('F:' . Crypt::decryptString($texts[0]), 120, 200, function ($font) {
    //             $font->color(array(255, 255, 255, 0.3));
    //         });
    //         return $img->response('jpg');
    //     } catch (Throwable $e) {
    //         return response()->json([
    //             'message' => 'ไม่พบรูปผู้ปฏิบัติงาน'
    //         ], 400);
    //     }
    // }

    public function show()
    {

        $user = Employee::where('id', auth()->user()->username)->first();
        return response()->json([
            'data' => $user
        ]);
    }

    public function search($keyword)
    {
        // return auth()->user()->employee;
        $levelMin = request()->query('levelMin');
        $levelMax = request()->query('levelMax');
        $onlyBoss = request()->query('onlyBoss');
        $orderBySenior = request()->query('orderBySenior');

        if ($keyword == 'กฟผ.') {
            $query = Employee::where('status', '!=', '0')
                ->whereIn('employee_group', [1, 2, 5, 9]);
        } else {
            $query = Employee::whereLike([
                'name', 'name_english', 'email', 'employee_code',
                'deputy_abb', 'assistant_abb', 'division_abb', 'department_abb', 'section_abb', 'position_combine_abb',
                'deputy_full', 'assistant_full', 'division_full', 'department_full', 'section_full'
            ], $keyword)
                ->where('status', '!=', '0')
                ->whereIn('employee_group', [1, 2, 5, 9]);
        }

        if ($levelMin || $levelMax) {
            $query->where(function ($query) use ($levelMin, $levelMax) {
                $query->whereBetween('employee_subgroup',  [$levelMin, $levelMax]);
                // if ($levelMax == 14 ) {
                //     $query->whereBetween('employee_subgroup',  [$levelMin, $levelMax])
                //         ->orWhere('employee_group', '=', '9');
                // } else {
                //     $query->whereBetween('employee_subgroup',  [$levelMin, $levelMax]);
                // }
            });
        }
        if ($onlyBoss) {
            // $query->whereIsBoss(['priority', 'employee_group']);
            $query->where(function ($query) {
                $query->whereNotIn('priority',  ['', '04', '05', '06'])
                    ->orWhere('employee_group', '9');
            });
        }
        $query = $query->with(['workFromHome','workFromAnyWhere', 'templocation', 'person.workLocations']);

        if ($orderBySenior) {
            $employees = $query->orderBy('employee_type_priority')
                ->orderBy('employee_subgroup', 'desc')
                ->orderBy('senior')
                ->paginate(50);
        } else {
            $employees = $query->orderBy('org_egat_id')
                ->orderBy('employee_type_priority')
                ->orderBy('is_boss', 'desc')
                ->orderBy('employee_subgroup', 'desc')
                ->orderBy('senior')
                ->paginate(50);
        }

        $employees->appends(request()->query());

        return new EmployeeCollection($employees);
    }

    public function manpower($level = null, $abb = null)
    {
        switch ($level) {
            case "1":
                $orgs = DB::connection('HRDatabase')->table('load_hhr00005')
                    ->select(DB::raw('count(*) as employee_count, assistant_abb'))
                    ->where('data_status', '!=', '0')->whereIn('employee_group', [1, 2, 5])
                    ->where('deputy_abb', $abb)
                    ->where('organization_type', 'O')
                    ->where('percentage', 100)
                    ->groupBy('assistant_abb')
                    ->get();
                break;
            case "2":
                $orgs = DB::connection('HRDatabase')->table('load_hhr00005')
                    ->select(DB::raw('count(*) as employee_count, division_abb'))
                    ->where('data_status', '!=', '0')->whereIn('employee_group', [1, 2, 5])
                    ->where('assistant_abb', $abb)
                    ->where('organization_type', 'O')
                    ->where('percentage', 100)
                    ->groupBy('division_abb')
                    ->get();
                break;
            case "3":
                $orgs = DB::connection('HRDatabase')->table('load_hhr00005')
                    ->select(DB::raw('count(*) as employee_count, department_abb'))
                    ->where('data_status', '!=', '0')->whereIn('employee_group', [1, 2, 5])
                    ->where('division_abb', $abb)
                    ->where('organization_type', 'O')
                    ->where('percentage', 100)
                    ->groupBy('department_abb')
                    ->get();
                break;
            case "4":
                $orgs = DB::connection('HRDatabase')->table('load_hhr00005')
                    ->select(DB::raw('count(*) as employee_count, section_abb'))
                    ->where('data_status', '!=', '0')->whereIn('employee_group', [1, 2, 5])
                    ->where('department_abb', $abb)
                    ->where('organization_type', 'O')
                    ->where('percentage', 100)
                    ->groupBy('section_abb')
                    ->get();
                break;
            default:
                $orgs = DB::connection('HRDatabase')->table('load_hhr00005')
                    ->select(DB::raw('count(*) as employee_count, deputy_abb'))
                    ->where('data_status', '!=', '0')->whereIn('employee_group', [1, 2, 5])
                    ->where('organization_type', 'O')
                    ->where('percentage', 100)
                    ->groupBy('deputy_abb')
                    ->get();
        }
        $data_date = DB::connection('HRDatabase')->table('transfer_tables')
            ->where('table_name', 'hhr00005')
            ->first();

        $dt = Carbon::parse($data_date->updated_at);
        $dt->subDay(1);

        return response()->json([
            'data' => $orgs,
            'data_type' => 'พนักงาน และพนักงานสัญญาจ้างพิเศษ',
            'data_date' => $this->formatDateThat($dt),
            'contact_us' => 'คุณธนากร จะโต หบค-ห. กทห-ห. อจส. โทร. 64452'
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
        $year = date("m") >= 10 ? date("Y") + 544 : date("Y") + 543;

        for ($i = 0; $i < $numberOfYear; $i++) {
            array_push($years, $year + $i);
        }

        $currentCount = DB::connection('HRDatabase')->table('load_hhr00005')
            ->where('data_status', '!=', '0')
            ->where('organization_type', 'O')
            ->where('percentage', 100)
            ->whereIn('employee_group', [1, 2, 5])->count();
        $retireYears = Employee::query();

        foreach ($years as $year) {
            $retireYears->orWhere('retire_thai_date', 'LIKE', '%' . $year . '%')->where('status', '!=', '0')->whereIn('employee_group', [1, 2, 5, 9]);
        };
        $retireYears = $retireYears->get();
        $retireSum = $retireYears->count('id');

        $retireYears = $retireYears->groupBy(function ($item, $key) {
            return substr($item['retire_thai_date'], -4);
        });


        $retireYears = $retireYears->map(function ($year) {
            $retireCount = $year->count('id');
            return [
                'count' => $retireCount,
                'deputy_abb' => $year->groupBy('deputy_abb')->map(function ($deputy) {
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

    function formatDateThat($date)
    {
        $strYear = date("Y", strtotime($date)) + 543;
        $strMonth = date("n", strtotime($date));
        $strDay = date("j", strtotime($date));
        $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
}

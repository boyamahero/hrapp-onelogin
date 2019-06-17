<?php

namespace App\Http\Controllers;

use App\Education;
use App\Bkpi;
use App\Competency;
use App\Vision;
use App\Portfolio;
use App\HistoryWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortfoliosController extends Controller
{
    public function show()
    {
        $id = auth()->user()->username;
        $yearnow = date("Y") + 543;

        //------competency list-----
        $cLists = array('C1','C2','C3','C4','C5','C6');
	    $coreLists = array('การทำงานเป็นทีม', 'การวางแผน แก้ไขปัญหาและตัดสินใจเชิงรุก', 'คุณธรรมและธรรมาภิบาล', 'ความเชี่ยวชาญและความเป็นมืออาชีพ', 'ความคิดสร้างสรรค์และนวัตกรรม', 'การสื่อสารที่ดี');
         //------managerial competency list-----
        $mLists = array('M1','M2','M3','M4','M5','M6');
	    $managerialLists = array('ภาวะผู้นำ','วิสัยทัศน์และวางแผนเชิงยุทธศาสตร์', 'การสร้างความสัมพันธ์กับผู้เกี่ยวข้อง', 'การบริหารจัดการให้เกิดผลลัพธ์อย่างยั่งยืน','ศักยภาพเพื่อนำการเปลี่ยนแปลง','ความสามารถเชิงธุรกิจ');
        //-----color code-----
        $strength ='#00b050';
        $acceptable ='#ffff00';
        $growth ='#ff5050';

        $Sdesc ='Strength หมายถึง ผู้รับการประเมินแสดงพฤติกรรมได้ สูงกว่า ค่าความคาดหวังในระดับ';
        $Adesc ='A = Acceptable หมายถึง ผู้รับการประเมินแสดงพฤติกรรมได้ ตาม ค่าความคาดหวังในระดับ';
        $Gdesc ='G = Growth Opportunity หมายถึง ผู้รับการประเมินแสดงพฤติกรรมได้ ต่ำกว่า ค่าความคาดหวังในระดับ';

        $competency = DB::connection('HRDatabase')->table('TBP_CoreCompetency')
            ->where('Empn',$id)
            ->whereBetween('TEST_Year',[$yearnow-2,$yearnow])
            ->orderBy('Test_Type','desc')
            ->get();

        $expectCompetency = DB::connection('HRDatabase')->table('TBP_CoreCompetency')
            ->where('Empn',$id)
            ->whereBetween('TEST_Year',[$yearnow-2,$yearnow])
            ->get()
            ->groupBy('TEST_Year')
            ->sortBy('TEST_Year'); 
        $expectCompetency = $expectCompetency->map(function($year ,$key){
            $level = $year->AVG('Zlevel');
            if($level <= '4')
            {
                $expectC = '1';
                $expectM = '-';
            }
            else if($level >= '5' && $level <= '7')
            {	
                $expectC = '2';
                $expectM = '-';
            }
            else if($level == '8')
            {	
                $expectC = '3';
                $expectM = '1';
            }
            else if($level >= '9' && $level <= '10')
            {	
                $expectC = '3';
                $expectM = '2';
            }
            else if($level >= '11' && $level <= '12')
            {	
                $expectC = '4';
                $expectM = '3';
            }
            else if($level == '13')
            {	
                $expectC = '5';
                $expectM = '4';
            }
            else if($level == '14')
            {	
                $expectC = '5';
                $expectM = '5';
            }

            return [
            'level' => $level,
            'expectC' => $expectC,
            'expectM' => $expectM,
            ];
        });

        $highest_degree = DB::connection('HRDatabase')->table('educations')
            ->select('degree_id','degree_name')
            ->where('employee_id',$id)->take(1)
            ->orderBy('degree_id','asc')
            ->first();

        $education = Education::select('degree_name','certificate_name','branch_name','school_name')
            ->where('employee_id',$id)
            ->orderBy('graduated_year','desc')
             ->get();

        $historyWorks = HistoryWork::select(DB::raw('emp_code, MIN(works_date) AS works_date, CAST(works_dsc AS NVARCHAR(255)) AS works_dsc'))
            ->where('emp_code',$id)->take(5)
            ->groupBy(DB::raw('emp_code, CAST(works_dsc AS NVARCHAR(255))'))
            ->orderBy('works_date','desc')
            ->get();            

        $vision = Vision::select('vision', 'cause', 'objective', 'empn_approver')
            ->where('Empn',$id)->take(1)
            ->where('id_approval','=','0')
            ->orderBy('id','desc')
            ->get();
            
        $portfolio = Portfolio::select('achievement', 'finish_year', 'result','category as category_type','value_added')
            ->leftJoin('TBP_pfo_ref_value_added_type', 'TBP_pfo_ref_value_added_type.id', '=', 'TBP_pfo_portfolio.value_added_type')
            ->where('empn',$id)
            ->where('id_approval','=','1')->take(5)
            ->orderBy('finish_year','desc')
            ->orderBy('is_favorite','desc')
            ->get();    

        $avgKPIScore = DB::connection('HRDatabase')->table('TBP_KPI')
            ->where('EMPN06',$id)
            ->whereBetween('TEST_YR',[$yearnow-2,$yearnow])
            ->get()
            ->groupBy('TEST_YR')
            ->sortBy('TEST_YR'); 
            $avgKPIScore = $avgKPIScore->map(function($year ,$key){
                $avgKPI = $year->AVG('SCORE100');   
                return $avgKPI;
            });

        $avgAllKPIScore = DB::connection('HRDatabase')->table('TBP_KPI')
            ->select(DB::raw('AVG(SCORE100) as avg_all_kpi_score'))
            ->where('EMPN06',$id)
            ->whereBetween('TEST_YR',[$yearnow-2,$yearnow])
            ->first();
        
        $softKpi = Bkpi::where('EMPN06',$id)
                ->whereBetween('TEST_YR',[$yearnow-2, $yearnow])
                ->get()
                ->groupBy('TEST_YR')
                ->sortBy('TEST_YR'); 
        $softKpi = $softKpi->map(function($year ,$key){

            if ($key > 2560) {
            $B10 = $year->avg('B10');
            $B20 = $year->avg('B20');
            $B30 = $year->avg('B30');
            $B40 = $year->avg('B40');
            $B50 = $year->avg('B50');   
            } else {
            $B10 = $year->avg('B10')*6/5;
            $B20 = $year->avg('B20')*6/5;
            $B30 = $year->avg('B30')*6/5;
            $B40 = $year->avg('B40')*6/5;
            $B50 = $year->avg('B50')*6/5;      
            } 

            return [
            'B10' => $B10,
            'B20' => $B20,
            'B30' => $B30,
            'B40' => $B40,
            'B50' => $B50,
            'total' => $B10 + $B20 + $B30 + $B40 + $B50
            ];
        });    

        return response()->json([
            'data' => [
            'history_works' => $historyWorks, 
            'visions' => $vision, 
            'portfolios' => $portfolio,
            'kpis' => $avgKPIScore,
            'sum_kpi' => $avgAllKPIScore,
            'soft_kpis' => $softKpi,
            'educations' => $education,
            'highest_degree' => $highest_degree,
            'competencies' => $competency,
            'expectCompetencies' => $expectCompetency
            ]
        ]);
    }
}

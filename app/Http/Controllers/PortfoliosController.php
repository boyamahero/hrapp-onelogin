<?php

namespace App\Http\Controllers;

use App\Bkpi;
use App\Vision;
use App\Portfolio;
use App\HistoryWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortfoliosController extends Controller
{
    public function show($id)
    {
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
            'kpi' => $avgKPIScore,
            'sum_kpi' => $avgAllKPIScore,
            'soft_kpi' => $softKpi]
        ]);
    }
}

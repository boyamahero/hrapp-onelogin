<?php

namespace App\Http\Controllers;

use App\Person;
use App\MedicalFee;
use Illuminate\Http\Request;
use App\Http\Resources\MedicalFeeCollection;

class MedicalFeeController extends Controller
{
    
    /**
     * Show summary medical fee and details per year.
     *
     * @param  int  $id
     * @return array
     */
    public function show($year = null)
    {
 
        $person = Person::where('PS_Code', 'like', '00'.auth()->user()->username)->first();

        $fees = MedicalFee::medical3600Fee()
                        ->where('PMFH_PersonID',$person->PersonID)
                        ->whereBetween('PMFH_MedicalTreatmentBeginDate', [date($year.'-01-01'), date($year.'-12-31')])
                        ->get();

        $fees = new MedicalFeeCollection($fees);                        

        return  response()->json([
                    'year' => (int)(($year)?:date("Y")),
                    'total' => $fees->sum('PMFH_ApprovedAmount'),
                    'data' => $fees
                ]);

    }
}

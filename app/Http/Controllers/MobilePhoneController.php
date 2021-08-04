<?php

namespace App\Http\Controllers;

use App\WLSavedata;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class MobilePhoneController extends Controller
{
    public function show(Request $request)
    {
        $mobile = WLSavedata::select('ZZMOBL')->where('PERNR','like',"%{$request->empIDTarget}%")->first();

        if(!$mobile)
            return response()->json([
                'mobile_number' => null
            ],404);

        return response()->json([
            'mobile_number' => $request->empIDLogin !== $request->empIDTarget ? ('XXXXXX'. substr($mobile->ZZMOBL,-4)) : $mobile->ZZMOBL
        ],200);
    }

    public function store(Request $request)
    {
        if ($request->empIDLogin !== $request->empIDTarget) {
            return response()->json([
                'errors' => 'กรุณาอัพเดตเบอร์มือถือ บนระบบ HRIS'
            ],Response::HTTP_BAD_REQUEST);
        }

        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|regex:/^0{1}\d{9}$/',
            'empIDLogin' => 'required|size:6',
            'empIDTarget' => 'required|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()
            ],Response::HTTP_BAD_REQUEST);
        }

        WLSavedata::updateOrCreate(
            ['PERNR' => $request->empIDTarget],
            [
                'ZZMOBL' => $request->mobile_number, 
                'GENTEXT_AT' => null,
                'updated_by' => $request->empIDLogin
            ]
        );
        
        return response()->json([
            'message' => 'บันทึกข้อมูลเรียบร้อย'
        ],Response::HTTP_OK);
    }
}

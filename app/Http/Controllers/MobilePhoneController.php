<?php

namespace App\Http\Controllers;

use App\Person;
use App\WLSavedata;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class MobilePhoneController extends Controller
{
    public function show(Request $request)
    {
        $mobile = optional(WLSavedata::select('ZZMOBL')->where('PERNR','like',"%{$request->empIDTarget}%")->first())->ZZMOBL;

        if (!$mobile) 
            $mobile = optional(Person::with('workLocations')->where('PS_Code','like',"%{$request->empIDTarget}%")->first()->workLocations->first())->PWAH_MobilePhoneNumber;

        if(!$mobile)
            return response()->json([
                'mobile_number' => null
            ],404);

        return response()->json([
            'mobile_number' => $request->empIDLogin !== $request->empIDTarget ? ('XXXXXX'. substr($mobile,-4)) : $mobile
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

        if (!$worklocation = WLSavedata::where('PERNR','like',"%{$request->empIDTarget}%")->first())
        {
            $worklocation = Person::with('workLocations')->where('PS_Code','like',"%{$request->empIDTarget}%")->first()->workLocations->first();

            WLSavedata::create([
                'PERNR' => $request->empIDTarget,
                'type_code' => substr($worklocation->PWAH_WorkLocationCode,0,1) ?? null,
                'BEGDA' => date("Y.m.d"),
                'ZZCODE' => $worklocation->PWAH_WorkLocationCode ?? null,
                'ZZROMNO' => $worklocation->PWAH_Room ?? null,
                'ZZFLBLD' => $worklocation->PWAH_Building ?? null,
                'ZZOFTEL' => $worklocation->PWAH_PhoneNumber ?? null,
                'ZZOFTELFULL' => $worklocation->PWAH_PhoneNumberFull ?? null,
                'ZZMOBL' => $request->mobile_number, 
                'GENTEXT_AT' => null,
                'updated_by' => $request->empIDLogin
            ]);

            return response()->json([
                'message' => 'บันทึกข้อมูลเรียบร้อย'
            ],Response::HTTP_OK);
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

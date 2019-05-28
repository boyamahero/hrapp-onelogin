<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WLtype;
use App\WLPerdata;
use App\WLSavedata;
use App\Worklocation;

class WorklocationController extends Controller
{
    //worklocation 
    public function getwltype() {
   return WLtype::selectRaw('text as label,code as value')->get();
 }
 
 public function getwllist($type) {
   $type = $type.'%';
   return Worklocation::selectRaw('WL_Name as label,WL_Code as value')
   ->where('WL_Code','like',$type)
   ->get();
 }
 
 public function getwladdress($wlcode) {
   return Worklocation::selectRaw('WL_Province,WL_District,WL_SubDistrict')
   ->where('WL_Code' , $wlcode)
   ->get();
 }
 
 public function saveWlupdate(Request $request)  {
     $WLSAVE = WLSavedata::updateOrInsert(
       ['PERNR' => auth()->user()->username],
       ['type_code' => $request->WL_Type,
       'BEGDA' => date("Y.m.d"),
       'ZZCODE' => $request->WL_Name,
       'ZZROMNO' => $request->PWAH_Room,
       'ZZFLBLD' => $request->PWAH_Building,
       'ZZOFTEL' => $request->PWAH_PhoneNumber,
       'ZZMOBL' => $request->PS_MobilePhoneNumber
   ]);
 
 if($WLSAVE){
   return 'บันทึกการเปลี่ยนแปลงแล้ว ข้อมูลจะมีผลในวันถัดไป';
 }else{
   exit();
 }
 }

}
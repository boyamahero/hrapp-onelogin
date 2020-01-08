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

 public function gettempwl() {
    $tempdata = WLSavedata::where('PERNR',auth()->user()->username)->first();
    if($tempdata){
      $wlname = Worklocation::where('WL_Code',$tempdata->ZZCODE)->pluck('WL_Name')->first();
      return [
        'tempdata' => $tempdata,
        'wlname' => $wlname,
      ];
    } else {
      return [
        'tempdata' => null,
        'wlname' => null,
      ];
    }
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
  $data = WLSavedata::where('PERNR',auth()->user()->username)->first();
  if($data) {
    $data->type_code = $request->WL_Type;
    $data->BEGDA = date("Y.m.d");
    $data->ZZCODE = $request->WL_Name;
    $data->ZZROMNO =  $request->PWAH_Room;
    $data->ZZFLBLD =  $request->PWAH_Building;
    $data->ZZOFTEL =  $request->PWAH_PhoneNumber;
    $data->ZZMOBL =  $request->PWAH_MobilePhoneNumber;
    $data->GENTEXT_AT =  NULL;
    $data->save();
  } else {
    $data = new WLSavedata;
    $data->PERNR = auth()->user()->username;
    $data->type_code = $request->WL_Type;
    $data->BEGDA = date("Y.m.d");
    $data->ZZCODE = $request->WL_Name;
    $data->ZZROMNO =  $request->PWAH_Room;
    $data->ZZFLBLD =  $request->PWAH_Building;
    $data->ZZOFTEL =  $request->PWAH_PhoneNumber;
    $data->ZZMOBL =  $request->PWAH_MobilePhoneNumber;
    $data->GENTEXT_AT =  NULL;
    $data->save();
  }
 
 if($data){
   return ['message' => 'บันทึกการเปลี่ยนแปลงแล้ว'];
 }else{
   exit();
 }
 }

}
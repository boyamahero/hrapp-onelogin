<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WLtype;
use App\WLPerdata;
use App\WLSavedata;
use App\Worklocation;
use Illuminate\Support\Facades\Artisan;

class WorklocationController extends Controller
{
    //worklocation 
    public function getwltype() {
   return WLtype::selectRaw('text as label,code as value')->get();
 }

 public function gettempwl() {
//  Artisan::call('modelCache:clear');
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
   $ZZFLBLD = $request->PWAH_Building." ชั้น ".$request->PWAH_Floor;
  $data = WLSavedata::where('PERNR',auth()->user()->username)->first();
  if($data) {
    $data->type_code = $request->WL_Type;
    $data->BEGDA = date("Y.m.d");
    $data->ZZCODE = $request->WL_Name;
    $data->ZZROMNO =  $request->PWAH_Room;
    $data->ZZFLBLD =  $ZZFLBLD;
    $data->ZZBLD =  $request->PWAH_Building;
    $data->ZZFL =  $request->PWAH_Floor;
    $data->ZZOFTEL =  $request->PWAH_PhoneNumber;
    $data->ZZOFTELFULL =  $request->PWAH_PhoneNumberFull;
    $data->ZZMOBL =  $request->PWAH_MobilePhoneNumber;
    $data->line_id =  $request->lineID;
    $data->INTM_NAME =$request->INTM_NAME;
    $data->INTM_TEL =$request->INTM_TEL;
    $data->INTM_RELATION =$request->INTM_RELATION;
    $data->GENTEXT_AT =  NULL;
    $data->updated_at = date("Y-m-d h:i:sa");
    $data->save();
  } else {
    $data = new WLSavedata;
    $data->PERNR = auth()->user()->username;
    $data->type_code = $request->WL_Type;
    $data->BEGDA = date("Y.m.d");
    $data->ZZCODE = $request->WL_Name;
    $data->ZZROMNO =  $request->PWAH_Room;
    $data->ZZFLBLD =  $ZZFLBLD;
    $data->ZZBLD =  $request->PWAH_Building;
    $data->ZZFL =  $request->PWAH_Floor;
    $data->ZZOFTEL =  $request->PWAH_PhoneNumber;
    $data->ZZOFTELFULL =  $request->PWAH_PhoneNumberFull;
    $data->ZZMOBL =  $request->PWAH_MobilePhoneNumber;
    $data->line_id =  $request->lineID;
    $data->INTM_NAME =$request->INTM_NAME;
    $data->INTM_TEL =$request->INTM_TEL;
    $data->INTM_RELATION =$request->INTM_RELATION;
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
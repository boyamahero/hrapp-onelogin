<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\GeoLocation;
use App\Http\Requests;
use App\Http\Controllers\Controller;
class GeoLocationController extends Controller
{
    public function insert(Request $request){
        // return $request;
         return GeoLocation::all();
    }
}

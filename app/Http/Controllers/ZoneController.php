<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Zone;


class ZoneController extends Controller
{
    //
    public function zoneUpdateAjax($request){

    }
    public function zones(){
        $zones = Zone::all();
        return view('zones.zones', ['zones'=>$zones]);
    }
    public function submitZones(Request $request){
         #Taking all POST requests from the form
         $valid = Validator::make( $request->all(), [
            'zone_name'=>'required|unique:zones,name|min:4',
            'code'=>'required|unique:zones,name|min:2',
            'phy_address'=>'required'
        ] );

        if ( $valid->fails() ) {
            #Returns errors with Error Bag 'registerZone'
            return back()->withErrors( $valid, 'registerZone' )->withInput();
        }

        # END:: VALIDATION

        $zoneObject = new Zone;
        $zoneObject->zone_code = strtoupper($request->code);
        $zoneObject->name=strtoupper($request->zone_name);
        $zoneObject->postal_address=strtoupper($request->po_address);
        $zoneObject->physical_address=strtoupper($request->phy_address);
        $zoneObject->phone=$request->phone;
        $zoneObject->email=strtolower($request->email);
        $zoneObject->created_by  = auth()->user()->id;
        $zoneObject->save();

        return redirect('contributors/zones')->with( [ 'success'=>'Zone has been successfully created' ] );
    }
    public function ajaxZoneGetData() {
        

    }
    public function updateZoneStatus(){

    }
}

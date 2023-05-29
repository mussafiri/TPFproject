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
            'email'=>'email',
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

        toastr();
        return redirect('contributors/zones')->with( [ 'success'=>'Zone has been successfully created' ] );
    }
    public function ajaxZoneGetData(Request $ajaxreq) {
        $id = $ajaxreq[ 'zone_id' ];

        $zoneRow = Zone::find( $id );
        if ( $zoneRow) {
            $zone_data = Zone::where('id', $id )->first();
            $zone_data[ 'status' ] = 'success';
            $zone_data[ 'message' ] = 'Zone data has been Succefully fetched';
            $zone_data[ 'data' ] = $zone_data;
        } else {
            $zone_data[ 'status' ] = 'Errors';
            $zone_data[ 'message' ] = 'We could not find such Zone in our database';
        }
        return response()->json( [ 'zone_data'=>$zone_data ] );
    }
    public function updateZoneStatus(){

    }
}

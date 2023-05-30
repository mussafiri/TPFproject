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
    public function ajaxUpdateZoneStatus(Request $request){
        #Taking all POST requests from the form
        $valid = Validator::make($request->all(), [
            'zone' => 'required',
            'new_status' => 'required'
        ]);

        if ($valid->fails()) {
            return back()->withErrors($valid)->withInput();
        }
        $status = $request->new_status;
        $new_status = $request->new_status == 'Suspend' ? 'DORMANT' : 'ACTIVE';
        $new_message = $request->new_status == 'Suspend' ? 'Suspended' : 'Activated';

        #Create an object for Database Storage
        $zoneStatusJSON = array();
        //array for ajax response
        $zone_id = $request['zone'];
        $materialCatRow = Zone::find($zone_id);
        if ($materialCatRow) {
            $zoneObj = Zone::find($zone_id);
            $zoneObj->status = $new_status;
            $zoneObj->updated_by = auth()->user()->id;
            $zoneObj->save();
            $zoneStatusJSON['status'] = 'success';
            $zoneStatusJSON['message'] = 'Zone has been Successfully &nbsp;' . $new_message;
        } else {
            $zoneStatusJSON['status'] = 'Errors';
            $zoneStatusJSON['message'] = 'We could not find such Zone in our database!';
        }

        return response()->json(['statZoneJSONArr' => $zoneStatusJSON]);  
    }
    public function submitZoneEdit(Request $request){
         #Taking all POST requests from the form
        $valid = Validator::make( $request->all(), [
            'zone_name'=>'required|min:4',
            'zone_code'=>'required|min:2',
            'email'=>'email',
            'phy_address'=>'required'
        ] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid, 'updateZone' )->withInput();
        }
        # END:: VALIDATION
        $zone = $request->zone_id;
        $zoneObj = Zone::find( $zone );
        $zoneObj->zone_code = strtoupper($request->zone_code);
        $zoneObj->name=strtoupper($request->zone_name);
        $zoneObj->postal_address=strtoupper($request->po_address);
        $zoneObj->physical_address=strtoupper($request->phy_address);
        $zoneObj->phone=$request->phone;
        $zoneObj->email=strtolower($request->email);
        $zoneObj->updated_by  = auth()->user()->id;
        $zoneObj->save();

        toastr();
        return redirect('contributors/zones')->with([ 'success'=>'Zone has been updated successfully!' ]);
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
        return redirect('contributors/zones')->with([ 'success'=>'Zone has been successfully created' ]);
    }
    public function ajaxZoneGetData(Request $ajaxreq) {
        $id = $ajaxreq[ 'zone_id' ];

        $zoneRow = Zone::find( $id );
        if ($zoneRow) {
            $zoneRowData = Zone::where('id', $id )->first();
            $zone_data[ 'status' ] = 'success';
            $zone_data[ 'message' ] = 'Zone data has been Succefully fetched';
            $zone_data[ 'data' ] = $zoneRowData;
        } else {
            $zone_data[ 'status' ] = 'Errors';
            $zone_data[ 'message' ] = 'We could not find such Zone in our database';
        }
        return response()->json( [ 'zoneJSONData'=>$zone_data ]);
    }
   
}

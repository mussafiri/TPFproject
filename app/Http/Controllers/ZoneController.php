<?php

namespace App\Http\Controllers;
use App\Lib\Common;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Zone;
use App\Models\District;
use App\Models\Section;


class ZoneController extends Controller
{
    //
    public function __construct(){
        $this->cmn = new Common;
    }
    public function submitSectionEdit(Request $request){
         #Taking all POST requests from the form
         $valid = Validator::make($request->all(), [
            'section_name' => 'required|min:3',
            'section_id' => 'required',
            'district_name' => 'required|gt:0',
            'email' => 'email',
            'physicalAddress' => 'required'],  

                ['district_name.gt' => 'You must select District',]
        );

        if ( $valid->fails() ) {
            #Returns errors with Error Bag 'registerSection'
            return back()->withErrors( $valid, 'updateSection' )->withInput();
        }

        # END:: VALIDATION
        $sectioneditObject = Section::find( $request->section_id);
        $sectioneditObject->district_id = $request->district_name;
        $sectioneditObject->name=strtoupper($request->section_name);
        $sectioneditObject->postal_address=strtoupper($request->postalAddress);
        $sectioneditObject->physical_address=strtoupper($request->physicalAddress);
        $sectioneditObject->phone=$request->phone;
        $sectioneditObject->email=strtolower($request->email);
        $sectioneditObject->updated_by  = auth()->user()->id;
        #Generate district Code
        if ( $sectioneditObject->save() ) {
            $districtRow=District::where("id",$sectioneditObject->district_id)->first();
            $district_code=$districtRow->district_code;
            $this->cmn -> sectionCodeGenerator($sectioneditObject->id,$sectioneditObject->name,$district_code);

            toastr();
            return redirect('zones/sections/'.Crypt::encryptString("ACTIVE"))->with(['success'=>'Section has been successfully updated!']);
        }
        toastr();
        return redirect('zones/sections/'.Crypt::encryptString("ACTIVE"))->with(['error'=>'Oops, Section has not been successfully updated!']);
    }
    public function ajaxSectionGetData(Request $ajaxreq){
        $id = $ajaxreq['section_id'];
        $districtsArray = District::where( "status","ACTIVE")->get();
        $sectionRow = Section::find( $id );
        $section_data=array();
        if ($sectionRow) {
            $sectionRowData = Section::where('id', $id )->first();
            $section_data[ 'status' ] = 'success';
            $section_data[ 'message' ] = 'District data has been Succefully fetched';
            $section_data[ 'data' ] = $sectionRowData;
            $section_data[ 'district_collection' ] = $districtsArray;
        } else {
            $section_data[ 'status' ] = 'Errors';
            $section_data[ 'message' ] = 'We could not find such District in our database';
        }
        return response()->json(['sectionJSONData'=>$section_data]);

    }

    public function ajaxGetDistrictOldData(){
        $getDistrictData = District::where('status','ACTIVE')->get();
        $getDistrictDataArr=array();
        if($getDistrictData){
            $getDistrictDataArr['status'] ='success';
            $getDistrictDataArr['data'] =$getDistrictData;
        }else{
            $getDistrictDataArr['status'] ='fail';
            $getDistrictDataArr['message'] = 'No data found';
        }
        return response()->json(['getDistrictDataArr'=>$getDistrictDataArr]);
    }
    public function ajaxUpdateSectionStatus(Request $request){ 
        #Taking all POST requests from the form
        $valid = Validator::make($request->all(), [
            'section' => 'required',
            'status' => 'required'
        ]);

        if ($valid->fails()) {
            return back()->withErrors($valid)->withInput();
        }
        $status = $request['status'];
        $new_status = $status == 'suspend' ? 'SUSPENDED' : 'ACTIVE';
        $message_status = $status == 'suspend' ? 'Suspended' : 'Activated';

        #Create an object for Database Storage
        $sectionStatusJSON = array();
        //array for ajax response
        $section_id = $request['section'];
        $sectionRow = Section::find($section_id);
        if ($sectionRow) {
            $sectionObj = Section::find($section_id);
            $sectionObj->status = $new_status;
            $sectionObj->updated_by = auth()->user()->id;
            $sectionObj->save();
            
            $sectionStatusJSON['status'] = 'success';
            $sectionStatusJSON['message'] = 'Section <span class="text-info">'.$sectionRow->name.'</span> has been successfully &nbsp;';
            $sectionStatusJSON['message_status'] = $message_status;
        } else {
            $sectionStatusJSON['status'] = 'Errors';
            $sectionStatusJSON['message'] = 'We could not find such Section in our database!';
        }

        return response()->json(['statSectionJSONArr' => $sectionStatusJSON]);  
        
    }

    public function submitSection(Request $request){
        #Taking all POST requests from the form
        $valid = Validator::make($request->all(), [
            'section_name' => 'required|unique:sections,name|min:3',
            'district' => 'required|gt:0',
            'email' => 'email',
            'physicalAddress' => 'required'],  

                ['district.gt' => 'You must select District',]
        );

        if ( $valid->fails() ) {
            #Returns errors with Error Bag 'registerSection'
            return back()->withErrors( $valid, 'registerSection' )->withInput();
        }

        # END:: VALIDATION
        $sectionregObject = new Section;
        $sectionregObject->district_id = $request->district;
        $sectionregObject->section_code = "NULL";
        $sectionregObject->name=strtoupper($request->section_name);
        $sectionregObject->postal_address=strtoupper($request->postalAddress);
        $sectionregObject->physical_address=strtoupper($request->physicalAddress);
        $sectionregObject->phone=$request->phone;
        $sectionregObject->email=strtolower($request->email);
        $sectionregObject->status="ACTIVE";
        $sectionregObject->created_by  = auth()->user()->id;
        #Generate district Code
        if ( $sectionregObject->save() ) {
            $districtRow=District::where("id",$sectionregObject->district_id)->first();
            $district_code=$districtRow->district_code;
            $this->cmn -> sectionCodeGenerator($sectionregObject->id,$sectionregObject->name,$district_code);

            toastr();
            return redirect('zones/sections/'.Crypt::encryptString("ACTIVE"))->with(['success'=>'Section has been successfully created!']);
        }
        toastr();
        return redirect('zones/sections/'.Crypt::encryptString("ACTIVE"))->with(['error'=>'Oops, Section has not been successfully created!']);
    }

    public function sections($stat){
        $status=Crypt::decryptString($stat);
        $sectionArr = Section::where("status",$status)->get();
        $zonesArr = District::where("status","ACTIVE")->get();
        return view('zones.sections', ['districts'=>$zonesArr,'sections'=>$sectionArr,'status'=>$status]);
    }
    public function ajaxUpdateDistrictStatus(Request $request){ 
        #Taking all POST requests from the form
        $valid = Validator::make($request->all(), [
            'district' => 'required',
            'status' => 'required'
        ]);

        if ($valid->fails()) {
            return back()->withErrors($valid)->withInput();
        }
        $status = $request['status'];
        $new_status = $status == 'suspend' ? 'SUSPENDED' : 'ACTIVE';
        $message_status = $status == 'suspend' ? 'Suspended' : 'Activated';

        #Create an object for Database Storage
        $districtStatusJSON = array();
        //array for ajax response
        $district_id = $request['district'];
        $districtRow = District::find($district_id);
        if ($districtRow) {
            $districtObj = District::find($district_id);
            $districtObj->status = $new_status;
            $districtObj->updated_by = auth()->user()->id;
            $districtObj->save();
            
            $districtStatusJSON['status'] = 'success';
            $districtStatusJSON['message'] = 'District <span class="text-info">'.$districtRow->name.'</span> has been successfully &nbsp;';
            $districtStatusJSON['message_status'] = $message_status;
        } else {
            $districtStatusJSON['status'] = 'Errors';
            $districtStatusJSON['message'] = 'We could not find such District in our database!';
        }

        return response()->json(['statDistrictJSONArr' => $districtStatusJSON]);  
        
    }
    public function ajaxGetZoneOldData(){
        $getZoneData= Zone::where('status','ACTIVE')->get();
        $getZoneDataArr=array();
        if($getZoneData){
            $getZoneDataArr['status'] ='success';
            $getZoneDataArr['data'] =$getZoneData;
        }else{
            $getZoneDataArr['status'] ='fail';
            $getZoneDataArr['message'] = 'No data found';
        }
        return response()->json(['getZoneDataArr'=>$getZoneDataArr]);
    }

    public function ajaxDistrictGetData(Request $ajaxreq){
        $id = $ajaxreq['district_id'];
        $zonesArray = Zone::where( "status","ACTIVE")->get();
        $districtRow = District::find( $id );
        if ($districtRow) {
            $districtRowData = District::where('id', $id )->first();
            $district_data[ 'status' ] = 'success';
            $district_data[ 'message' ] = 'District data has been Succefully fetched';
            $district_data[ 'data' ] = $districtRowData;
            $district_data[ 'zones_collection' ] = $zonesArray;
        } else {
            $district_data[ 'status' ] = 'Errors';
            $district_data[ 'message' ] = 'We could not find such District in our database';
        }
        return response()->json(['districtJSONData'=>$district_data]);
    }
    public function submitDistrictEdit(Request $request){
        #Taking all POST requests from the form
        $valid = Validator::make(
            $request->all(),[
                'district_name' => 'required|min:4',
                'zone_name' => 'required|gt:0',
                'district_id' => 'required',
                'email' => 'email',
                'physicalAddress' => 'required'
            ],

            ['zone_name.gt' => 'You must select Zone',]
        );

        if ($valid->fails()) {
            #Returns errors with Error Bag 'updateDistrict'
            return back()->withErrors($valid, 'updateDistrict')->withInput();
        }

        # END:: VALIDATION
        $districtupdateObj = District::find($request->district_id);
        $districtupdateObj->zone_id = $request->zone_name;
        $districtupdateObj->name = strtoupper($request->district_name);
        $districtupdateObj->postal_address = strtoupper($request->postalAddress);
        $districtupdateObj->physical_address = strtoupper($request->physicalAddress);
        $districtupdateObj->phone = $request->phone;
        $districtupdateObj->email = strtolower($request->email);
        $districtupdateObj->updated_by  = auth()->user()->id;
        #Generate district Code
        if ($districtupdateObj->save()) {
            $zoneRow = Zone::find($districtupdateObj->zone_id)->first();
            $zone_code = $zoneRow->zone_code;
            $this->cmn->districtCodeGenerator($districtupdateObj->id, $districtupdateObj->name, $zone_code);

            toastr();
            return redirect('zones/districts/'.Crypt::encryptString('ACTIVE'))->with(['success' => 'District has been successfully updated!']);
        }
        toastr();
        return redirect('zones/districts/'.Crypt::encryptString('ACTIVE'))->with(['error' => 'Oops, District has not been successfully updated!']);
    }
    public function submitDistrict(Request $request){
        #Taking all POST requests from the form
        $valid = Validator::make($request->all(), [
            'district_name' => 'required|unique:districts,name|min:4',
            'zone' => 'required|gt:0',
            'email' => 'email',
            'physicalAddress' => 'required'],  

             ['zone.gt' => 'You must select Zone',]
        );

        if ( $valid->fails() ) {
            #Returns errors with Error Bag 'registerDistrict'
            return back()->withErrors( $valid, 'registerDistrict' )->withInput();
        }

        # END:: VALIDATION
        $districtregObject = new District;
        $districtregObject->zone_id = $request->zone;
        $districtregObject->district_code = "NULL";
        $districtregObject->name=strtoupper($request->district_name);
        $districtregObject->postal_address=strtoupper($request->postalAddress);
        $districtregObject->physical_address=strtoupper($request->physicalAddress);
        $districtregObject->phone=$request->phone;
        $districtregObject->email=strtolower($request->email);
        $districtregObject->status="ACTIVE";
        $districtregObject->created_by  = auth()->user()->id;
        #Generate district Code
        if ( $districtregObject->save() ) {
            $zoneRow=Zone::find($districtregObject->zone_id)->first();
            $zone_code=$zoneRow->zone_code;
            $this->cmn -> districtCodeGenerator($districtregObject->id,$districtregObject->name,$zone_code);

            toastr();
            return redirect('zones/districts')->with(['success'=>'District has been successfully created!']);
        }
        toastr();
        return redirect('zones/districts')->with(['error'=>'Oops, District has not been successfully created!']);
    }
    public function districts($stat){
        $status=Crypt::decryptString($stat);
        $districts = District::where("status",$status)->get();
        $zones=Zone::where('status',"ACTIVE")->get();
        return view('zones.districts', ['districts'=>$districts,"zones"=>$zones,"status"=>$status]);
    }
    public function ajaxUpdateZoneStatus(Request $request){
        #Taking all POST requests from the form
        $valid = Validator::make($request->all(), [
            'zone' => 'required',
            'status' => 'required'
        ]);

        if ($valid->fails()) {
            return back()->withErrors($valid)->withInput();
        }
        $status = $request['status'];
        $new_status = $status == 'suspend' ? 'SUSPENDED' : 'ACTIVE';
        $message_status = $status == 'suspend' ? 'Suspended' : 'Activated';

        #Create an object for Database Storage
        $zoneStatusJSON = array();
        //array for ajax response
        $zone_id = $request['zone'];
        $zoneRow = Zone::find($zone_id);
        if ($zoneRow) {
            $zoneObj = Zone::find($zone_id);
            $zoneObj->status = $new_status;
            $zoneObj->updated_by = auth()->user()->id;
            $zoneObj->save();
            
            $zoneStatusJSON['status'] = 'success';
            $zoneStatusJSON['message'] = 'Zone <span class="text-info">'.$zoneRow->name.'</span> has been successfully &nbsp;';
            $zoneStatusJSON['message_status'] = $message_status;
        } else {
            $zoneStatusJSON['status'] = 'Errors';
            $zoneStatusJSON['message'] = 'We could not find such Zone in our database!';
        }

        return response()->json(['statZoneJSONArr' => $zoneStatusJSON]);  
    }
    public function submitZoneEdit(Request $request){
         #Taking all POST requests from the form
        $valid = Validator::make($request->all(), [
            'zone_name'=>'required|min:4',
            'zone_code'=>'required|min:2',
            'email'=>'email',
            'phy_address'=>'required'
        ]);

        if ( $valid->fails() ) {
            return back()->withErrors( $valid, 'updateZone' )->withInput();
        }
        # END:: VALIDATION
        $zone = $request->zone_id;
        $zoneObj = Zone::find($zone);
        $zoneObj->zone_code = strtoupper($request->zone_code);
        $zoneObj->name=strtoupper($request->zone_name);
        $zoneObj->postal_address=strtoupper($request->po_address);
        $zoneObj->physical_address=strtoupper($request->phy_address);
        $zoneObj->phone=$request->phone;
        $zoneObj->email=strtolower($request->email);
        $zoneObj->updated_by  = auth()->user()->id;
        $zoneObj->save();

        toastr();
        return redirect('zones/list')->with([ 'success'=>'Zone has been updated successfully!' ]);
    }
    public function suspendedZones(){
        $zones = Zone::where("status","!=","ACTIVE")->get();
        return view('zones.zones_suspended', ['zones'=>$zones]);
    }
    public function zones(){
        $zones = Zone::where("status","ACTIVE")->get();
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
        return redirect('zones/list')->with([ 'success'=>'Zone has been successfully created' ]);
    }
    public function ajaxZoneGetData(Request $ajaxreq){
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

<?php

namespace App\Http\Controllers;
use App\Lib\Common;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\Contributor;
use App\Models\MemberIdentityType;
use App\Models\MemberSalutation;
use App\Models\Section;

class MemberController extends Controller {
    public function __construct(){
        $this->cmn      = new Common;
        $this->carbonDateObj     = new Carbon('Africa/Dar_es_Salaam');
    }
    public function index() {}
    
    public function submitMemberDependants(Request $request){
         #START::Handle Files Upload Registration Form
        // Check for member Dependant Profile photo upload
        if ( $request->hasFile( 'member_avatar' ) ) {
            $filenameWithExt = $request->file( 'member_avatar' )->getClientOriginalName();
            // Get just filename
            $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME );
            //Get just ext
            $extension = $request->file( 'member_avatar' )->getClientOriginalExtension();
            // Create new Filename
            $newfilename = 'MEMPHOTO_' . date( 'y' );
            // FileName to Store
            $profile_photo = $newfilename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file( 'member_avatar' )->storeAs( 'public/members/photo', $profile_photo );
        } else {
            $profile_photo = 'NULL';
        }
        // Check for member individual ID photo upload
        if ( $request->hasFile( 'member_id' ) ) {
            $filenameWithExt = $request->file( 'member_id' )->getClientOriginalName();
            // Get just filename
            $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME );
            //Get just ext
            $extension = $request->file( 'member_id' )->getClientOriginalExtension();
            // Create new Filename
            $newfilename = 'MEMIDS_' . date( 'y' );
            // FileName to Store
            $id_attachment = $newfilename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file( 'member_id' )->storeAs( 'public/members/ids', $id_attachment );
        } else {
            $id_attachment = 'NULL';
        }
        if ( $request->hasFile( 'regform_attachment' ) ) {
            $filenameWithExt = $request->file( 'regform_attachment' )->getClientOriginalName();
            // Get just filename
            $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME );
            //Get just ext
            $extension = $request->file( 'regform_attachment' )->getClientOriginalExtension();
            // Create new Filename
            $newfilename = 'MEMREGFRM_' . date( 'y' );
            // FileName to Store
            $reg_form = $newfilename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file( 'regform_attachment' )->storeAs( 'public/members/reg_forms', $reg_form );
        } else {
            $reg_form = 'NULL';
        }

        
        // Check for member signature upload
        if ( $request->hasFile( 'member_signature' ) ) {
            $filenameWithExt = $request->file( 'member_signature' )->getClientOriginalName();
            // Get just filename
            $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME );
            //Get just ext
            $extension = $request->file( 'member_signature' )->getClientOriginalExtension();
            // Create new Filename
            $newfilename = 'MEMPHOTO_' . date( 'y' );
            // FileName to Store
            $signature = $newfilename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file( 'member_signature' )->storeAs( 'public/members/signatures', $signature );
        } else {
            $signature = 'NULL';
        }
        #END::Handle File Upload Registration Form

    }
    public function ajaxRowDynamicValidation(Request $ajaxreq){
        #Taking all POST requests from the form
        $validator = Validator::make($ajaxreq->all(), [
            'inputs.*' => 'array',
            'inputs.*.dep_relationship' => 'required|not_in:0',
            'inputs.*.dep_gender' => 'required|not_in:0',
            'inputs.*.dep_firstname' => 'required',
            'inputs.*.dep_midname' => 'required',
            'inputs.*.dep_lastname' => 'required',
            'inputs.*.dep_dob' => 'required',

        ],  
        [   'inputs.*.dep_firstname.required' => 'First name is required',
            'inputs.*.dep_gender.required','inputs.*.dep_gender.not_in' => 'Gender is required',
            'inputs.*.dep_midname.required' => 'Middle name is required',
            'inputs.*.dep_relationship.required','inputs.*.dep_relationship.not_in' => 'Relationship is required',
            'inputs.*.dep_dob.required' => 'Date of Birth is required',
            'inputs.*.dep_lastname.required' => 'Last name is required',

        ]


    );
    if($validator->fails()){
        return response()->json(['errors' => $validator->errors()->toArray()]);
    }else{
        return response()->json(['message' => $ajaxreq->all()]);

    }


    }
    public function submitMemberRegistration(Request $request) {
        #Taking all POST requests from the form
        $valid = Validator::make($request->all(), [
            'firstname' => 'required|unique:sections,name|min:3',
            'middle_name' => 'required',
            'evengelical_title' => 'required|gt:0',
            'salutation' => 'required|not_in:0',
            'firstname' => 'required|min:3',
            'middle_name' => 'required',
            'lastname' => 'required|min:3',
            'email' =>'email',
            'marital_status' => 'required|not_in:0',
            'gender' => 'required|not_in:0',
            'dob' => 'required',
            'postalAddress' => 'required',
            'physicalAddress' => 'required',
            'phone' => 'required',
            'occupation' => 'required|not_in:0',
            'joining_date' => 'required',
            'service_date' => 'required',
            'id_type' => 'required|not_in:0',
            'id_number' => 'required',
            'contributor_name' => 'required|not_in:0',
            'monthly_income' => 'required',
        ],  

            ['evengelical_title.gt' => 'You must select Evengelical Title',
            'salutation.not_in' => 'You must select Salutation',
            'marital_status.not_in' => 'You must select Marital Status',
            'gender.not_in' => 'You must select Gender',
            'occupation.gt' => 'You must select Occupation',
            'id_type.not_in' => 'You must select ID type',
            'contributor_name.not_in' => 'You must select a Contributor',
            ]
        );

        if ( $valid->fails() ) {
            #Returns errors with Error Bag 'registerMember'
            return back()->withErrors( $valid, 'registerMemberDetails' )->withInput();
        }
        # END:: VALIDATION
        #START::Handle Files Upload Registration Form
        // Check for member Profile photo upload
        if ( $request->hasFile( 'member_avatar' ) ) {
            $filenameWithExt = $request->file( 'member_avatar' )->getClientOriginalName();
            // Get just filename
            $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME );
            //Get just ext
            $extension = $request->file( 'member_avatar' )->getClientOriginalExtension();
            // Create new Filename
            $newfilename = 'MEMPHOTO_' . date( 'y' );
            // FileName to Store
            $profile_photo = $newfilename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file( 'member_avatar' )->storeAs( 'public/members/photo', $profile_photo );
        } else {
            $profile_photo = 'NULL';
        }
        // Check for member individual ID photo upload
        if ( $request->hasFile( 'member_id' ) ) {
            $filenameWithExt = $request->file( 'member_id' )->getClientOriginalName();
            // Get just filename
            $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME );
            //Get just ext
            $extension = $request->file( 'member_id' )->getClientOriginalExtension();
            // Create new Filename
            $newfilename = 'MEMIDS_' . date( 'y' );
            // FileName to Store
            $id_attachment = $newfilename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file( 'member_id' )->storeAs( 'public/members/ids', $id_attachment );
        } else {
            $id_attachment = 'NULL';
        }
        if ( $request->hasFile( 'regform_attachment' ) ) {
            $filenameWithExt = $request->file( 'regform_attachment' )->getClientOriginalName();
            // Get just filename
            $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME );
            //Get just ext
            $extension = $request->file( 'regform_attachment' )->getClientOriginalExtension();
            // Create new Filename
            $newfilename = 'MEMREGFRM_' . date( 'y' );
            // FileName to Store
            $reg_form = $newfilename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file( 'regform_attachment' )->storeAs( 'public/members/reg_forms', $reg_form );
        } else {
            $reg_form = 'NULL';
        }

        
        // Check for member signature upload
        if ( $request->hasFile( 'member_signature' ) ) {
            $filenameWithExt = $request->file( 'member_signature' )->getClientOriginalName();
            // Get just filename
            $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME );
            //Get just ext
            $extension = $request->file( 'member_signature' )->getClientOriginalExtension();
            // Create new Filename
            $newfilename = 'MEMPHOTO_' . date( 'y' );
            // FileName to Store
            $signature = $newfilename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file( 'member_signature' )->storeAs( 'public/members/signatures', $signature );
        } else {
            $signature = 'NULL';
        }
        #END::Handle File Upload Registration Form
        $dob = $this->carbonDateObj->format('Y-m-d',$request->dob);
        $default_pwd = password_hash( $request->firstname.$dob, PASSWORD_BCRYPT, [ 'cost'=>10 ] );


        $memberRegObject = new Member;
        $memberRegObject->contributor_id        = $request->contributor_name;
        $memberRegObject->title                 = $request->salutation;
        $memberRegObject->member_salutation_id  = $request->evengelical_title;
        $memberRegObject->fname                 = strtoupper($request->firstname);
        $memberRegObject->mname                 = strtoupper($request->middle_name);
        $memberRegObject->lname                 = strtoupper($request->lastname);
        $memberRegObject->gender                = $request->gender;
        $memberRegObject->member_code           = "NULL";
        $memberRegObject->occupation            = $request->occupation;
        $memberRegObject->id_type_id            = $request->id_type;
        $memberRegObject->id_number             = $request->id_number;
        $memberRegObject->dob                   = $dob;
        $memberRegObject->service_start_at      = $request->service_date;
        $memberRegObject->join_at               = $request->joining_date;
        $memberRegObject->marital_status        = $request->marital_status;
        $memberRegObject->phone                 = $request->phone;
        $memberRegObject->email                 = $request->email;
        $memberRegObject->income                = str_replace(['TZS.',',',' '],'',$request->monthly_income);
        $memberRegObject->postal_address        = $request->postalAddress;
        $memberRegObject->physical_address      = $request->physicalAddress;
        $memberRegObject->picture               = $profile_photo;
        $memberRegObject->id_attachment         = $id_attachment;
        $memberRegObject->member_signature      = $signature;
        $memberRegObject->regform_attachment    = $reg_form;
        $memberRegObject->status                ="ACTIVE";
        $memberRegObject->password              = $default_pwd;
        $memberRegObject->created_by            = auth()->user()->id;
        # Check if the transaction is successfully
        if ( $memberRegObject->save() ) {
            #Return the Dependants View
            $this->cmn -> memberCodeGenerator($memberRegObject->id);

            toastr();
            return redirect('members/registration/')->with(['success'=>'Member has been successfully created!','member_data'=>$memberRegObject,"response_message"=>"SUCCESS"]);
        }
        toastr();
        return redirect('members/registration/'.Crypt::encryptString("ACTIVE"))->with(['error'=>'Oops, Member has not been successfully created!','response_message'=>"FAIL"]);

    }
    public function members() {
        $members = Member::limit(500)->get();
        return view('members.members_list', ['members'=>$members]);
    }
    public function regMemberView() {
        $salutation_title=MemberSalutation::where("status","ACTIVE")->get();
        $contributors=Contributor::where("status","ACTIVE")->get();
        $identity_types=MemberIdentityType::where("status","ACTIVE")->get();
        $message = session('response_message');
        $member_data = session('member_data');
        return view('members.member_registration_form', ['contributors'=>$contributors,"titles"=>$salutation_title,"ids"=>$identity_types,"response_message"=>$message,"member_data"=>$member_data]);
    }


}

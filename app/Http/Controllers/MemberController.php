<?php

namespace App\Http\Controllers;
use App\Lib\Common;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\MemberDependant;
use App\Models\Member;
use App\Models\Contributor;
use App\Models\MemberIdentityType;
use App\Models\MemberSalutation;
use App\Models\Section;
use App\Models\Contribution;
use App\Models\ContributionDetail;
use App\Models\ContributorMember;

class MemberController extends Controller {
    public function __construct(){
        $this->cmn      = new Common;
        $this->carbonDateObj     = new Carbon('Africa/Dar_es_Salaam');
    }
    public function index() { }

    public function submitMemberEditDetails(Request $request, $member) {
        #Taking all POST requests from the form
        $submit_type    =   $request->submission_type;
        $member_id      =   Crypt::decryptString($member);

        if ($submit_type=="MEMBER-PARTICULARS") {

            $valid = Validator::make($request->all(), [
                    'firstname' => 'required|min:3',
                    'middle_name' => 'required|min:3',
                    'lastname' => 'required|min:3',
                    'evengelical_title' => 'required|gt:0',
                    'salutation' => 'required|not_in:0',
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
                    'monthly_income' => 'required',
                ],

                [   'evengelical_title.gt' => 'You must select Evengelical Title',
                    'salutation.not_in' => 'You must select Salutation',
                    'marital_status.not_in' => 'You must select Marital Status',
                    'gender.not_in' => 'You must select Gender',
                    'occupation.gt' => 'You must select Occupation',
                ]
            );

            if ( $valid->fails() ) {
               
                #Returns errors with Error Bag 'registerMember'
                return back()->withErrors( $valid, 'editMemberDetails' )->withInput();
            }

            $newFormatteddate =  Carbon::createFromFormat('d M Y',$request->dob);
            $dob = $this->carbonDateObj->format('Y-m-d',$newFormatteddate);
            
            $servicedate_format = Carbon::createFromFormat('d M Y',$request->service_date);
            $servicedate = $this->carbonDateObj->format('Y-m-d',$servicedate_format);
                
                $memberDetsUpdateObject = Member::find($member_id);
                $memberDetsUpdateObject->title                 = $request->salutation;
                $memberDetsUpdateObject->member_salutation_id  = $request->evengelical_title;
                $memberDetsUpdateObject->fname                 = strtoupper($request->firstname);
                $memberDetsUpdateObject->mname                 = strtoupper($request->middle_name);
                $memberDetsUpdateObject->lname                 = strtoupper($request->lastname);
                $memberDetsUpdateObject->gender                = $request->gender;
                $memberDetsUpdateObject->occupation            = $request->occupation;
                $memberDetsUpdateObject->dob                   = $dob;
                $memberDetsUpdateObject->service_start_at      = $servicedate;
                $memberDetsUpdateObject->join_at               = $request->joining_date;
                $memberDetsUpdateObject->marital_status        = $request->marital_status;
                $memberDetsUpdateObject->phone                 = $request->phone;
                $memberDetsUpdateObject->email                 = $request->email;
                $memberDetsUpdateObject->income                = str_replace(['TZS.',',',' '],'',$request->monthly_income);
                $memberDetsUpdateObject->postal_address        = $request->postalAddress;
                $memberDetsUpdateObject->physical_address      = $request->physicalAddress;
                $memberDetsUpdateObject->updated_by            = auth()->user()->id;
                $memberDetsUpdateObject->save();
               
                toastr();
                return redirect('members/list')->with(['success'=>'Member details have been successfully Updated!']);

        }
        elseif($submit_type == "CONTRIBUTOR"){



        }
        elseif($submit_type == "DEPENDANTS"){

        }
        elseif($submit_type == "ATTACHMENT"){

        }else{
            toastr();
            return redirect('members/registration/'.Crypt::encryptString("ACTIVE"))->with(['error'=>'Oops, Member has not been successfully updated!']);
        }

    }

    public function membersEditView($member) {
        $id= Crypt::decryptString($member);
        $member_data = Member::find($id);
        $salutation_title=MemberSalutation::all();
        $identity_types=MemberIdentityType::all();
        $contributors=Contributor::all();
        return view('members.member_details_edit_view',  compact('member_data','salutation_title','contributors','identity_types'));
    }

    public function memberFetchFromSelectize(Request $request) {
        $select_request = $request->input('member_search'); 
        // dd($select_request); 
        if(!empty($select_request)) { 
            $members = Member::where(function ($query) use ($select_request) {
                $query->where(DB::raw("CONCAT(fname,' ',mname,' ',lname)","member_code"), 'LIKE', "%{$select_request}%");
            })->select(DB::raw("members.*"))->latest()->take(600)->get();
                                
            return view('members.members_list', ['members_filtered'=>$members,"selectize"=>"AVAILABLE"]);
        }else{
            return redirect('members/list');
        }

    }

    public function ajaxMemberSelectionFilterOptions(Request $ajaxreq) {
        $select_request = $ajaxreq['q'];
        $members = Member::where(function ($query) use ($select_request) {
            $query->where(DB::raw("CONCAT(fname, ' ', mname, ' ', lname)","member_code"), 'LIKE', "%{$select_request}%");
        })->select(DB::raw("CONCAT(fname, ' ', mname, ' ', lname) AS full_name,id,member_code"))->get();

       $member_data= array();
        if ($members) {
            $member_data[ 'status' ] = 'success';
            $member_data[ 'message' ] = 'Member data has been Succefully fetched';
            $member_data[ 'data' ] = $members;
        } else {
            $member_data[ 'status' ] = 'Errors';
            $member_data[ 'message' ] = 'We could not find such Member in our database';
        }
        return response()->json( [ 'members'=>$member_data ] );

    }
    public function memberViewDetails($member_id) {
        $member         = Crypt::decryptString($member_id);
        $member_data    = Member::where('id', $member)
                                  ->first();

        $member_contributions    = ContributionDetail::join("members",'members.id', '=', 'contribution_details.member_id')
                                        ->where("contribution_details.member_id",$member)
                                        ->get(["contribution_details.*"]);

        $transfer_history       = ContributorMember::join("members",'members.id', '=', 'contributor_members.member_id')
                                                ->where("contributor_members.member_id",$member)
                                                ->get(["contributor_members.*"]);

        $member_dependants       = MemberDependant::join("members",'members.id', '=', 'member_dependants.member_id')
                                                ->where("member_dependants.member_id",$member)
                                                ->get(["member_dependants.*"]);


        return view('members.members_details_view', ["member_data"=>$member_data,"member_contributions"=>$member_contributions,"transfers"=>$transfer_history,"dependants"=>$member_dependants]);
    }

    public function ajaxMemberDuplicateValidation(Request $ajaxreq){
        #Taking all POST requests from the form
        $newFormatteddate =  Carbon::createFromFormat('d M Y',$ajaxreq['dob']);
        $formatted_date =  $newFormatteddate->format('Y-m-d',$ajaxreq['dob']);
        // Check if the member already exists in the database
        $member = Member::where('fname', $ajaxreq['firstname'])
                ->where('mname', $ajaxreq['midname'])
                ->where('lname', $ajaxreq['lastname'])
                ->where('dob', $formatted_date)
                ->count();
        

        // If the member exists, return false
        $validator = $member > 0 ? "FAIL" : "SUCCESS";
        return response()->json(['validationError' => $validator]);
    }
    public function submitMemberDependants(Request $request){
         #START::Handle Files Upload Registration Form
        // Check for member Dependant Profile photo upload
        $dep_photo     = $request->file('dep_photo');
        $dep_birthcert = $request->file('dep_birthcert');
        $dep_marriagecert = $request->file('dep_marriagecert');

        foreach ($request->inputs as $index => $input) {
            if ($request->hasFile('dep_photo')) {
                // foreach ($dep_photos as $index => $dep_photo) {
                    $filenameWithExt = $dep_photo[$index]->getClientOriginalName();
                    // Get just filename
                    $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME );
                    //Get just ext
                    $extension = strtolower($dep_photo[$index]->getClientOriginalExtension());
                    // Create new Filename
                    $newfilename = 'MEMDEPPHOTO_' . date( 'y' );
                    // FileName to Store
                    $profile_photo = $newfilename . '_' . time() . '.' . $extension;
                    // Upload Image
                    $path = $dep_photo[$index]->storeAs( 'public/members/dependants/photo', $profile_photo );
                // }
                
            } else {
                $profile_photo = 'NULL';
            }
            // Check for member Dependant individual ID photo upload
            if ( $request->hasFile( 'dep_birthcert' ) ) {
                $filenameWithExt = $dep_birthcert[$index]->getClientOriginalName();
                // Get just filename
                $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME );
                //Get just ext
                $extension = strtolower($dep_birthcert[$index]->getClientOriginalExtension());
                // Create new Filename
                $newfilename = 'MEMDEPCERT_' . date( 'y' );
                // FileName to Store
                $depbirthcert_attachment = $newfilename . '_' . time() . '.' . $extension;
                // Upload Image
                $path = $dep_photo[$index]->storeAs( 'public/members/dependants/certificates', $depbirthcert_attachment );
            } else {
                $depbirthcert_attachment = 'NULL';
            }
            // Check for member individual ID photo upload
            if ( $request->hasFile( 'dep_marriagecert' ) ) {
                $filenameWithExt = $dep_marriagecert[$index]->getClientOriginalName();
                // Get just filename
                $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME );
                //Get just ext
                $extension = strtolower($dep_marriagecert[$index]->getClientOriginalExtension());
                // Create new Filename
                $newfilename = 'MEMDEPMCERT_' . date( 'y' );
                // FileName to Store
                $marriagecert_attachment = $newfilename . '_' . time() . '.' . $extension;
                // Upload Image
                $path = $dep_marriagecert[$index]->storeAs( 'public/members/dependants/certificates', $marriagecert_attachment );
            } else {
                $marriagecert_attachment = 'NULL';
            }
           
            #END::Handle File Upload Registration Form

            $dependant = new MemberDependant;
            $dependant->member_id       = $request->member_id;
            $dependant->relationship    = $input['dep_relationship'];
            $dependant->fname           = $input['dep_firstname'];
            $dependant->mname           = $input['dep_midname'];
            $dependant->lname           = $input['dep_lastname'];
            $dependant->gender          = $input['dep_gender'];
            $dependant->dob             = $input['dep_dob'];
            $dependant->phone           = $input['dep_phone'];
            $dependant->occupation      = $input['dep_occupation'];
            $dependant->vital_status    = $input['dep_vital_status'];
            $dependant->picture         = $profile_photo;
            $dependant->marriagecert    = $marriagecert_attachment;
            $dependant->birthcert       = $depbirthcert_attachment;
            $dependant->created_by      = auth()->user()->id;
            $dependant->save();
        }
        toastr();
        return redirect('members/list')->with(['success'=>'Member with Dependants have been successfully created!']);
    }
    public function ajaxRowDynamicValidation(Request $ajaxreq){
        #Taking all POST requests from the form
        $validator = Validator::make($ajaxreq->all(), [
            'inputs.*' => 'array',
            'inputs.*.dep_relationship' => 'required|not_in:0',
            'inputs.*.dep_gender' => 'required|not_in:0',
            'inputs.*.dep_vital_status' => 'required|not_in:0',
            'inputs.*.dep_occupation' => 'required|not_in:0',
            'inputs.*.dep_firstname' => 'required',
            'inputs.*.dep_midname' => 'required',
            'inputs.*.dep_lastname' => 'required',
            'inputs.*.dep_dob' => 'required',],  
            ['inputs.*.dep_firstname.required' => 'First name is required',
            'inputs.*.dep_gender.required','inputs.*.dep_gender.not_in' => 'Gender is required',
            'inputs.*.dep_vital_status.required','inputs.*.dep_vital_status.not_in' => 'Vital Status is required',
            'inputs.*.dep_occupation.required','inputs.*.dep_occupation.not_in' => 'Occupation is required',
            'inputs.*.dep_midname.required' => 'Middle name is required',
            'inputs.*.dep_relationship.required','inputs.*.dep_relationship.not_in' => 'Relationship is required',
            'inputs.*.dep_dob.required' => 'Date of Birth is required',
            'inputs.*.dep_lastname.required' => 'Last name is required',]
        );
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->toArray()]);
        }
    }
    public function submitMemberRegistration(Request $request) {
        #Taking all POST requests from the form
        $valid = Validator::make($request->all(), [
            'firstname' => 'required|min:3',
            'middle_name' => 'required|min:3',
            'lastname' => 'required|min:3',
            'evengelical_title' => 'required|gt:0',
            'salutation' => 'required|not_in:0',
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
            $extension = strtolower($request->file( 'member_avatar' )->getClientOriginalExtension());
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
            $extension = strtolower($request->file( 'member_id' )->getClientOriginalExtension());
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
            $extension = strtolower($request->file( 'regform_attachment' )->getClientOriginalExtension());
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
            $extension = strtolower($request->file( 'member_signature' )->getClientOriginalExtension());
            // Create new Filename
            $newfilename = 'MEMSIGN_' . date( 'y' );
            // FileName to Store
            $signature = $newfilename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file( 'member_signature' )->storeAs( 'public/members/signatures', $signature );
        } else {
            $signature = 'NULL';
        }
        #END::Handle File Upload Registration Form
        $newFormatteddate =  Carbon::createFromFormat('d M Y',$request->dob);
        $dob = $this->carbonDateObj->format('Y-m-d',$newFormatteddate);
        
        $servicedate_format = Carbon::createFromFormat('d M Y',$request->service_date);
        $servicedate = $this->carbonDateObj->format('Y-m-d',$servicedate_format);

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
        $memberRegObject->service_start_at      = $servicedate;
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
            // Insert a member to Contributor Member Table
            $contributorMemObj = new ContributorMember;
            $contributorMemObj->contributor_id        = $memberRegObject->contributor_id;
            $contributorMemObj->member_id             = $memberRegObject->id;
            $contributorMemObj->start_date            = $memberRegObject->joining_date;
            $contributorMemObj->status                = "ACTIVE";
            $contributorMemObj->created_by            = auth()->user()->id;
            $contributorMemObj->save();

            toastr();
            return redirect('members/registration/')->with(['success'=>'Member has been successfully created!','member_data'=>$memberRegObject,"response_message"=>"SUCCESS"]);
        }
        toastr();
        return redirect('members/registration/'.Crypt::encryptString("ACTIVE"))->with(['error'=>'Oops, Member has not been successfully created!','response_message'=>"FAIL"]);

    }
    public function members() {
        $members = Member::latest()->take(500)->get();
        return view('members.members_list', ['members'=>$members,"selectize"=>"UNAVAILABLE"]);
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

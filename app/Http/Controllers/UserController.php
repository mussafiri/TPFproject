<?php

namespace App\Http\Controllers;

use App\Mail\MailEngine;
use App\Models\Designation;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
    public function userList( $status ) {
        $status = Crypt::decryptString( $status );

        $getUsers = User::where( 'status', $status )->get();
        return view( 'users.users', [ 'getUsers'=>$getUsers, 'status'=>$status ] );
    }

    public function ajaxChangeUserUserStatus( Request $request ) {
        $new_status = $request->new_status == 'Block' ? 'BLOCKED' : 'ACTIVE';
        $new_message = $request->new_status == 'Block' ? 'Blocked' : 'Activated';

        $userChangeStatusArr = array();

        $updateUser = User::find( $request->data_id );
        if ( $updateUser ) {
            $updateUser->status = $new_status;
            $updateUser->updated_by = Auth::user()->id;
            $updateUser->save();

            $userChangeStatusArr[ 'status' ] = 'success';
            $userChangeStatusArr[ 'message' ] = 'User has been Successfully &nbsp;' . $new_message;

        } else {
            $userChangeStatusArr[ 'status' ] = 'Errors';
            $userChangeStatusArr[ 'message' ] = 'We could not find such User in our database!';
        }

        return response()->json( [ 'userChangeStatusArr' => $userChangeStatusArr ] );
    }

    public function addUser() {
        $departmentData = Department::where( 'status', 'ACTIVE' )->get();
        return view( 'users.user_add', [ 'departmentData'=>$departmentData ] );
    }

    public function ajaxGetDesignations( Request $request ) {

        $getDesignationData = Designation::where( 'department_id', $request->data_id )->where( 'status', 'ACTIVE' )->get();
        $designationsDataArr = array();

        if ( $getDesignationData ) {
            $designationsDataArr[ 'code' ] = 201;
            $designationsDataArr[ 'status' ] = 'success';
            $designationsDataArr[ 'data' ] = $getDesignationData;
        } else {

            $designationsDataArr[ 'code' ] = 403;
            $designationsDataArr[ 'status' ] = 'fail';
            $designationsDataArr[ 'message' ] = 'No Data Found';
        }

        return response()->json( [ 'designationsDataArr'=>$designationsDataArr ] );
    }

    public function submitAddUser( Request $request ) {
        # START:: VALIDATION
        $valid = Validator::make( $request->all(), [
            'fname'=>'required|string',
            'mname'=>'required|string',
            'lname'=>'required|string',
            'gender'=>'required|string',
            'phone'=>'required|string|unique:users,phone',
            'email'=>'required|email|unique:users,email',
            'department'=>'required|integer|gt:0',
            'designation'=>'required|integer|gt:0',
            'dateOfBirth'=>'required|string',
            'postalAddress'=>'required|string',
            'physicalAddress'=>'required|string',
        ],
        [
            'department.gt'=>'You must section Department',
            'designation.gt'=>'You must section Designation',
        ] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid )->withInput();
        }
        # END:: VALIDATION
        #START::Handle File Upload Registration Form
        if ( $request->hasFile( 'photoAttachment' ) ) {
            $filenameWithExt = $request->file( 'photoAttachment' )->getClientOriginalName();
            // Get just filename
            $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME );
            //Get just ext
            $extension = $request->file( 'photoAttachment' )->getClientOriginalExtension();
            // Create new Filename
            $newfilename = 'AVATAR_' . date( 'y' );
            // FileName to Store
            $userPhotoAttached = $newfilename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file( 'photoAttachment' )->storeAs( 'public/userAvatar', $userPhotoAttached );
        } else {
            $userPhotoAttached = 'NULL';
        }
        #END::Handle File Upload Registration Form

        $defaultPWD = strtoupper( $request->fname ).'-'.date( 'd-m-Y', strtotime( $request->dateOfBirth ) );
        // First Name in caps - dob in DD-MM-YY format eg MASUSULE-07-04-1988

        $registerUser = new User;
        $registerUser->old_id = 0;
        $registerUser->fname = $request->fname;
        $registerUser->mname = $request->mname;
        $registerUser->lname = $request->lname;
        $registerUser->gender = $request->gender;
        $registerUser->avatar = $userPhotoAttached;
        $registerUser->email = $request->email;
        $registerUser->phone = $request->phone;
        $registerUser->dob = date( 'Y-m-d', strtotime( $request->dateOfBirth ) );
        $registerUser->physical_address = $request->physicalAddress;
        $registerUser->postal_address = $request->postalAddress;
        $registerUser->department_id = $request->department;
        $registerUser->designation_id = $request->designation;
        $registerUser->password = Hash::make( $defaultPWD );
        $registerUser->password_status = 'DEFAULT';
        $registerUser->created_by = Auth::user()->id;

        if ( $registerUser->save() ) {

            //START:: send email to share credentials to user
            $mailData = [
                'subject'=>'Tumaini Pension Fund (TPF) - User Registration',
                'salutation' => 'Dear '. $registerUser->fname. ' '.$registerUser->mname.' '.$registerUser->lanme.',',
                'email_introduction' => 'You have been Successfully Registered on the Tumaini Pension Fund (TPF) Platform',
                'email_body' => 'This is to inform you that your System Access Password is '.$defaultPWD.', and the username is your official email.',
            ];

            // Mail::to( $registerUser->email )->send( new MailEngine( $mailData ) );
            //END:: send email to share credentials to user

            toastr();
            return redirect( 'users/list/'.Crypt::encryptString( 'ACTIVE' ) )->with( 'success', 'You have Successfully registered a new user' );

        }

        toastr();
        return redirect( 'users/add/' )->with( 'error', 'Something went wrong. Kindly, try again' );

    }

    public function viewUser($userID){
        $userID = Crypt::decryptString( $userID );
        $userData = User::find( $userID );
        return view('users.user_view', ['userData'=>$userData]);
    }

    public function editUser( $userID ) {
        $userID = Crypt::decryptString( $userID );
        $userData = User::find( $userID );
        $departmentData = Department::where( 'status', 'ACTIVE' )->get();
        $designations = Designation::where( 'status', 'ACTIVE' )->get();

        //START:: Katick file inpunt Data
        $fileInputArr = array();
        if ( $userData->avatar != 'NULL' ) {
            $fileInputArr[ 'filePath' ] = asset( 'storage/userAvatar' ). '/' . $userData->avatar;
            $fileInputArr[ 'finaleName' ] = $userData->avatar;
            $fileInputArr[ 'fileSize' ] = Storage::disk( 'public' )->size( 'userAvatar/' . $userData->avatar );
            ;
        } else {
            $fileInputArr[ 'filePath' ] = '';
            $fileInputArr[ 'finaleName' ] = '';
            $fileInputArr[ 'fileSize' ] = 0;
        }
        //END:: Katick file inpunt Data

        return view( 'users.user_edit', [ 'departmentData'=>$departmentData, 'designations'=>$designations, 'userData'=>$userData, 'fileInputArr'=>$fileInputArr ] );
    }

    public function submitEditUser( Request $request, $userID ) {
        # START:: VALIDATION
        $valid = Validator::make( $request->all(), [
            'fname'=>'required|string',
            'mname'=>'required|string',
            'lname'=>'required|string',
            'gender'=>'required|string',
            'phone'=>'required|string',
            'email'=>'required|email',
            'department'=>'required|integer|gt:0',
            'designation'=>'required|integer|gt:0',
            'dateOfBirth'=>'required|string',
            'postalAddress'=>'required|string',
            'physicalAddress'=>'required|string',
        ],
        [
            'department.gt'=>'You must select Department',
            'designation.gt'=>'You must select Designation',
        ] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid )->withInput();
        }
        # END:: VALIDATION
        #START::Handle File Upload Registration Form
        if ( $request->hasFile( 'photoAttachment' ) ) {
            $filenameWithExt = $request->file( 'photoAttachment' )->getClientOriginalName();
            // Get just filename
            $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME );
            //Get just ext
            $extension = $request->file( 'photoAttachment' )->getClientOriginalExtension();
            // Create new Filename
            $newfilename = 'AVATAR_' . date( 'y' );
            // FileName to Store
            $userPhotoAttached = $newfilename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file( 'photoAttachment' )->storeAs( 'public/userAvatar', $userPhotoAttached );
        } else {
            $userPhotoAttached = 'NULL';
        }
        #END::Handle File Upload Registration Form

        $updateUser = User::find( $userID );
        $updateUser->fname = $request->fname;
        $updateUser->mname = $request->mname;
        $updateUser->lname = $request->lname;
        $updateUser->gender = $request->gender;
        $updateUser->avatar = $userPhotoAttached;
        $updateUser->email = $request->email;
        $updateUser->phone = $request->phone;
        $updateUser->dob = date( 'Y-m-d', strtotime( $request->dateOfBirth ) );
        $updateUser->physical_address = $request->physicalAddress;
        $updateUser->postal_address = $request->postalAddress;
        $updateUser->department_id = $request->department;
        $updateUser->designation_id = $request->designation;
        $updateUser->updated_by = Auth::user()->id;

        if ( $updateUser->save() ) {

            //START:: send email to share credentials to user
            $mailData = [
                'subject'=>'Tumaini Pension Fund (TPF) - User Registration',
                'salutation' => 'Dear '. $updateUser->fname. ' '.$updateUser->mname.' '.$updateUser->lanme.',',
                'email_introduction' => 'You have been Successfully Updated on the Tumaini Pension Fund (TPF) Platform',
                'email_body' => 'This is to inform you that all your credentials are the same as before.',
            ];

            // Mail::to( $updateUser->email )->send( new MailEngine( $mailData ) );
            //END:: send email to share credentials to user

            toastr();
            return redirect( 'users/list/'.Crypt::encryptString( 'ACTIVE' ) )->with( 'success', 'You have Successfully Updated user' );
        }

        toastr();
        return redirect( 'users/add/' )->with( 'error', 'Something went wrong. Kindly, try again' );

    }

    public function departments( $status ) {
        $status = Crypt::decryptString( $status );
        $departmentData = Department::where( 'status', $status )->get();
        return view( 'users.user_departments', [ 'departmentData'=>$departmentData, 'status'=>$status ] );
    }

    public function submitNewDepartment( Request $request ) {
        # START:: VALIDATION
        $valid = Validator::make( $request->all(), [
            'name'=>'required|unique:departments,name',
        ] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid, 'addDepartment' )->withInput();
        }
        # END:: VALIDATION
        $departments = new Department;
        $departments->name = strtoupper( $request->name );
        $departments->status = 'ACTIVE';
        $departments->created_by = Auth::user()->id;
        $departments->updated_by = Auth::user()->id;
        if ( $departments->save() ) {
            toastr();
            return redirect( 'users/departments/'.Crypt::encryptString( 'ACTIVE' ) )->with( 'success', 'You have Successfully Added new Department' );
        }
        toastr();
        return redirect( 'users/departments/'.Crypt::encryptString( 'ACTIVE' ) )->with( 'error', 'Something went wrong, try again' );
    }

    public function ajaxGetDepartmentData( Request $request ) {
        $id = $request->data_id;
        $department = Department::find( $id );
        $departmentData = array();

        if ( $department ) {

            $departmentData = Department::where( 'id', $id )->first();
            $departmentData[ 'status' ] = 'success';
            $departmentData[ 'message' ] = 'Department Data has fetched';
            $departmentData[ 'data' ] = $department;
        } else {
            $departmentData[ 'status' ] = 'Errors';
            $departmentData[ 'message' ] = 'We could not find a Shipping Agent in our database, Select a Agent first';
        }
        return response()->json( [ 'departmentData'=>$departmentData ] );
    }

    public function submitEditDepartment( Request $request ) {
        # START:: VALIDATION
        $valid = Validator::make( $request->all(), [
            'deptID'=>'required',
            'department'=>'required',
        ] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid, 'editDepartment' )->withInput();
        }
        # END:: VALIDATION

        $departments = Department::find( $request->deptID );
        $departments->name = strtoupper( $request->department );
        $departments->status = 'ACTIVE';
        $departments->updated_by = Auth::user()->id;
        if ( $departments->save() ) {
            toastr();
            return redirect( 'users/departments/'.Crypt::encryptString( 'ACTIVE' ) )->with( 'success', 'You have Successfully Updated a Department' );
        }
        toastr();
        return redirect( 'users/departments/'.Crypt::encryptString( 'ACTIVE' ) )->with( 'error', 'Something went wrong, try again' );
    }

    public function ajaxChangeDepartmentStatus( Request $request ) {
        $id = $request->data_id;
        $status = $request->new_status;

        #CHECK cover type and change status
        $departmentchangestatusArr = array();

        $department = Department::find( $id );
        if ( $department ) {
            if ( $status == 'Deactivate' ) {
                $newStatus = 'INACTIVE';
            }
            if ( $status == 'Activate' ) {
                $newStatus = 'ACTIVE';
            }

            $DepartmentFound = Department::find( $id );
            $DepartmentFound->status = $newStatus;
            $DepartmentFound->save();

            $departmentchangestatusArr[ 'status' ] = 'success';
            $departmentchangestatusArr[ 'message' ] = 'Department has Successfully '.$status.'d';
        } else {
            $departmentchangestatusArr[ 'status' ] = 'Errors';
            $departmentchangestatusArr[ 'message' ] = 'We could not find this Department, Select a Department on the list to change status';
        }

        return response()->json( [ 'departmentchangestatusArr'=>$departmentchangestatusArr ] );
    }

    public function designations($status){
        $status = Crypt::decryptString( $status );
        $designationsData = Designation::where( 'status', $status )->get();
        $departmentData = Department::where( 'status', 'ACTIVE' )->get();
        return view( 'users.user_designations', [ 'departmentData'=>$departmentData,'designationsData'=>$designationsData, 'status'=>$status ] );
    }
    public function submitNewDesignation( Request $request ) {
        # START:: VALIDATION
        $valid = Validator::make( $request->all(), [
            'department' =>[ 'required', 'integer','gt:0' ],
            'designation'=>[ 'required', 'string' ],
        ],[
          'department:gt'=>'You must Select a Department',  
        ] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid, 'addDesignation' )->withInput();
        }
        # END:: VALIDATION

        $checkData = Designation::where( 'department_id', $request->department )->where( 'name', $request->designation )->count();
        if ( $checkData>0 ) {
            return back()->with( [ 'fail'=>'Designation exists in the Department' ] );
        }

        $Designation = new Designation;
        $Designation->department_id = $request->department;
        $Designation->name = strtoupper( $request->designation );
        $Designation->status = 'ACTIVE';
        $Designation->created_by = Auth::user()->id;
        $Designation->updated_by = Auth::user()->id;
        $Designation->save();

        return back()->with( [ 'success'=>'You have successfully registered a new Designation' ] );
    }

    public function ajaxGetDesignationData( Request $request ) {
        $id          = $request->data_id;
        $designation = Designation::find( $id );
        $allDept     = Department::where( 'status', 'ACTIVE' )->get();
        $designationData = array();

        if ( $designation ) {

            $originDesignation = Designation::where( 'id', $id )->first();
            $department = Department::where( 'id', $designation->department_id )->get();
            // Department Data
            $designationData[ 'status' ] = 'success';
            $designationData[ 'message' ] = 'Department has Successfully fetched';
            $designationData[ 'data_allDept' ] = $allDept;
            $designationData[ 'data_designation' ] = $originDesignation;
        } else {
            $designationData[ 'status' ] = 'Errors';
            $designationData[ 'message' ] = 'We could not find a Shipping Agent in our database, Select a Agent first';
        }
        return response()->json( [ 'designationData'=>$designationData ] );
    }

    public function submitEditDesignation( Request $request ) {
        # START:: VALIDATION
        $valid = Validator::make( $request->all(), [
            'department' =>[ 'required', 'integer' ],
            'designation'=>[ 'required', 'string' ],
            'deptID'     =>[ 'required' ],
        ] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid, 'editDesignation' )->withInput();
        }
        # END:: VALIDATION

        $Designation = Designation::find( $request->deptID );
        $Designation->department_id = $request->department;
        $Designation->name = $request->designation;
        $Designation->status = 'ACTIVE';
        $Designation->created_by = Auth::user()->id;
        $Designation->updated_by = Auth::user()->id;
        $Designation->save();

        return back()->with( [ 'success'=>'You have Successfully Update a Designation' ] );
    }

    public function ajaxChangeDesignationStatus( Request $request ) {
        $id = $request->data_id;
        $status = $request->new_status;

        #CHECK cover type and change status
        $designationchangestatus = array();

        $designation = Designation::find( $id );
        if ( $designation ) {
            if ( $status == 'Deactivate' ) {
                $newStatus = 'INACTIVE';
            }
            if ( $status == 'Activate' ) {

                $newStatus = 'ACTIVE';
            }

            $DesignationFound = Designation::find( $id );
            $DesignationFound->status = $newStatus;
            $DesignationFound->updated_by = Auth::user()->id;
            $DesignationFound->save();

            $designationchangestatus[ 'status' ] = 'success';
            $designationchangestatus[ 'message' ] = 'Designation has Successfully '.$status.'d';
        } else {
            $designationchangestatus[ 'status' ] = 'Errors';
            $designationchangestatus[ 'message' ] = 'We could not find a Designation in our database, Select a Designation on the list to change status';
        }

        return response()->json( [ 'designationchangestatus'=>$designationchangestatus ] );
    }
}

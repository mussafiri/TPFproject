<?php

namespace App\Http\Controllers;

use App\Lib\Common;
use App\Models\Contributor;
use App\Models\ContributorType;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class ContributorController extends Controller {

    public function contributorsCategory($status) {
        $status=Crypt::decryptString($status);
        $contrCateg = ContributorType::where('status',$status)->get();
        return view( 'contributor.contributor_categories', [ 'contrCateg'=>$contrCateg, 'status'=>$status ] );
    }

    public function ajaxUpdateContributorsCategoryStatus(Request $request){
        #Taking all POST requests from the form
        $valid = Validator::make($request->all(), [
            'data_id' => 'required',
            'new_status' => 'required'
        ]);

        if ($valid->fails()) {
            return back()->withErrors($valid)->withInput();
        }
        
        $new_status = $request->new_status == 'Suspend' ? 'SUSPENDED' : 'ACTIVE';
        $new_message = $request->new_status == 'Suspend' ? 'Suspended' : 'Activated';

        $contributorCategArr = array();
    
        $getContributorCateg = ContributorType::find($request->data_id);
        if ($getContributorCateg) {
            $updateContributorType = ContributorType::find($request->data_id);
            $updateContributorType->status = $new_status;
            $updateContributorType->updated_by = Auth::user()->id;
            $updateContributorType->save();

            $contributorCategArr['status'] = 'success';
            $contributorCategArr['message'] = 'Contributors Category has been Successfully &nbsp;' . $new_message;
        } else {
            $contributorCategArr['status'] = 'Errors';
            $contributorCategArr['message'] = 'We could not find such Contributors Category in our database!';
        }

        return response()->json(['contributorCategArr' => $contributorCategArr]);  
    }

    public function submitNewContributorsCategory( Request $request ) {
        # START:: VALIDATION
        $valid = Validator::make( $request->all(), [
            'name' =>[ 'required', 'string' ],
        ] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid, 'addContrCategory' )->withInput();
        }
        # END:: VALIDATION

        $addContributorType = new ContributorType;
        $addContributorType->name = strtoupper( $request->name );
        $addContributorType->created_by = Auth::user()->id;
        $addContributorType->save();

        return redirect( 'contributor/categories/'.Crypt::encryptString('ACTIVE') )->with( [ 'success'=>'You have Successfully added new Contributor Category' ] );
    }

    public function ajaxGetContributorsCategory( Request $request ) {

        $getCatData = ContributorType::find( $request->data_id );
        $categoryDataArr = array();

        if ( $getCatData ) {
            $categoryDataArr[ 'code' ] = 201;
            $categoryDataArr[ 'status' ] = 'success';
            $categoryDataArr[ 'data' ] = $getCatData;
        } else {

            $categoryDataArr[ 'code' ] = 403;
            $categoryDataArr[ 'status' ] = 'fail';
            $categoryDataArr[ 'message' ] = 'No Data Found';
        }

        return response()->json( [ 'categoryDataArr'=>$categoryDataArr ] );
    }

    public function submitEditContributorsCategory( Request $request ) {
        # START:: VALIDATION
        $valid = Validator::make( $request->all(), [
            'name' =>[ 'required', 'string' ],
            'data_id' =>[ 'required', 'integer' ],
        ] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid, 'editContrCategory' )->withInput();
        }
        # END:: VALIDATION

        $addContributorType = ContributorType::find( $request->data_id );
        $addContributorType->name = strtoupper( $request->name );
        $addContributorType->updated_by = Auth::user()->id;
        if($addContributorType->save()){
            toastr();
            return redirect( 'contributor/categories/'.Crypt::encryptString('ACTIVE') )->with('success','You have Successfully Updated a Contributor Category');
        }else{
            toastr();
            return redirect( 'contributor/categories/'.Crypt::encryptString('ACTIVE') )->with('error','Something went wrong, redo the process');
        }

    }

    public function contributors() {
        $contributors = Contributor::limit( 50 )->get();
        return view( 'contributor.contributors', [ 'contributors'=>$contributors ] );
    }

    public function addContributors() {
        $contrTypes = ContributorType::where( 'status', 'ACTIVE' )->get();
        $sections = Section::where( 'status', 'ACTIVE' )->get();

        return view( 'contributor.contributor_add', [ 'contrTypes'=>$contrTypes, 'sections'=>$sections ] );
    }

    public function ajaxGetSectionData( Request $request ) {
        $getSectionData = Section::find( $request->section_id );

        $sectionDataArr = array();
        if ( $getSectionData ) {
            $sectionDataArr[ 'code' ] = 201;
            $sectionDataArr[ 'district' ] = $getSectionData->district->name;
            $sectionDataArr[ 'zone' ] = $getSectionData->district->zone->name;
        } else {
            $sectionDataArr[ 'code' ] = 403;
            $sectionDataArr[ 'district_message' ] = 'District not found';
            $sectionDataArr[ 'zone_message' ] = 'Zone not found';
        }

        return response()->json( [ 'sectionDataArr'=>$sectionDataArr ] );

    }

    public function SubmitAddContributor( Request $request ) {
        # START:: VALIDATION
        $rules = [
            'name' =>'required|string|unique:contributors,name',
            'contributorType' =>'required|integer|gt:0',
            'section' => 'required|integer|gt:0',
            'postalAddress' => 'required',
            'physicalAddress' => 'required',
            'phone' => 'required|unique:contributors,phone',
            'email' => 'email|required|unique:contributors,email',
            'regFormAttachment' => 'required'
        ];
    
        $customMessages = [
            'contributorType.gt:0' => 'You must select Contributor Type',
            'section.gt:0' => 'Your must select Section',
        ];
    
        $this->validate($request, $rules, $customMessages);
        # END:: VALIDATION
        $cmn= new Common;

        #START::Handle File Upload Registration Form
        if ( $request->hasFile( 'regFormAttachment' ) ) {
            $filenameWithExt = $request->file( 'regFormAttachment' )->getClientOriginalName();
            // Get just filename
            $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME );
            //Get just ext
            $extension = $request->file( 'regFormAttachment' )->getClientOriginalExtension();
            // Create new Filename
            $newfilename = 'REGFRM_' . date( 'y' );
            // FileName to Store
            $fileNameToStore = $newfilename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file( 'regFormAttachment' )->storeAs( 'public/contributorRegfrms', $fileNameToStore );
        } else {
            $fileNameToStore = 'NULL';
        }
        #END::Handle File Upload Registration Form

        $addNewContributor = new Contributor;
        $addNewContributor->section_id = $request->section;
        $addNewContributor->contributor_code = 'NULL';
        $addNewContributor->name = $request->name;
        $addNewContributor->contributor_type_id = $request->contributorType;
        $addNewContributor->postal_address = $request->postalAddress;
        $addNewContributor->physical_address = $request->physicalAddress;
        $addNewContributor->phone = $request->phone;
        $addNewContributor->email=$request->email;
        $addNewContributor->status = 'ACTIVE';
        $addNewContributor->reg_form = $fileNameToStore;
        $addNewContributor->created_by = Auth::user()->id;

        //END::put contributor code

        if ( $addNewContributor->save() ) {
            $cmn -> contributorCodeGenerator($addNewContributor->id);

            toastr()->success('Contributor Successfully Added!');

            return redirect( 'contributors' );
        }

        toastr()->error('Opps! there was a problem to add Contributor, please try again later.');

        return redirect('add/contributor');
    }
}

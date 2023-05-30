<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use App\Models\ContributorType;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContributorController extends Controller {

    public function contributorsCategory() {
        $contrCateg = ContributorType::all();
        return view( 'contributor.contributors_category', [ 'contrCateg'=>$contrCateg ] );
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

        return redirect( 'contributors/category' )->with( [ 'success'=>'You have Successfully added new Contributor Category' ] );
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
        $addContributorType->save();

        return redirect( 'contributors/category' )->with( [ 'success'=>'You have Successfully Updated a Contributor Category' ] );

    }

    public function changeContributorsCategoryStatus( Request $request ) {
        if ( $request->new_status == 'suspend' ) {
            $new_status = 'SUSPEND';
            $statusText = 'Suspended';
        } else {
            $new_status = 'ACTIVE';
            $statusText = 'Activated';
        }

        $dataChangeStatusArr = array();

        $checkCategory = ContributorType::find( $request->data_id );
        if ( $checkCategory ) {
            $updateCategory = ContributorType::find( $request->data_id );
            $updateCategory->status = $new_status;
            $updateCategory->updated_by = Auth::user()->id;
            $updateCategory->save();

            $dataChangeStatusArr[ 'status' ] = 'success';
            $dataChangeStatusArr[ 'message' ] = 'Contributor Category has Successfully '.$statusText;
        } else {
            $dataChangeStatusArr[ 'status' ] = 'Errors';
            $dataChangeStatusArr[ 'message' ] = 'We could not find a Contributor Category in our database, Select a Contributor Category on the list to change status';
        }

        return response()->json( [ 'dataChangeStatusArr'=>$dataChangeStatusArr ] );
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

    public function SubmitAddContributor( Request $request ) {
        # START:: VALIDATION
        $valid = Validator::make( $request->all(), [
            'name' =>[ 'required', 'string' ],
            'contributorType' =>[ 'required', 'integer' ],
            'section' => 'required',
            'postalAddress' => 'required',
            'physicalAddress' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'regFormAttachment' => 'required'

        ] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid, 'editContrCategory' )->withInput();
        }
        # END:: VALIDATION

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
            $path = $request->file( 'regFormAttachment' )->storeAs( 'public/contributorRegfrm', $fileNameToStore );
        } else {
            $fileNameToStore = 'NULL';
        }
        #END::Handle File Upload Registration Form

        $addNewContributor = new Contributor;
        $addNewContributor->section_id = $request->section;
        $addNewContributor->contributor_code = $request->name;
        $addNewContributor->name = $request->name;
        $addNewContributor->contributor_type_id = $request->contributorType;
        $addNewContributor->postal_address = $request->postalAddress;
        $addNewContributor->physical_address = $request->physicalAddress;
        $addNewContributor->phone = $request->phone;
        $addNewContributor->email-$request->email;
        $addNewContributor->status = 'ACTIVE';
        $addNewContributor->reg_form = $fileNameToStore;
        $addNewContributor->created_by = Auth::user()->id;
        $addNewContributor->save();

        if ( $addNewContributor instanceof Model ) {
            toastr()->success( 'Data has been saved successfully!' );

            return redirect()->route( 'posts.index' );
        }

        toastr()->error( 'An error has occurred please try again later.' );

        return back();

        return redirect()->route( 'contributor.contributors' )->with( 'success', 'Contributor Successfully Added' );
    }
}

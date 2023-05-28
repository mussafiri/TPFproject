<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use App\Models\ContributorType;
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
        dd( $request->new_status );
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
        $contributors = Contributor::all();
        return view( 'contributor.contributors', [ 'contributors'=>$contributors ] );
    }
}

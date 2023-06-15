<?php

namespace App\Http\Controllers;

use App\Models\ConstantValue;
use App\Models\Scheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller {

    public function constantValues() {
        $constantValues = ConstantValue::all();
        return view( 'settings.constant_values', [ 'constantValues'=>$constantValues ] );
    }

    public function ajaxGetConstantValueData( Request $request ) {
        $id          = $request->data_id;
        $consantValueData = ConstantValue::find( $id );
        $consantValueDataArr = array();

        if ( $consantValueData ) {
            $consantValueDataArr[ 'status' ] = 'success';
            $consantValueDataArr[ 'message' ] = 'Department has Successfully fetched';
            $consantValueDataArr[ 'data' ] = $consantValueData;

        } else {

            $consantValueDataArr[ 'status' ] = 'Errors';
            $consantValueDataArr[ 'message' ] = 'We could not find a Shipping Agent in our database, Select a Agent first';
        }

        return response()->json( [ 'consantValueDataArr'=>$consantValueDataArr ] );
    }

    public function submitConstantValues( Request $request ) {
        # START:: VALIDATION
        $valid = Validator::make( $request->all(), [
            'consantValue'      =>'required',
            'data_id'           =>'required|integer',
        ] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid )->withInput();
        }
        # END:: VALIDATION

        $updateConstantValue = ConstantValue::find( $request->data_id );
        $updateConstantValue->consantValue = $request->consantValue;
        if ( $updateConstantValue->save() ) {
            toastr();
            return redirect( 'configs/constantvalues' )->with( 'success', 'You have Successfully updates a Constant Value' );
        }
        toastr();
        return redirect( 'configs/constantvalues' )->with( 'error', 'Something went wrong, try again' );
    }

    public function schemes() {
        $schemeData = Scheme::all();
        return view( 'settings.schemes', [ 'schemeData'=>$schemeData ] );
    }
}

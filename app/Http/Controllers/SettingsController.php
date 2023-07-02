<?php

namespace App\Http\Controllers;

use App\Models\ArrearRecognition;
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
            $responseStatus='success';
            $responseText= 'You have Successfully updates a Constant Value';
        }else{
            $responseStatus='error';
            $responseText= 'Something went wrong, try again';
        }

        toastr();
        return redirect( 'configs/constantvalues' )->with( [$responseStatus=>$responseText] );
    }

    public function schemes() {
        $schemeData = Scheme::all();
        return view( 'settings.schemes', compact( 'schemeData') );
    }

    public function arrearsRecognition(){
        $arrearData = ArrearRecognition::all();
        return view( 'settings.arrear_structure', compact('arrearData'));
    }

    public function submitArrearsRecognitionEdit(Request $request){
         # START:: VALIDATION
         $valid = Validator::make( $request->all(), [
            'gracePeriod' =>'required|gt:0',
            'data_id'     =>'required|integer',
         ],['gracePeriod'=>'Enter value greater than Zero'] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid )->withInput();
        }
        # END:: VALIDATION

        $arrearsData = ArrearRecognition::find($request->data_id);
        $arrearsData->grace_period_days = $request->gracePeriod;
        
        if($arrearsData->save()){
            $responseStatus='success';
            $responseText= 'You have Successfully updated an Arrear Structure';
        }else{
            $responseStatus='error';
            $responseText= 'There is something wrong';
        }

        toastr();

        return redirect('configs/arrears/recognition')->with([$responseStatus => $responseText]);
    }
    public function ajaxGetArrearData(Request $request){
        $getData = ArrearRecognition::find($request->data_id);

        $arrearDataArr= array();
        if($getData){
            $arrearDataArr['status'] = 'success';
            $arrearDataArr['grace_period_days'] = $getData->grace_period_days;
        }else{
            $arrearDataArr['status'] = 'failure';
            $arrearDataArr['message'] = 'Data not found';
        }
        
        return response()->json(['arrearDataArr'=>$arrearDataArr]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Arrear;
use App\Models\ArrearDetail;
use App\Models\ContributorMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class ArrearsController extends Controller
{
    public function contributionArrears($status){
        $status = Crypt::decryptString($status);
        $arrears= Arrear::where('processing_status',$status)->get();

        return view('arrears.arrears', compact('arrears', 'status'));
    }

    public function arrearsView($arearID){
        $arearID   = Crypt::decryptString($arearID);
        $arrearDetails = Arrear::find($arearID);
        
        
        if($arrearDetails->status =='ACTIVE' || $arrearDetails->status=='ON PAYMENT'){ 
            $arrearPeriod = ($arrearDetails->status =='ACTIVE')? date('Y-m-d'): date('Y-m-d', strtotime($arrearDetails->closed_at));
        }else{ 
            $arrearPeriod = ($arrearDetails->status =='SUSPENDED')? date('Y-m-d', strtotime($arrearDetails->suspended_at)): date('Y-m-d', strtotime($arrearDetails->closed_at));
        }
        
        $arearDetails = ArrearDetail::where('arrear_id',$arrearDetails->id)->get();
        return view('arrears.arrears_view', compact('arrearDetails', 'arearDetails','arrearPeriod'));
    }

    public function arrearsProcessing($arearID){
        $arearID   = Crypt::decryptString($arearID);
        $arrearDetails = Arrear::find($arearID);
        
        
        if($arrearDetails->status =='ACTIVE' || $arrearDetails->status=='ON PAYMENT'){ 
            $arrearPeriod = ($arrearDetails->status =='ACTIVE')? date('Y-m-d'): date('Y-m-d', strtotime($arrearDetails->closed_at));
        }else{ 
            $arrearPeriod = ($arrearDetails->status =='SUSPENDED')? date('Y-m-d', strtotime($arrearDetails->suspended_at)): date('Y-m-d', strtotime($arrearDetails->closed_at));
        }
        
        $arearDetails = ArrearDetail::where('arrear_id',$arrearDetails->id)->get();

        return view('arrears.arrears_processing', compact('arrearDetails', 'arearDetails','arrearPeriod'));
    }

    public function submitBulkArrearsWaive(Request $request){
         # START:: VALIDATION
         $valid = Validator::make( $request->all(), [
            'sectionArrear'     =>'required|array|min:1',
         ],['sectionArrear.required' =>'You must select at least on Arrear to Waive',
            'sectionArrear.min' =>'You must select at least on Arrear to Waive'] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid, 'suspendBulkArrears' )->withInput();
        }
        # END:: VALIDATION
        $sectionArrear = $request->sectionArrear;

        for($aa=0; $aa< count($sectionArrear); $aa++){
            //Start:: Arrear Update
            $getArrrear = Arrear::find($sectionArrear[$aa]);
            $getArrrear->status             = 'SUSPENDED';
            $getArrrear->processing_status  = 'PENDING';
            $getArrrear->suspended_by       = Auth::user()->id;
            $getArrrear->suspended_at       = date('Y-m-d H:i:s');
            $getArrrear->save();
            //End:: Arrear Update

            //Start:: Arrear Detail Update
            $getMemberArrear = ArrearDetail::where('arrear_id',$sectionArrear[$aa])->get();
            if($getMemberArrear->count() > 0){
                foreach($getMemberArrear as $data){
                    $updateArrearDetail = ArrearDetail::find($data->id);
                    $updateArrearDetail->status ='SUSPENDED';
                    $updateArrearDetail->processing_status ='PENDING';
                    $updateArrearDetail->suspended_by = Auth::user()->id;
                    $updateArrearDetail->suspended_at = date('Y-m-d H:i:s');
                    $updateArrearDetail->save();
                }
            }
            //End:: Arrear Detail Update

        }

        toastr();

        return redirect('contributions/arrears/'.Crypt::encryptString('ACTIVE'))->with(['success' => 'You have Successfully Submitted Arrear Waive Request']);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Arrear;
use App\Models\ArrearDetail;
use App\Models\ContributorMember;
use App\Models\PaymentMode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class ArrearsController extends Controller
{
    public function contributionArrears($status){
        $status = Crypt::decryptString($status);
        $arrears= Arrear::where('processing_status',$status)->get();

        $paymentMode= PaymentMode::where('status','ACTIVE')->get();

        return view('arrears.arrears', compact('arrears', 'paymentMode', 'status'));
    }

    public function arrearsView($arearID){
        $arearID       = Crypt::decryptString($arearID);
        $arrearDetails = Arrear::find($arearID);
        
        
        if($arrearDetails->status =='ACTIVE' || $arrearDetails->status=='ON PAYMENT'){ 
            $arrearPeriod = ($arrearDetails->status =='ACTIVE')? date('Y-m-d'): date('Y-m-d', strtotime($arrearDetails->closed_at));
        }else{ 
            $arrearPeriod = ($arrearDetails->status =='SUSPENDED')? date('Y-m-d', strtotime($arrearDetails->suspended_at)): date('Y-m-d', strtotime($arrearDetails->closed_at));
        }
        
        $arrearDetailsData = ArrearDetail::where('arrear_id',$arrearDetails->id)->get();
        return view('arrears.arrears_view', compact('arrearDetails', 'arrearDetailsData','arrearPeriod'));
    }

    public function arrearsProcessing($action, $arearID){
        $action        = Crypt::decryptString($action);
        $arearID       = Crypt::decryptString($arearID);
        $arrearDetails = Arrear::find($arearID);
        
        $paymentMode= PaymentMode::where('status','ACTIVE')->get();

        if($arrearDetails->status =='ACTIVE' || $arrearDetails->status=='ON PAYMENT'){ 
            $arrearPeriod = ($arrearDetails->status =='ACTIVE')? date('Y-m-d'): date('Y-m-d', strtotime($arrearDetails->closed_at));
        }else{ 
            $arrearPeriod = ($arrearDetails->status =='SUSPENDED')? date('Y-m-d', strtotime($arrearDetails->suspended_at)): date('Y-m-d', strtotime($arrearDetails->closed_at));
        }
        
        $arrearDetailsData = ArrearDetail::where('arrear_id',$arrearDetails->id)->get();

        return view('arrears.arrears_processing', compact('arrearDetails', 'arrearDetailsData','arrearPeriod','paymentMode','action'));
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


    public function submitMemberArrearsPenaltyWaive(Request $request){
         # START:: VALIDATION
         $valid = Validator::make( $request->all(), [
            'selectedMembers'     =>'required|array|min:1',
         ],['selectedMembers.required' =>'You must select at least on Member to Waive',
            'selectedMembers.min' =>'You must select at least on Member to Waive'] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid, 'memberArrearPenaltyWaive' )->withInput();
        }
        # END:: VALIDATION
        $selectedMembers = $request->selectedMembers;
        $selectedMembersCount = count($selectedMembers);
        $processType = ($request->totalMembers == $selectedMembersCount)?'GROUP':'INDIVIDUAl';

        for($aa=0; $aa< $selectedMembersCount; $aa++){
            //Start:: Arrear Detail Update
                $updateArrearDetail = ArrearDetail::find($selectedMembers[$aa]);
                $updateArrearDetail->status            = 'SUSPENDED';
                $updateArrearDetail->processing_status = 'PENDING';
                $updateArrearDetail->processing_type   = $processType;
                $updateArrearDetail->suspended_by      = Auth::user()->id;
                $updateArrearDetail->suspended_at      = date('Y-m-d H:i:s');
                $updateArrearDetail->save();
            //End:: Arrear Detail Update
        }

        toastr();

        return redirect('contributions/arrears/'.Crypt::encryptString('ACTIVE'))->with(['success' => 'You have Successfully Submitted Member Arrear Penalty Waive Request']);
    }



}

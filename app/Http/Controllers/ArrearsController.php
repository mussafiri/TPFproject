<?php

namespace App\Http\Controllers;

use App\Models\ArrearPenaltyPayment;
use App\Models\Contributor;
use App\Models\Arrear;
use App\Models\ArrearDetail;
use App\Models\ContributorMember;
use App\Models\PaymentMode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class ArrearsController extends Controller {
    public function contributionArrears( $status ) {
        $status = Crypt::decryptString( $status );
        $arrears = Arrear::where( 'processing_status', $status )->get();

        $paymentMode = PaymentMode::where( 'status', 'ACTIVE' )->get();

        return view( 'arrears.arrears', compact( 'arrears', 'paymentMode', 'status' ) );
    }

    public function arrearsView( $arearID ) {
        $arearID       = Crypt::decryptString( $arearID );
        $arrearDetails = Arrear::find( $arearID );

        if ( $arrearDetails->status == 'ACTIVE' || $arrearDetails->status == 'ON PAYMENT' ) {
            $arrearPeriod = ( $arrearDetails->status == 'ACTIVE' )? date( 'Y-m-d' ): date( 'Y-m-d', strtotime( $arrearDetails->closed_at ) );
        } else {
            $arrearPeriod = ( $arrearDetails->status == 'SUSPENDED' )? date( 'Y-m-d', strtotime( $arrearDetails->suspended_at ) ): date( 'Y-m-d', strtotime( $arrearDetails->closed_at ) );
        }

        $arrearDetailsData = ArrearDetail::where( 'arrear_id', $arrearDetails->id )->get();
        return view( 'arrears.arrears_view', compact( 'arrearDetails', 'arrearDetailsData', 'arrearPeriod' ) );
    }

    public function arrearsProcessing( $action, $arearID ) {
        $action        = Crypt::decryptString( $action );
        $arearID       = Crypt::decryptString( $arearID );
      
        $arrearDetails = Arrear::find( $arearID );
        $totalMember   = $arrearDetails->totalMembers($arrearDetails->section_id);

        $paymentMode = PaymentMode::where( 'status', 'ACTIVE' )->get();

        if ( $arrearDetails->status == 'ACTIVE' || $arrearDetails->status == 'ON PAYMENT' ) {
            $arrearPeriod = ( $arrearDetails->status == 'ACTIVE' )? date( 'Y-m-d' ): date( 'Y-m-d', strtotime( $arrearDetails->closed_at ) );
        } else {
            $arrearPeriod = ( $arrearDetails->status == 'SUSPENDED' )? date( 'Y-m-d', strtotime( $arrearDetails->suspended_at ) ): date( 'Y-m-d', strtotime( $arrearDetails->closed_at ) );
        }

        $arrearDetailsData = ArrearDetail::where( 'arrear_id', $arrearDetails->id )->get();

        return view( 'arrears.arrears_processing', compact( 'arrearDetails', 'arrearDetailsData', 'arrearPeriod', 'paymentMode', 'totalMember', 'action' ) );

    }

    public function submitBulkArrearsWaive( Request $request ) {
        # START:: VALIDATION
        $valid = Validator::make( $request->all(), [
            'sectionArrear'     =>'required|array|min:1',
        ],
        [ 'sectionArrear.required' =>'You must select at least on Arrear to Waive',
        'sectionArrear.min' =>'You must select at least on Arrear to Waive' ] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid, 'suspendBulkArrears' )->withInput();
        }
        # END:: VALIDATION
        $sectionArrear = $request->sectionArrear;



        for ( $aa = 0; $aa< count( $sectionArrear );
        $aa++ ) {
            //start:: Arrear Update
            $getArrear = Arrear::find( $sectionArrear[ $aa ] );
            $getArrear->status            = 'SUSPENDED';
            $getArrear->processing_status = 'PENDING';
            $getArrear->suspended_by      = Auth::user()->id;
            $getArrear->suspended_at      = date('Y-m-d H:i:s');
            $getArrear->save();
            //end:: Arrear Update

            //Start:: Arrear Detail Update
            $getMemberArrear = ArrearDetail::where( 'arrear_id', $sectionArrear[ $aa ] )->get();
            if ( $getMemberArrear->count() > 0 ) {
                foreach ( $getMemberArrear as $data ) {
                    $updateArrearDetail = ArrearDetail::find( $data->id );
                    $updateArrearDetail->status = 'SUSPENDED';
                    $updateArrearDetail->processing_status = 'PENDING';
                    $updateArrearDetail->processing_type = 'GROUP';
                    $updateArrearDetail->suspended_by = Auth::user()->id;
                    $updateArrearDetail->suspended_at = date( 'Y-m-d H:i:s' );
                    $updateArrearDetail->save();
                }
            }
            //End:: Arrear Detail Update
        }

        toastr();

        return redirect( 'arrears/sectionarrears/'.Crypt::encryptString('ACTIVE') )->with( [ 'success' => 'You have Successfully Submitted Arrear Waive Request' ] );
    }

    public function submitMemberArrearsPenaltyWaive( Request $request ) {
        # START:: VALIDATION
        $valid = Validator::make( $request->all(), [
            'arrearID'     =>'required',
            'totalMembers'     =>'required',
            'selectedMembers'  =>'required|array|min:1',
        ],
        [ 'selectedMembers.required' =>'You must select at least on Member to Waive',
          'selectedMembers.min'      =>'You must select at least on Member to Waive' ] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid, 'memberArrearPenaltyWaive' )->withInput();
        }
        # END:: VALIDATION
        $selectedMembers = $request->selectedMembers;
        $selectedMembersCount = count( $selectedMembers );

        $processType = ( $request->totalMembers == $selectedMembersCount )?'GROUP':'INDIVIDUAl';

        for ( $aa = 0; $aa< $selectedMembersCount; $aa++ ) {
            //Start:: Arrear Detail Update
            $updateArrearDetail = ArrearDetail::find( $selectedMembers[ $aa ] );
            $updateArrearDetail->status            = 'SUSPENDED';
            $updateArrearDetail->processing_status = 'PENDING';
            $updateArrearDetail->processing_type   = $processType;
            $updateArrearDetail->suspended_by      = Auth::user()->id;
            $updateArrearDetail->suspended_at      = date( 'Y-m-d H:i:s' );
            $updateArrearDetail->save();
            //End:: Arrear Detail Update
        }

        //Start:: Arrear Update
        if ( $processType == 'GROUP' ) {
            $getArrear = Arrear::find( $request->arrearID );
            $getArrear->status = 'SUSPENDED';

            if($getArrear->status =='ACTIVE' || $getArrear->status=='ON PAYMENT'){
                $arrearPeriod = ($getArrear->status =='ACTIVE')? date('Y-m-d'): date('Y-m-d', strtotime($getArrear->closed_at));
            }else{
                $arrearPeriod = ($getArrear->status =='SUSPENDED')? date('Y-m-d', strtotime($getArrear->suspended_at)): date('Y-m-d', strtotime($getArrear->closed_at));
            }

            $totalSectionContribution = $getArrear->arrearTotalContributionExpected($getArrear->section_id, $getArrear->arrear_period);

            $totalPenalty = $getArrear->arrearTotalPenaltyExpected($totalSectionContribution, $getArrear->id, $arrearPeriod);
            $penaltyPaid  = $getArrear->sectionPenatyPaid($getArrear->id, $getArrear->section_id);

            //Start::payment cumputations
            $refund = 0;
            $penaltyBalance = 0;
            if($penaltyPaid >= $totalPenalty ){
                $refund = $penaltyPaid - $totalPenalty;
            }else{
                $penaltyBalance = $totalPenalty - $penaltyPaid;
            }
            //End::payment cumputations

            $getArrear->penalty_amount     = $penaltyBalance;
            $getArrear->processing_status  = 'PENDING';
            $getArrear->suspended_by       = Auth::user()->id;
            $getArrear->suspended_at       = date( 'Y-m-d H:i:s' );
            $getArrear->save();
        }
        //End:: Arrear Update



        toastr();

        return redirect( 'arrears/sectionarrears/'.Crypt::encryptString('ACTIVE') )->with( [ 'success' => 'You have Successfully Submitted Member Arrear Penalty Waive Request' ] );
    }

    public function paySectionArrearPenalty( $arearID ) {
        $arearID    = Crypt::decryptString( $arearID );
        $paymentMode = PaymentMode::where( 'status', 'ACTIVE' )->get();

        $arrearData = Arrear::find( $arearID )->first();

        $countContributors = Contributor::where( 'section_id', $arrearData->section_id )->count();

        $totalMembers = Contributor::join( 'members', 'members.contributor_id', '=', 'contributors.id' )
        ->where( 'contributors.section_id', $arrearData->section_id )
        ->count();

        return view( 'arrears.arrears_section_penaltypay', compact( 'arrearData', 'countContributors', 'totalMembers', 'paymentMode' ) );
    }

    public function submitSectionArrearPenaltyPay( Request $request, $arrearID ) {
        $valid = Validator::make( $request->all(), [
            'arrearPenalty'        => 'required',
            'paymentDate'          => 'required',
            'paymentMode'          => 'required',
            'transactionReference' => 'required',
        ] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid )->withInput();
        }

        //Start:: Get Payment Proof
        if ( $request->hasFile( 'transactionProof' ) ) {
            $filenameWithExt = $request->file( 'transactionProof' )->getClientOriginalName();
            // Get just filename
            $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME );
            //Get just ext
            $extension = $request->file( 'transactionProof' )->getClientOriginalExtension();
            // Create new Filename
            $newfilename = 'PENALTY_' . date( 'y' );
            // FileName to Store
            $payment_proof = $newfilename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file( 'transactionProof' )->storeAs( 'public/penaltyPaymentProof', $payment_proof );
        } else {
            $payment_proof = 'NULL';
        }
        //End:: Get Payment Proof
        $arrearData = Arrear::find( $arrearID );

        $penaltyPayment = new ArrearPenaltyPayment;
        $penaltyPayment->arrear_id          = $arrearData->id;
        $penaltyPayment->section_id         = $arrearData->section_id;
        $penaltyPayment->pay_amount         = str_replace( ',', '', $request->arrearPenalty );
        $penaltyPayment->payment_mode_id    = $request->paymentMode;
        $penaltyPayment->payment_ref_no     = $request->transactionReference;
        $penaltyPayment->payment_date       = date( 'Y-m-d', strtotime( $request->paymentDate ) );
        $penaltyPayment->payment_proof      = $payment_proof;
        $penaltyPayment->type               = 'SECTION PAY';
        $penaltyPayment->status             = 'PENDING';
        $penaltyPayment->processing_status  = 'PENDING';
        $penaltyPayment->created_by         = Auth::user()->id;

        if ( $penaltyPayment->save() ) {
            $respStatus = 'success';
            $repsText   = 'You have Successfully submitted Section Penalty Payment';
        } else {
            $respStatus = 'errors';
            $repsText   = 'So thing when wrong. Kindly, repeat the process';
        }

        toastr();

        return redirect( 'arrears/sectionarrears/'.Crypt::encryptString( 'ACTIVE' ) )->with( [ $respStatus=>$repsText ] );
    }

    public function payMemberArrearPenalty( $arearDetailsID ) {
        $arearDetailsID    = Crypt::decryptString( $arearDetailsID );

        $arrearDetailsData = ArrearDetail::find( $arearDetailsID )->first();
        $paymentMode       = PaymentMode::where( 'status', 'ACTIVE' )->get();

        return view( 'arrears.arrears_member_penaltypay', compact( 'arrearDetailsData', 'paymentMode' ) );
    }

    public function submitMemberArrearPenaltyPay( Request $request, $arrearDetailID ) {
        $valid = Validator::make( $request->all(), [
            'arrearPenalty'        => 'required',
            'paymentDate'          => 'required',
            'paymentMode'          => 'required',
            'transactionReference' => 'required',
        ] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid )->withInput();
        }

        //Start:: Get Payment Proof
        if ( $request->hasFile( 'transactionProof' ) ) {
            $filenameWithExt = $request->file( 'transactionProof' )->getClientOriginalName();
            // Get just filename
            $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME );
            //Get just ext
            $extension = $request->file( 'transactionProof' )->getClientOriginalExtension();
            // Create new Filename
            $newfilename = 'PENALTY_' . date( 'y' );
            // FileName to Store
            $payment_proof = $newfilename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file( 'transactionProof' )->storeAs( 'public/penaltyPaymentProof', $payment_proof );
        } else {
            $payment_proof = 'NULL';
        }
        //End:: Get Payment Proof
        $arrearData = ArrearDetail::find( $arrearDetailID );

        $penaltyPayment = new ArrearPenaltyPayment;
        $penaltyPayment->arrear_id          = $arrearData->arrear_id;
        $penaltyPayment->arrear_detail_id   = $arrearDetailID;
        $penaltyPayment->section_id         = $arrearData->arrear->section_id;
        $penaltyPayment->pay_amount         = str_replace( ',', '', $request->arrearPenalty );
        $penaltyPayment->payment_mode_id    = $request->paymentMode;
        $penaltyPayment->payment_ref_no     = $request->transactionReference;
        $penaltyPayment->payment_date       = date( 'Y-m-d', strtotime( $request->paymentDate ) );
        $penaltyPayment->payment_proof      = $payment_proof;
        $penaltyPayment->type               = 'MEMBER PAY';
        $penaltyPayment->status             = 'PENDING';
        $penaltyPayment->processing_status  = 'PENDING';
        $penaltyPayment->created_by         = Auth::user()->id;

        if ( $penaltyPayment->save() ) {
            $respStatus = 'success';
            $repsText   = 'You have Successfully submitted Member Penalty Payment';
        } else {
            $respStatus = 'errors';
            $repsText   = 'So thing when wrong. Kindly, repeat the process';
        }

        toastr();

        return redirect( 'arrears/sectionarrears/'.Crypt::encryptString( 'ACTIVE' ) )->with( [ $respStatus=>$repsText ] );
    }

    public function sectionPenaltyPayments( $status ) {
        $status    = Crypt::decryptString( $status );
        $sectionPenaltyPayments = ArrearPenaltyPayment::where( 'processing_status', $status )->where( 'type', 'SECTION PAY' )->get();

        return view( 'arrears.section_penaltypayment_processing', compact( 'sectionPenaltyPayments','status' ) );
    }

    public function ajaxApproveSectionArrearPenalty(Request $request){
        $arrearData = Arrear::find($request->data_id);
        $penaltyWaiveArr = array();
        if($request->new_status=='Approve'){
            $processing_status ='SUSPENDED';
        }
        if($arrearData ){
            $arrearData->processing_status   = $processing_status;
            $arrearData->suspend_approved_by = Auth::user()->id;
            $arrearData->suspend_approved_at = date('Y-m-d H:i:s');
            $arrearData->save();

            $penaltyWaiveArr['status']   = 'success';
        }else{
            $penaltyWaiveArr['status']   ='fail';
            $penaltyWaiveArr['message']  ="Arrear Data couldn't be found, redo the process";
        }

        return response()->json(['penaltyWaiveArr'=>$penaltyWaiveArr]);
    }


    public function memberPenaltyPayments( $status ) {
        $status    = Crypt::decryptString( $status );
        $memberPenaltyPayments = ArrearPenaltyPayment::where( 'processing_status', $status )->where( 'type', 'MEMBER PAY' )->get();

        return view( 'arrears.member_penaltypayment_processing', compact( 'memberPenaltyPayments','status' ) );
    }

    public function sectionPenalties( $status ) {
        $status     = Crypt::decryptString( $status );
        $arrearData = Arrear::where('processing_status', $status)->where('penalty_amount','>',0)->get();

        return view( 'arrears.section_penalty_processing', compact( 'arrearData','status' ) );
    }

    public function memberPenalties( $status ) {
        $status     = Crypt::decryptString( $status );
        $arrearData = ArrearDetail::where('processing_status', $status)->where('processing_type','INDIVIDUAL')->get();

        return view( 'arrears.section_penalty_processing', compact( 'arrearData','status' ) );
    }

}

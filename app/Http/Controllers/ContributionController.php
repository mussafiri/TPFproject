<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\ContributionDetail;
use App\Models\Contributor;
use App\Models\ContributorCatContrStructure;
use App\Models\ContributorMember;
use App\Models\PaymentMode;
use App\Models\Scheme;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class ContributionController extends Controller {

    public function addContribution() {
        $sections = Section::where( 'status', 'ACTIVE' )->get();
        $schemes = Scheme::where( 'status', 'ACTIVE' )->get();
        $paymentMode = PaymentMode::where( 'status', 'ACTIVE' )->get();
        return view( 'contributions.contributions_add', [ 'sections'=>$sections, 'schemes'=>$schemes, 'paymentMode'=>$paymentMode ] );
    }

    public function ajaxGetSectionContributionData( Request $request ) {
        $getSectionData = Section::find( $request->section_id );
        $countContributors = Contributor::where( 'section_id', $request->section_id )->count();

        $totalMembers = Contributor::join( 'members', 'members.contributor_id', '=', 'contributors.id' )
        ->where( 'contributors.section_id', $request->section_id )
        ->count();

        $contributionDate = date( 'Y-m-d', strtotime( $request->contribution_date ) );

        $getContributorMember = ContributorMember::join( 'contributors', 'contributors.id', '=', 'contributor_members.contributor_id' )
        // ->join( 'members', 'members.contributor_id', '=', 'contributors.id' )
        ->where( 'contributors.section_id', $request->section_id )
        // ->whereDate( 'contributor_members.start_date', '=', $contributionDate )
        // ->whereDate( 'contributor_members.end_date', '>=', $contributionDate )
        ->where( 'contributor_members.status', 'ACTIVE' )
        ->get();

        // dd( $request->section_id );

        $memberList = '';
        $counter = 1;

        foreach ( $getContributorMember AS $memberData ) {
            $statusBadge = ( $memberData->status == 'ACTIVE' )?'success':'danger';
            // $newStatus = ( $memberData->status == 'ACTIVE' )?'DORMANT':'ACTIVE';
            // $statusActions = ( $memberData->status == 'ACTIVE' )?'<i class="mdi mdi-close-thick mr-1"></i>Suspend':'<i class="mdi mdi-mark-thick mr-1"></i>Reinstate';
            $totalContribution = $memberData->getMemberContributionAmount( $memberData->contributor_id, $memberData->member_id )+$memberData->getContributorContributionAmount( $memberData->contributor_id, $memberData->member_id );

            $memberList .= '<tr><td>'.$counter.'.</td>
                        <td class="text-muted font-9 px-0">'.$memberData->contributor->name.'<input type="hidden" name="contributor[]" value="'.$memberData->contributor_id.'"></td>
                        <td>'.$memberData->member->fname.' '.$memberData->member->mname.' '.$memberData->member->lname.'<input type="hidden" name="member[]" value="'.$memberData->member_id.'"></td>
                        <td> <input type="text" class="monthlyIncomeInput'.$counter.' col-sm-12 px-1 border-1 border-light rounded autonumber" data-id="'.$counter.'" name="memberMonthlyIncome[]" value="'.number_format( $memberData->getMemberMonthlyIncome( $memberData->member_id ), 2 ).'" required> </td>
                        <td> <input type="text" class="memberContributionInput'.$counter.' col-sm-12 px-1 border-1 border-light rounded autonumber" data-id="'.$counter.'" name="memberContribution[]" value="'.number_format( $memberData->getMemberContributionAmount( $memberData->contributor_id, $memberData->member_id ), 2 ).'" required></td>
                        <td> <input type="text" class="contributorContributionInput'.$counter.' col-sm-12 px-1 border-1 border-light rounded autonumber" data-id="'.$counter.'" name="contributorContribution[]" value="'.number_format( $memberData->getContributorContributionAmount( $memberData->contributor_id, $memberData->member_id ), 2 ).'" required></td>
                        <td> <input type="text" class="topupInput'.$counter.' col-sm-12 px-1 border-1 border-light rounded autonumber" data-id="'.$counter.'" name="topup[]" value="'.number_format( 0, 2 ).'" required></td>
                        <td> <span class="totalSpan'.$counter.'">'.number_format( $totalContribution, 2 ).'</span> <input type="hidden" class="total totalInput'.$counter.' border-light rounded" data-id="'.$counter.'" name="total[]" value="'.number_format( $totalContribution, 2 ).'" required></td>
                        <td> <span id="status'.$counter.'" class="badge badge-outline-'.$statusBadge.' badge-pill">'.$memberData->status.'</span></td>
                        <td>
                            <div class="float-right">
                                <a href="javascript:void(0);" class="text-blue btn btn-light btn-sm suspendContribution editButton'.$counter.'" aria-expanded="false" data-rowID="'.$counter.'">
                                    <i class="mdi mdi-close-thick mr-1"></i>
                                </a>
                            </div>
                        </td></tr>';
            $counter++;
        }

        //START:: Suspend Member Contribution
        //END:: Suspend Member Contribution

        $sectionContributionDataArr = array();
        if ( $getSectionData ) {
            $sectionContributionDataArr[ 'code' ]              = 201;
            $sectionContributionDataArr[ 'sectionData' ]       = $getSectionData;
            $sectionContributionDataArr[ 'totalContributors' ] = $countContributors;
            $sectionContributionDataArr[ 'totalMembers' ]      = $totalMembers;
            $sectionContributionDataArr[ 'memberList' ]        = $memberList;
        } else {
            $sectionContributionDataArr[ 'code' ] = 403;
            $sectionContributionDataArr[ 'memberList' ]        = '';
        }

        return response()->json( [ 'sectionContributionDataArr'=>$sectionContributionDataArr ] );
    }

    public function submitAddContribution( Request $request ) {
        $valid = Validator::make( $request->all(), [
            'section'             => 'required|gt:0',
            'contributionDate'    => 'required',
            'contributionAmount'  => 'required',
            'paymentDate'         => 'required',
            'paymentMode'         => 'required',
            'transactionReference'=> 'required',
        ], [ 'section.gt' => 'You must select Section' ] );

        if ( $valid->fails() ) {
            return back()->withErrors( $valid )->withInput();
        }

        //START:: Validation of Array Inputs
        $valid = Validator::make( $request->all(), [
            'contributor'             =>'required',
            'member'                  =>'required',
            'memberMonthlyIncome'     =>'required',
            'memberContribution'      =>'required',
            'contributorContribution' =>'required',
            'topup'                   =>'required',
            'total'                   =>'required' ] );

            //END:: Validation of Array Inputs
            if ( $valid->fails() ) {
                return back()->withErrors( $valid, 'dynamicInputsValidation' )->withInput();
            }

            //Start:: Get Payment Proof
            if ( $request->hasFile( 'transactionProof' ) ) {
                $filenameWithExt = $request->file( 'transactionProof' )->getClientOriginalName();
                // Get just filename
                $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME );
                //Get just ext
                $extension = $request->file( 'transactionProof' )->getClientOriginalExtension();
                // Create new Filename
                $newfilename = 'CONTR_' . date( 'y' );
                // FileName to Store
                $payment_proof = $newfilename . '_' . time() . '.' . $extension;
                // Upload Image
                $path = $request->file( 'transactionProof' )->storeAs( 'public/contributionPaymentProof', $payment_proof );
            } else {
                $payment_proof = 'NULL';
            }
            //End:: Get Payment Proof

            //Start: insert into contribution
            $newContribution =  new Contribution;
            $newContribution->section             = $request->section;
            $newContribution->contribution_period = date( 'Y-m-d', strtotime( $request->contributionDate ) );
            $newContribution->total_contributors  = $request->totalContributors;
            $newContribution->total_members       = $request->totalMembers;
            $newContribution->contribution_amount = $request->contributionAmount;
            $newContribution->payment_mode_id     = $request->paymentMode;
            $newContribution->payment_ref_no      = $request->transactionReference;
            $newContribution->payment_proof       = $payment_proof;
            $newContribution->payment_date        = date( 'Y-m-d', strtotime( $request->paymentDate ) );
            $newContribution->processing_status   = 'PENDING';
            $newContribution->status              = 'ACTIVE';
            $newContribution->create_by           = Auth::user()->id;
            $newContribution->save();
            //End: insert into contribution

            //Start:: Insert contribution details
            $contributor = $request->contributor;
            $member = $request->member;
            $memberMonthlyIncome = $request->memberMonthlyIncome;
            $memberContribution = $request->memberContribution;
            $contributorContribution = $request->contributorContribution;
            $topup = $request->topup;
            $totalContribution = $request->total;
           
            for ( $aa = 0; $aa < count( $totalContribution );
            $aa++ ) {
                $newContributionDetail = new ContributionDetail;
                $newContributionDetail->contribution_id      = $newContribution->id;
                $newContributionDetail->contributor_id       = $contributor[ $aa ];
                $newContributionDetail->member_id            = $member[ $aa ];
                $newContributionDetail->member_monthly_income = $memberMonthlyIncome[ $aa ];
                $newContributionDetail->member_contribution  = $memberContribution[ $aa ];
                $newContributionDetail->contributor_contribution  = $contributorContribution[ $aa ];
                $newContributionDetail->payment_ref_no       = $request->transactionReference;
                $newContributionDetail->payment_proof        = $payment_proof;
                $newContributionDetail->member_topup         = $topup[ $aa ];
                $newContributionDetail->status               = 'ACTIVE';
                $newContributionDetail->created_by           = Auth::user()->id;
                $newContributionDetail->save();
            }
            //End:: Insert contribution details
            toastr();
            return redirect( 'contributions/history' )->with( [ 'success'=>'You have Successfully added new Contribution for '.$request->contributionDate ] );

        }

        public function contributions( $status ) {
            $status = Crypt::decryptString( $status );
            $contributions = Contribution::where( 'processing_status', $status )->get();
            return view( 'contributions.contributions', compact( 'contributions','status') );
        }

    }

<?php

namespace App\Http\Controllers;

use App\Lib\Common;
use App\Models\Contribution;
use App\Models\ContributionDetail;
use App\Models\Contributor;
use App\Models\ContributorCatContrStructure;
use App\Models\ContributorIncomeTracker;
use App\Models\ContributorMember;
use App\Models\Member;
use App\Models\MemberMonthlyIncome;
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

        $contributionDate = date( 'Y-m', strtotime( $request->contribution_date ) );
        //START:: contribution check
        $oldContributions = '';
        $checkContribtuions = Contribution::where( 'section_id', $request->section_id )->where( 'contribution_period', 'LIKE', '%'.$contributionDate.'%' )->get();
       
        if ( $checkContribtuions->count() > 0 ) {
            $count = 1;
            foreach ( $checkContribtuions as $contriData ) {
                $action = 'contributions/view/'.Crypt::encryptString( $contriData->id ).'/'.Crypt::encryptString( $contriData->id );
                $oldContributions .= '<tr>
                                        <td>'.$count.'</td>
                                        <td class="text-center">'.$contriData->section->name.'</td>
                                        <td class="text-center">'.$contriData->contribution_period.'</td>
                                        <td class="text-center">'.$contriData->total_contributors.'</td>
                                        <td class="text-center">'.$contriData->total_members.'</td>
                                        <td class="text-center">'.$contriData->contribution_amount.'</td>
                                        <td class="text-center">'.$contriData->processing_status.'</td>
                                        <td class="text-center"> <a href="{{url('.$action.')}}"> <i class="mdi mdi-eye-outline"></i></a></td>
                                    </tr>';
                $count++;
            }
        }
        //END:: contribution check

        $getContributorMember = ContributorMember::join( 'contributors', 'contributors.id', '=', 'contributor_members.contributor_id' )
        ->where( 'contributors.section_id', $request->section_id )
        ->whereDate( 'contributor_members.start_date', 'LIKE', '%'.$contributionDate.'%' )
        // ->whereDate( 'contributor_members.end_date', '>=', $contributionDate )
        ->where( 'contributor_members.status', 'ACTIVE' )
        ->get();

        $memberList = '';
        $counter = 1;

        foreach ( $getContributorMember AS $memberData ) {
            $statusBadge = ( $memberData->status == 'ACTIVE' )?'success':'danger';
            // $newStatus = ( $memberData->status == 'ACTIVE' )?'DORMANT':'ACTIVE';
            // $statusActions = ( $memberData->status == 'ACTIVE' )?'<i class="mdi mdi-close-thick mr-1"></i>Suspend':'<i class="mdi mdi-mark-thick mr-1"></i>Reinstate';
            $totalContribution = $memberData->getMemberContributionAmount( $memberData->contributor_id, $memberData->member_id )+$memberData->getContributorContributionAmount( $memberData->contributor_id, $memberData->member_id );

            $memberList .= '<tr><td>'.$counter.'.</td>
                                <td class="font-9 px-0">'.$memberData->contributor->name.'<input type="hidden" name="contributor[]" value="'.$memberData->contributor_id.'"></td>
                                <td>'.$memberData->member->fname.' '.$memberData->member->mname.' '.$memberData->member->lname.'<input type="hidden" name="member[]" value="'.$memberData->member_id.'"></td>
                                <td> <span class="monthlyIncomeSpan'.$counter.'">'.number_format( $memberData->getMemberMonthlyIncome( $memberData->member_id ), 2 ).'</span> <input type="hidden" class="monthlyIncomeInput'.$counter.'" data-id="'.$counter.'" name="memberMonthlyIncome[]" value="'.number_format( $memberData->getMemberMonthlyIncome( $memberData->member_id ), 2 ).'" required>  <input type="hidden" class="contributorMonthlyIncomeInput'.$counter.'" data-id="'.$counter.'" name="contributorMonthlyIncome[]" value="'.$memberData->getContributorMonthlyIncome( $memberData->contributor_id ).'" required></td>
                                <td> <span class="contributorContributionSpan'.$counter.'">'.number_format( $memberData->getContributorContributionAmount( $memberData->contributor_id, $memberData->member_id ), 2 ).'</span> <input type="hidden" class="contributorContributionInput'.$counter.' col-sm-12 px-1 border-1 border-light rounded contributorContrInput autonumber" data-id="'.$counter.'" data-memberID="'.$memberData->member_id.'" data-contributorID="'.$memberData->contributor_id.'" name="contributorContribution[]" value="'.$memberData->getContributorContributionAmount( $memberData->contributor_id, $memberData->member_id ).'" required></td>
                                <td> <input type="text" class="memberContributionInput'.$counter.' col-sm-12 px-1 border-1 border-light rounded memberContrInput autonumber" data-id="'.$counter.'" data-memberID="'.$memberData->member_id.'" data-contributorID="'.$memberData->contributor_id.'" name="memberContribution[]" value="'.number_format( $memberData->getMemberContributionAmount( $memberData->contributor_id, $memberData->member_id ), 2 ).'" required></td>
                                <td> <input type="text" class="topupInput'.$counter.' col-sm-12 px-1 border-1 border-light rounded contrInputsTopup autonumber" data-id="'.$counter.'" data-memberID="'.$memberData->member_id.'" data-contributorID="'.$memberData->contributor_id.'" name="topup[]" value="'.number_format( 0, 2 ).'" required></td>
                                <td class="text-center"> <span class="totalSpan'.$counter.'">'.number_format( $totalContribution, 2 ).'</span> <input type="hidden" class="total totalInput'.$counter.' border-light rounded" data-id="'.$counter.'" name="total[]" value="'.number_format( $totalContribution, 2 ).'" required></td>
                                <td> <span id="status'.$counter.'" class="badge badge-outline-'.$statusBadge.' badge-pill">'.$memberData->status.'</span></td>
                                <td>
                                    <div class="float-right">
                                        <a href="javascript:void(0);" class="text-blue btn btn-light btn-sm suspendContribution editButton'.$counter.'"  data-id="'.$counter.'" data-memberID="'.$memberData->member_id.'" data-contributorID="'.$memberData->contributor_id.'" aria-expanded="false" data-rowID="'.$counter.'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Suspend User Contribution">
                                            <i class="mdi mdi-close-thick mr-1"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>';
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
            $sectionContributionDataArr[ 'oldContributions' ]  = $oldContributions;
        } else {
            $sectionContributionDataArr[ 'code' ] = 403;
            $sectionContributionDataArr[ 'memberList' ]        = '';
            $sectionContributionDataArr[ 'oldContributions' ]  = $oldContributions;
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
            'totalContributors'   => 'required',
            'totalMembers'        => 'required',
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
            $newContribution->section_id          = $request->section;
            $newContribution->contribution_period = date( 'Y-m', strtotime( $request->contributionDate ) );
            $newContribution->total_contributors  = $request->totalContributors;
            $newContribution->total_members       = $request->totalMembers;
            $newContribution->contribution_amount = str_replace( ',', '', $request->contributionAmount );
            $newContribution->payment_mode_id     = $request->paymentMode;
            $newContribution->payment_ref_no      = $request->transactionReference;
            $newContribution->payment_proof       = $payment_proof;
            $newContribution->payment_date        = date( 'Y-m-d', strtotime( $request->paymentDate ) );
            $newContribution->processing_status   = 'PENDING';
            $newContribution->status              = 'ACTIVE';
            $newContribution->created_by           = Auth::user()->id;
            $newContribution->save();
            //End: insert into contribution

            //Start:: Insert contribution details
            $contributor = $request->contributor;
            $member = $request->member;
            $memberMonthlyIncome = $request->memberMonthlyIncome;
            $memberContribution = $request->memberContribution;
            $contributorContribution = $request->contributorContribution;
            $contributorMonthlyIncome = $request->contributorMonthlyIncome;
            $topup = $request->topup;
            //$totalContribution = $request->total;

            for ( $aa = 0; $aa < count( $memberMonthlyIncome );
            $aa++ ) {
                $newContributionDetail = new ContributionDetail;
                $newContributionDetail->contribution_id      = $newContribution->id;
                $newContributionDetail->contributor_id       = $contributor[ $aa ];
                $newContributionDetail->member_id            = $member[ $aa ];
                $newContributionDetail->member_monthly_income = str_replace( ',', '', $memberMonthlyIncome[ $aa ] );
                $newContributionDetail->member_contribution  = str_replace( ',', '', $memberContribution[ $aa ] );
                $newContributionDetail->contributor_contribution  = str_replace( ',', '', $contributorContribution[ $aa ] );
                $newContributionDetail->payment_ref_no       = $request->transactionReference;
                $newContributionDetail->payment_proof        = $payment_proof;
                $newContributionDetail->member_topup         = $topup[ $aa ];
                $newContributionDetail->status               = 'ACTIVE';
                $newContributionDetail->created_by           = Auth::user()->id;
                $newContributionDetail->save();
                //Start:: Save new member monthly income

                # Start: update Old monthly income
                $getMemberIncome = MemberMonthlyIncome::where( 'member_id', $member[ $aa ] )->where( 'status', 'CONTRIBUTED' )->first();
                if ( $getMemberIncome ) {
                    $updateMemberIncome = MemberMonthlyIncome::find( $getMemberIncome->id );
                    $updateMemberIncome->status = 'DORMANT';
                    $updateMemberIncome->save();
                }
                # End: update Old monthly income

                $newMemberIncome = new MemberMonthlyIncome;
                $newMemberIncome->member_id = $member[ $aa ];
                $newMemberIncome->member_monthly_income = str_replace( ',', '', $memberMonthlyIncome[ $aa ] );
                $newMemberIncome->contribution_date =  date( 'Y-m', strtotime( $request->contributionDate ) );
                $newMemberIncome->status = 'CONTRIBUTED';
                $newMemberIncome->created_by = Auth::user()->id;
                $newMemberIncome->save();
                //END:: Save new member monthly income

                //Start:: Insert new Contributor an member income
                #start::Check member salutation because only senior pastor contribution change affects contributor income
                $getMemberData = Member::find( $member[ $aa ] );
                if ( $getMemberData->member_salutation_id == 1 ) {

                    # Start: update Old Contributor  monthly income
                    $getContributorIncome = ContributorIncomeTracker::where( 'contributor_id' )->where( 'status', 'ACTIVE' )->first();
                    if ( $getContributorIncome ) {
                        $updateContributorIncome = ContributorIncomeTracker::find( $getContributorIncome->id );
                        $updateContributorIncome->status = 'DORMANT';
                        $updateContributorIncome->updated_by = Auth::user()->id;
                        $updateContributorIncome->save();
                    }
                    # End: update Old Contributor  monthly income

                    $newContributorIncome = new ContributorIncomeTracker;
                    $newContributorIncome->contributor_id = $contributor[ $aa ];
                    $newContributorIncome->contributor_monthly_income = str_replace( ',', '', $contributorMonthlyIncome[ $aa ] );
                    $newContributorIncome->income_month = date( 'Y-m-d', strtotime( $request->contributionDate ) );
                    $newContributorIncome->status = 'ACTIVE';
                    $newContributorIncome->save();
                }
                #End:: Check member salutation
                //end:: insert new Contributor an member income
            }

            //End:: Insert contribution details
            toastr();
            return redirect( 'contributions/transactions/'.Crypt::encryptString( 'PENDING' ) )->with( [ 'success'=>'You have Successfully added new Contribution for '.$request->contributionDate ] );

        }

        public function contributions( $status ) {
            $status = Crypt::decryptString( $status );
            $contributions = Contribution::where( 'processing_status', $status )->get();
            return view( 'contributions.contributions', compact( 'contributions', 'status' ) );
        }

        public function ajaxComputeEditMemberContribution( Request $request ) {
            $cmn = new Common();

            $newContribution = $request->newContribution;
            $memberID = $request->memberID;
            $contributorID = $request->contributorID;

            $getContributionStructure = $cmn->contributionReverseComputation( $newContribution, $memberID, $contributorID );

            return response()->json( [ 'getContributionStructure'=>$getContributionStructure ] );
        }

    }

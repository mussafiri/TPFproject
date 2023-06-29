<?php

namespace App\Http\Controllers;

use App\Lib\Common;
use App\Models\Contribution;
use App\Models\ContributionDetail;
use App\Models\ContributionRejectReason;
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
        return view( 'contributions.contributions_add', compact('sections', 'schemes', 'paymentMode'));
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
        $checkContributions = Contribution::where( 'section_id', $request->section_id )->where( 'contribution_period', 'LIKE', '%'.$contributionDate.'%' )->get();

        $countPendingContrinbution = 0;

        if ( $checkContributions->count() > 0 ) {
            $count = 1;
            foreach ( $checkContributions as $contriData ) {
                //START:: check unattended contribution
                    if($contriData->processing_status!='POSTED' && $contriData->status!='SUSPENDED'){
                        $countPendingContrinbution++;
                    }
                //END:: check unattended contribution
                
                if($contriData->processing_status=="PENDING"){$badgeText = "info";}else if ($contriData->processing_status=="APPROVED"){$badgeText = "primary";}elseif($contriData->processing_status=="POSTED"){$badgeText = "success";}else if($contriData->processing_status=="APPROVAL REJECTED"){$badgeText = "danger";}elseif($contriData->processing_status=="POSTING REJECTED"){$badgeText = "pink";}else{$badgeText = "secondary";}
                
                $action = 'contributions/details/'.Crypt::encryptString($contriData->id);
                $oldContributions .= '<tr>
                                        <td>'.$count.'</td>
                                        <td class="text-center">'.$contriData->section->name.'</td>
                                        <td class="text-center">'.date('M Y', strtotime($contriData->contribution_period)).'</td>
                                        <td class="text-center">'.$contriData->total_contributors.'</td>
                                        <td class="text-center">'.$contriData->total_members.'</td>
                                        <td class="text-center">'.number_format($contriData->contribution_amount,2).'</td>
                                        <td class="text-center"><span class="badge badge-outline-'.$badgeText.' badge-pill">'.$contriData->processing_status.'</span></td>
                                        <td class="text-center"> <a href="'.url($action).'"> <i class="mdi mdi-eye-outline"></i></a></td>
                                    </tr>';
                
                $count++;
            }
        }
        //END:: contribution check

        $memberList = '';

        $getCurrentContributorMember = ContributorMember::join( 'contributors', 'contributors.id', '=', 'contributor_members.contributor_id' )
        ->where( 'contributors.section_id', $request->section_id )
        ->where( 'contributor_members.start_date', '<=', $contributionDate )
        ->where( 'contributor_members.end_date', 'NULL' )
        ->where( 'contributor_members.status', 'ACTIVE' )
        ->get();

        $counter = 1;

        foreach ( $getCurrentContributorMember AS $memberData ) {
            $statusBadge = ( $memberData->status == 'ACTIVE' )?'success':'danger';
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
        // END:: Get current members

        //START:: Qualifying member
        $getQualifyingContributorMember = ContributorMember::join( 'contributors', 'contributors.id', '=', 'contributor_members.contributor_id' )
        ->where( 'contributors.section_id', $request->section_id )
        ->where( 'contributor_members.start_date', '<=', $contributionDate )
        ->where( 'contributor_members.end_date', '>=', $contributionDate )
        ->where( 'contributor_members.end_date', '!=', 'NULL' )
        ->where( 'contributor_members.status', 'ACTIVE' )
        ->get();

        foreach ( $getQualifyingContributorMember AS $qualifiedMembers ) {
            $statusBadge = ( $qualifiedMembers->status == 'ACTIVE' )?'success':'danger';
            $totalContribution = $qualifiedMembers->getMemberContributionAmount( $qualifiedMembers->contributor_id, $qualifiedMembers->member_id )+$qualifiedMembers->getContributorContributionAmount( $qualifiedMembers->contributor_id, $qualifiedMembers->member_id );

            $memberList .= '<tr><td>'.$counter.'.</td>
                                <td class="font-9 px-0">'.$qualifiedMembers->contributor->name.'<input type="hidden" name="contributor[]" value="'.$qualifiedMembers->contributor_id.'"></td>
                                <td>'.$qualifiedMembers->member->fname.' '.$qualifiedMembers->member->mname.' '.$qualifiedMembers->member->lname.'<input type="hidden" name="member[]" value="'.$qualifiedMembers->member_id.'"></td>
                                <td> <span class="monthlyIncomeSpan'.$counter.'">'.number_format( $qualifiedMembers->getMemberMonthlyIncome( $qualifiedMembers->member_id ), 2 ).'</span> <input type="hidden" class="monthlyIncomeInput'.$counter.'" data-id="'.$counter.'" name="memberMonthlyIncome[]" value="'.number_format( $qualifiedMembers->getMemberMonthlyIncome( $qualifiedMembers->member_id ), 2 ).'" required>  <input type="hidden" class="contributorMonthlyIncomeInput'.$counter.'" data-id="'.$counter.'" name="contributorMonthlyIncome[]" value="'.$qualifiedMembers->getContributorMonthlyIncome( $qualifiedMembers->contributor_id ).'" required></td>
                                <td> <span class="contributorContributionSpan'.$counter.'">'.number_format( $qualifiedMembers->getContributorContributionAmount( $qualifiedMembers->contributor_id, $qualifiedMembers->member_id ), 2 ).'</span> <input type="hidden" class="contributorContributionInput'.$counter.' col-sm-12 px-1 border-1 border-light rounded contributorContrInput autonumber" data-id="'.$counter.'" data-memberID="'.$qualifiedMembers->member_id.'" data-contributorID="'.$qualifiedMembers->contributor_id.'" name="contributorContribution[]" value="'.$qualifiedMembers->getContributorContributionAmount( $qualifiedMembers->contributor_id, $qualifiedMembers->member_id ).'" required></td>
                                <td> <input type="text" class="memberContributionInput'.$counter.' col-sm-12 px-1 border-1 border-light rounded memberContrInput autonumber" data-id="'.$counter.'" data-memberID="'.$qualifiedMembers->member_id.'" data-contributorID="'.$qualifiedMembers->contributor_id.'" name="memberContribution[]" value="'.number_format( $qualifiedMembers->getMemberContributionAmount( $qualifiedMembers->contributor_id, $qualifiedMembers->member_id ), 2 ).'" required></td>
                                <td> <input type="text" class="topupInput'.$counter.' col-sm-12 px-1 border-1 border-light rounded contrInputsTopup autonumber" data-id="'.$counter.'" data-memberID="'.$qualifiedMembers->member_id.'" data-contributorID="'.$qualifiedMembers->contributor_id.'" name="topup[]" value="'.number_format( 0, 2 ).'" required></td>
                                <td class="text-center"> <span class="totalSpan'.$counter.'">'.number_format( $totalContribution, 2 ).'</span> <input type="hidden" class="total totalInput'.$counter.' border-light rounded" data-id="'.$counter.'" name="total[]" value="'.number_format( $totalContribution, 2 ).'" required></td>
                                <td> <span id="status'.$counter.'" class="badge badge-outline-'.$statusBadge.' badge-pill">'.$qualifiedMembers->status.'</span></td>
                                <td>
                                    <div class="float-right">
                                        <a href="javascript:void(0);" class="text-blue btn btn-light btn-sm suspendContribution editButton'.$counter.'"  data-id="'.$counter.'" data-memberID="'.$qualifiedMembers->member_id.'" data-contributorID="'.$qualifiedMembers->contributor_id.'" aria-expanded="false" data-rowID="'.$counter.'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Suspend User Contribution">
                                            <i class="mdi mdi-close-thick mr-1"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>';
            $counter++;
        }
        //END:: Qualifying member

        $sectionContributionDataArr = array();
        if ( $getSectionData ) {
            $sectionContributionDataArr[ 'code' ]              = 201;
            $sectionContributionDataArr[ 'sectionData' ]       = $getSectionData;
            $sectionContributionDataArr[ 'totalContributors' ] = $countContributors;
            $sectionContributionDataArr[ 'totalMembers' ]      = $totalMembers;
            $sectionContributionDataArr[ 'memberList' ]        = $memberList;
            $sectionContributionDataArr[ 'oldContributions' ]  = $oldContributions;
            $sectionContributionDataArr[ 'onProcessContributions' ]  = $countPendingContrinbution;
        } else {
            $sectionContributionDataArr[ 'code' ] = 403;
            $sectionContributionDataArr[ 'memberList' ]        = '';
            $sectionContributionDataArr[ 'oldContributions' ]  = '';
            $sectionContributionDataArr[ 'onProcessContributions' ]  = $countPendingContrinbution;
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
                $newContributionDetail->pay_mode_id          = $request->paymentMode;
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
            return redirect( 'contributions/processing/'.Crypt::encryptString( 'PENDING' ) )->with( [ 'success'=>'You have Successfully added new Contribution for '.$request->contributionDate ] );

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

        public function contributionProcessing( $contributionID, $contributionStatus ) {
            $contributionID = Crypt::decryptString( $contributionID );
            $contributionStatus = Crypt::decryptString( $contributionStatus );

            $contributionData = Contribution::find( $contributionID );
            $contributionDetails = ContributionDetail::where( 'contribution_id', $contributionID )->get();
            $rectionReasons = ContributionRejectReason::where('status', 'ACTIVE')->get();

            return view( 'contributions/contributions_processing', compact( 'contributionData', 'contributionDetails', 'rectionReasons' ) );
        }

        public function submitContributionApproval(Request $request, $contributionID ) {
            $limit = $request->totalMembers;
            $valid = Validator::make( $request->all(), 
                        [ 'confirmMembers'      => ['required','array','size:'.$limit]]
                        , 
                        [ 'confirmMembers.required' => 'You must confirm ALL Members Contributions',
                          'confirmMembers.size' => 'You must confirm ALL Members Contributions' ] );

            if ( $valid->fails() ) {
                return back()->withErrors( $valid, 'approveContribution')->withInput();
            }
        
            $updateContribution = Contribution::find( $contributionID );

            if($request->approvalType == 'Approve Contribution'){
                $status = 'APPROVED';
                $updateContribution->approved_by = Auth::user()->id;
                $updateContribution->approved_at = date('Y-m-d H:i:s');
            
            }else{
                $status = 'POSTED';
                $updateContribution->posted_by = Auth::user()->id;
                $updateContribution->posted_at = date('Y-m-d H:i:s');
            }

            $updateContribution->processing_status = $status;

            if($updateContribution->save()){
                $respStatus ="success";
                $repsText='You have Successfully '.ucfirst(strtolower($status)).' a contribution';
            }else{
                $respStatus="errors";
                $repsText='So thing when wrong. Kindly, repeat the process';
            }

            toastr();

            return redirect('contributions/processing/'.Crypt::encryptString('PENDING'))->with([$respStatus=>$repsText]);
        }

    public function viewContributionDetails($contributionID){
        $contributionID = Crypt::decryptString( $contributionID );

        $contributionData = Contribution::find( $contributionID );
        $contributionDetails = ContributionDetail::where( 'contribution_id', $contributionID )->get();

        return view( 'contributions/contributions_view', compact( 'contributionData', 'contributionDetails' ) );
    }

    public function searchContributions(){
        $sections = Section::where( 'status', 'ACTIVE' )->get();
        $schemes = Scheme::where( 'status', 'ACTIVE' )->get();
        $paymentMode = PaymentMode::where( 'status', 'ACTIVE' )->get();
        return view( 'contributions.contributions_search', compact('sections', 'schemes', 'paymentMode'));
    }

    public function ajaxGetOldContributionData( Request $request ) {
        $getSectionData = Section::find( $request->section_id );
        $countContributors = Contributor::where( 'section_id', $request->section_id )->count();

        $totalMembers = Contributor::join( 'members', 'members.contributor_id', '=', 'contributors.id' )
        ->where( 'contributors.section_id', $request->section_id )
        ->count();

        $contributionDate = date( 'Y-m', strtotime( $request->contribution_date ) );
        //START:: contribution check
        $oldContributions = '';
        $checkContributions = Contribution::where( 'section_id', $request->section_id )->where( 'contribution_period', 'LIKE', '%'.$contributionDate.'%' )->get();

        if ( $checkContributions->count() > 0 ) {
            $count = 1;
            foreach ( $checkContributions as $contriData ) {
                $ditLink ='';
                if($contriData->processing_status == "PENDING"|| $contriData->processing_status =="APPROVAL REJECTED" || $contriData->processing_status =="POSTING REJECTED"){
                    $ditLink = '<a href="'.url("contributions/edit/".Crypt::encryptString($contriData->id)).'" class="dropdown-item"> <i class="mdi mdi-pencil-outline mr-1"></i> Edit </a>';
                }

                $oldContributions .= '<tr>
                                        <td>'.$count.'</td>
                                        <td class="text-center">'.$contriData->section->name.'</td>
                                        <td class="text-center">'.date('M Y', strtotime($contriData->contribution_period)).'</td>
                                        <td class="text-center">'.$contriData->total_contributors.'</td>
                                        <td class="text-center">'.$contriData->total_members.'</td>
                                        <td class="text-center">'.number_format($contriData->contribution_amount,2).'</td>
                                        <td class="text-center">'.$contriData->processing_status.'</td>
                                        <td class="text-center"> 
                                            <div class="btn-group dropdown float-right">
                                                <a href="#" class="dropdown-toggle arrow-none text-muted btn btn-light btn-sm"
                                                    data-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-horizontal font-18"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="'.url("contributions/details/".Crypt::encryptString($contriData->id)).'" class="dropdown-item">
                                                        <i class="mdi mdi-eye-outline mr-1"></i> View
                                                    </a>'.$ditLink.' 
                                                    <a href="'.url("contributions/topup/".Crypt::encryptString($contriData->id)).'" class="dropdown-item">
                                                        <i class="mdi mdi-account-cash-outline mr-1"></i> Topup
                                                    </a>
                                                </div> <!-- end dropdown menu-->
                                            </div>
                                        </td>
                                    </tr>';
                $count++;
            }
        }
        //END:: contribution check

        $sectionOldContributionDataArr = array();
        if ( $getSectionData ) {
            $sectionOldContributionDataArr[ 'code' ]              = 201;
            $sectionOldContributionDataArr[ 'sectionData' ]       = $getSectionData;
            $sectionOldContributionDataArr[ 'totalContributors' ] = $countContributors;
            $sectionOldContributionDataArr[ 'totalContributions' ] = $contriData->contribution_amount;
            $sectionOldContributionDataArr[ 'totalMembers' ]      = $totalMembers;
            $sectionOldContributionDataArr[ 'oldContributions' ]  = $oldContributions;
        } else {
            $sectionOldContributionDataArr[ 'code' ] = 403;
            $sectionOldContributionDataArr[ 'oldContributions' ]  = $oldContributions;
        }

        return response()->json( [ 'sectionOldContributionDataArr'=>$sectionOldContributionDataArr ] );
    }

    public function topupContribution($contributionID){
        $contributionID = Crypt::decryptString( $contributionID );

        $contributionData = Contribution::find( $contributionID );
        $contributionDetails = ContributionDetail::where( 'contribution_id', $contributionID )->get();

        return view( 'contributions/contributions_topup', compact( 'contributionData', 'contributionDetails' ) );
    }
    
    public function submitContributionRejection(Request $request, $contributionID){
        $valid = Validator::make( $request->all(), [
            'rejectionType'   => 'required',
            'reasonSelection' => 'required',
        ]);

        if ( $valid->fails() ) {
            return back()->withErrors( $valid, 'rejectionValidation' )->withInput();
        }
        
        $getContributionData = Contribution::find( $contributionID );
        
        if($request->rejectionReason==''){
            $rejectionReason = 'NULL';
        }else{
            $rejectionReason = $request->rejectionReason;
        }

        if($request->rejectionType == 'Reject Approval'){
            $processing_status = 'APPROVAL REJECTED';
            $getContributionData->approval_rejected_reason_id   = $request->reasonSelection;
            $getContributionData->approval_rejected_by   = Auth::user()->id;
            $getContributionData->approval_rejected_at   = date('Y-m-d H:i:s');
            $getContributionData->approval_reject_reason = $rejectionReason;
       
        }else{

            $processing_status = 'POSTING REJECTED';
            $getContributionData->posting_rejected_reason_id   = $request->reasonSelection;
            $getContributionData->posting_rejected_by   = Auth::user()->id;
            $getContributionData->posting_rejected_at   = date('Y-m-d H:i:s');
            $getContributionData->posting_reject_reason = $rejectionReason;
        }
        
        $getContributionData->processing_status = $processing_status;
        $getContributionData->save();

        toastr();

        return redirect('contributions/processing/'.Crypt::encryptString('PENDING'))->with(['success'=>'You have Successfully Rejected a Section Contribution']);
    }

    public function editContribution($contributionID){

    }

}

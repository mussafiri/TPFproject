<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use App\Models\ContributorMember;
use App\Models\Scheme;
use App\Models\Section;
use Illuminate\Http\Request;

class ContributionController extends Controller {

    public function addContribution() {
        $sections = Section::where( 'status', 'ACTIVE' )->get();
        $schemes = Scheme::where( 'status', 'ACTIVE' )->get();
        return view( 'contributions.contributions_add', [ 'sections'=>$sections, 'schemes'=>$schemes ] );
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
            $status = ( $memberData->status == 'ACTIVE' )?'DORMANT':'ACTIVE';
            $statusBadge = ( $memberData->status == 'ACTIVE' )?'success':'danger';
            $newStatus = ( $memberData->status == 'ACTIVE' )?'DORMANT':'ACTIVE';
            $statusActions = ( $memberData->status == 'ACTIVE' )?'<i class="mdi mdi-close-thick mr-1"></i>Suspend':'<i class="mdi mdi-mark-thick mr-1"></i>Reinstate';

            $memberList .= '<tr><td>'.$counter.'.</td>
                            <td class="text-muted font-9">'.$memberData->contributor->name.'</td>
                            <td>'.$memberData->member->fname.' '.$memberData->member->mname.' '.$memberData->member->lname.'</td>
                            <td> <span class="monthlyIncomeSpan'.$counter.'">'.number_format($memberData->memberMonthlyIncome( $memberData->member->id ),2).'<input type="hidden" class="monthlyIncomeInput'.$counter.'" name="memberMonthlyIncome[]" value="'.$memberData->memberMonthlyIncome( $memberData->member->id ).'"></td>
                            <td> <span class="memberContributionSpan'.$counter.'">'.number_format($memberData->getMemberContributionAmount( $memberData->member->id ),2).'<input type="hidden" class="memberContributionInput'.$counter.'" name="memberContribution[]" value="'.$memberData->getMemberContributionAmount( $memberData->member->id ).'"></td>
                            <td> <span class="contributorContributionSpan'.$counter.'">'.number_format($memberData->getContributorContributionAmount( $memberData->member->id ),2).'<input type="hidden" class="contributorContributionInput'.$counter.'" name="contributorContribution[]" value="'.$memberData->getContributorContributionAmount( $memberData->member->id ).'"></td>
                            <td> <span class="topupSpan'.$counter.'">'.number_format(0).'<input type="hidden" class="topupInput'.$counter.'" name="topup[]" value="0"></span></td>
                            <td><span class="totalSpan'.$counter.'">'.number_format(0).'<input type="hidden" class="total totalInput'.$counter.'" name="total[]" value="'.number_format($memberData->getMemberContributionAmount( $memberData->member->id )+$memberData->getContributorContributionAmount( $memberData->member->id ),2).'"></span></td>
                            <td>
                            <span id="status'.$counter.'" class="badge badge-outline-'.$statusBadge.' badge-pill">'.$memberData->status.'</span></td>
                            <td>
                                <div class="btn-group dropdown float-right">
                                    <a href="#" class="dropdown-toggle arrow-none text-muted btn btn-light btn-sm"
                                        data-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-horizontal font-18"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="" class="dropdown-item">
                                            <i class="mdi mdi-pencil-outline mr-1"></i>Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="javascript:void(0);" class="dropdown-item change_contributor_member_status_swt_alert" data-id="'.$memberData->id.'" data-newstatus="'.$newStatus.'" data-name="'.$memberData->member->fname.' '.$memberData->member->mname.' '.$memberData->member->lname.'">'.$statusActions.'</a>
                                    </div>
                                </div>
                            </td></tr>';
            $counter++;
        }

        $sectionContributionDataArr = array();
        if ( $getSectionData ) {
            $sectionContributionDataArr[ 'code' ]              = 201;
            $sectionContributionDataArr[ 'sectionData' ]       = $getSectionData;
            $sectionContributionDataArr[ 'totalContributors' ] = $countContributors;
            $sectionContributionDataArr[ 'totalMembers' ]      = $totalMembers;
            $sectionContributionDataArr[ 'memberList' ]        = $memberList;
        } else {
            $sectionContributionDataArr[ 'code' ] = 403;
            $sectionContributionDataArr[ 'memberList' ]        = 'No member found';

        }

        return response()->json( [ 'sectionContributionDataArr'=>$sectionContributionDataArr ] );
    }
}

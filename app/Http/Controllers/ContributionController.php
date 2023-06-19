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
            $statusBadge = ( $memberData->status == 'ACTIVE' )?'success':'danger';
            $newStatus = ( $memberData->status == 'ACTIVE' )?'DORMANT':'ACTIVE';
            $statusActions = ( $memberData->status == 'ACTIVE' )?'<i class="mdi mdi-close-thick mr-1"></i>Suspend':'<i class="mdi mdi-mark-thick mr-1"></i>Reinstate';
            $totalContribution=$memberData->getMemberContributionAmount( $memberData->member->id )+$memberData->getContributorContributionAmount( $memberData->member->id );
            
            $memberList .= '<tr><td>'.$counter.'.</td>
                            <td class="text-muted font-9 px-0">'.$memberData->contributor->name.'</td>
                            <td>'.$memberData->member->fname.' '.$memberData->member->mname.' '.$memberData->member->lname.'</td>
                            <td> <input type="text" class="monthlyIncomeInput'.$counter.' col-sm-12 px-1 border-1 border-light rounded" data-id="'.$counter.'" name="memberMonthlyIncome[]" value="'.number_format($memberData->memberMonthlyIncome( $memberData->member->id ),2).'"></td>
                            <td> <input type="text" class="memberContributionInput'.$counter.' col-sm-12 px-1 border-1 border-light rounded" data-id="'.$counter.'" name="memberContribution[]" value="'.number_format($memberData->getMemberContributionAmount( $memberData->member->id ),2).'"></td>
                            <td> <input type="text" class="contributorContributionInput'.$counter.' col-sm-12 px-1 border-1 border-light rounded" data-id="'.$counter.'" name="contributorContribution[]" value="'.number_format($memberData->getContributorContributionAmount( $memberData->member->id ),2).'"></td>
                            <td> <input type="text" class="topupInput'.$counter.' col-sm-12 px-1 border-1 border-light rounded" data-id="'.$counter.'" name="topup[]" value="'.number_format(0,2).'"></td>
                            <td> <span class="totalSpan'.$counter.'">'.number_format($totalContribution,2).'</span> <input type="hidden" class="total totalInput'.$counter.' border-light rounded" data-id="'.$counter.'" name="total[]" value="'.number_format($totalContribution,2).'"></td>
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
            $sectionContributionDataArr[ 'memberList' ]        = 'No member found';

        }

        return response()->json( [ 'sectionContributionDataArr'=>$sectionContributionDataArr ] );
    }
}

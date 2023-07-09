<?php
namespace App\Lib;
use App\Models\Arrear;
use App\Models\ArrearDetail;
use App\Models\Contribution;
use App\Models\ArrearRecognition;
use App\Models\ContributionDetail;
use App\Models\ContributorCatContrStructure;
use App\Models\Contributor;
use App\Models\ContributorIncomeTracker;
use App\Models\ContributorMember;
use App\Models\Member;
use App\Models\District;
use App\Models\MemberMonthlyIncome;
use App\Models\Section;
use Carbon\Carbon;

class Common {
    public function contributorCodeGenerator( $ID ) {
        $codeFormat = 'TPF-CN000000';
        //format
        $nextDigLength = mb_strlen( $ID, 'UTF-8' );
        $createNewCodeSpace = substr( $codeFormat, 0, -$nextDigLength );
        $finalCode = $createNewCodeSpace.$ID;

        $putContributorCode = Contributor::find( $ID );
        $putContributorCode->contributor_code = $finalCode;
        $putContributorCode->save();
    }

    public function memberCodeGenerator( $ID ) {
        $codeFormat = 'TPF-MN000000';
        //format
        $nextDigLength = mb_strlen( $ID, 'UTF-8' );
        $createNewCodeSpace = substr( $codeFormat, 0, -$nextDigLength );
        $finalCode = $createNewCodeSpace.$ID;

        $putMemberCode = Member::find( $ID );
        $putMemberCode->member_code = $finalCode;
        $putMemberCode->save();
    }

    public function districtCodeGenerator( $ID, $district, $zone_code ) {
        #substr()function to return the first two characters from the district name
        $d_code = substr( $district, 0, 2 );
        $codeFormat = $zone_code.'-'.$d_code;
        //format
        $nextDigLength = mb_strlen( $ID, 'UTF-8' );
        if ( $nextDigLength>1 ) {
            $lastCodePart = $ID;
        } else {
            $lastCodePart = '0'.$ID;
        }
        $finalCode = $codeFormat.$lastCodePart;

        $districtcodeUpdateobj = District::find( $ID );
        $districtcodeUpdateobj->district_code = $finalCode;
        $districtcodeUpdateobj->save();
    }

    public function sectionCodeGenerator( $ID, $section, $district_code ) {
        #substr()function to return the first two characters from the district name
        $s_code = substr( $section, 0, 2 );
        $codeFormat = $district_code.'-'.$s_code;
        //format
        $nextDigLength = mb_strlen( $ID, 'UTF-8' );
        if ( $nextDigLength>1 ) {
            $lastCodePart = $ID;
        } else {
            $lastCodePart = '0'.$ID;
        }
        $finalCode = $codeFormat.$lastCodePart;

        $sectioncodeUpdateobj = Section::find( $ID );
        $sectioncodeUpdateobj->section_code = $finalCode;
        $sectioncodeUpdateobj->save();
    }

    public function contributorMonthlyIncome( $contributorID ) {
        $income = 0;
        $getIncome = ContributorIncomeTracker::where( 'contributor_id', $contributorID )->where( 'status', 'ACTIVE' )->first();
        if ( $getIncome ) {
            $income = $getIncome->contributor_monthly_income;
        }
        return $income;
    }

    public function memberMonthlyIncome( $memberID ) {
        $income = 0;
        $getIncome = MemberMonthlyIncome::where( 'member_id', $memberID )->where( 'status', 'CONTRIBUTED' )->first();
        if ( $getIncome ) {
            $income = $getIncome->member_monthly_income;
        }

        return $income;
    }
    public function memberContributionAmount( $contributorID, $memberID ) {
        $memberIncome = 0;
        #start:: get member income
        $memberIncomeData = MemberMonthlyIncome::where( 'member_id', $memberID )->where( 'status', 'CONTRIBUTED' )->first();
        if ( $memberIncomeData ) {
            $memberIncome = $memberIncomeData->member_monthly_income;
        }
        #End:: get member income

        #Start:: get contribution
        $memberData = Member::find( $memberID );
        $contributorData = Contributor::find( $contributorID );

        $memberContrRate = 0;
        $contributionAmount = 0;

        $getcontributionRate = ContributorCatContrStructure::where( 'member_salutation_id', $memberData->member_salutation_id )->where( 'contributor_category_id', $contributorData->contributor_type_id )-> where( 'status', 'ACTIVE' )->first();

        if ( $getcontributionRate ) {
            $memberContrRate = $getcontributionRate->member_contribution_rate;
        }

        #End:: get contribution
        if ( $memberData->salutation_id == 1 ) {
            // Seniour Pastor
            $contributionAmount = $memberIncome;
            // income is 5% of church income
        } else {
            $contributionAmount = ( $memberIncome * $memberContrRate )/100 ;
        }

        //$contributionAmount = $memberData->salutation_id;
        return $contributionAmount;
    }

    public function contributorContributionAmount( $contributorID, $memberID ) {

        $memberIncome = 0;
        #start:: get member income
        $memberIncomeData = MemberMonthlyIncome::where( 'member_id', $memberID )->where( 'status', 'CONTRIBUTED' )->first();
        if ( $memberIncomeData ) {
            $memberIncome = $memberIncomeData->member_monthly_income;
        }

        #End:: get member income

        #Start:: get contribution
        $memberData = Member::find( $memberID );
        $contributorData = Contributor::find( $contributorID );

        $contributionAmount   = 0;
        $getcontributionRate  = ContributorCatContrStructure::where( 'member_salutation_id', $memberData->member_salutation_id )->where( 'contributor_category_id', $contributorData->contributor_type_id )-> where( 'status', 'ACTIVE' )->first();

        if ( $getcontributionRate ) {
            $contributionAmount   = ( $memberIncome * $getcontributionRate->contributor_contribution_rate )/100;
        }
        #End:: get contribution

        return $contributionAmount;
    }

    public function contributionReverseComputation( $newContribution, $memberID, $contributorID ) {
        $memberData = Member::find( $memberID );
        $contributorData = Contributor::find( $contributorID );

        $memberIncome = 0;
        #start:: get member income
        $memberIncomeData = MemberMonthlyIncome::where( 'member_id', $memberID )->where( 'status', 'CONTRIBUTED' )->first();
        if ( $memberIncomeData ) {
            $memberIncome = $memberIncomeData->member_monthly_income;
        }
        // get old contributor Monthly Income

        $contributor_contribution = 0;
        $newDerivedMonhtlyIncome  = 0;
        $getcontributionRate = ContributorCatContrStructure::where( 'member_salutation_id', $memberData->member_salutation_id )->where( 'contributor_category_id', $contributorData->contributor_type_id )-> where( 'status', 'ACTIVE' )->first();

        if ( $getcontributionRate ) {
            $newDerivedMonhtlyIncome  = ( 100* $newContribution )/$getcontributionRate->member_contribution_rate;
            $contributor_contribution = ( $newDerivedMonhtlyIncome * $getcontributionRate->contributor_contribution_rate )/100 ;
        }

        if ( $memberData->salutation_id == 1 ) {
            // Seniour Pastor
            $contributorMonthlyIncome = ( 100* $newContribution )/$getcontributionRate->contributor_contribution_rate;
            // income is 5% of church income
        } else {
            $contributorMonthlyIncome = $this->contributorMonthlyIncome( $contributorID );
        }

        $returnDataArr = array();
        $returnDataArr[ 'monthly_income' ]             = $newDerivedMonhtlyIncome;
        $returnDataArr[ 'contributor_monthly_income' ] = $contributorMonthlyIncome;
        $returnDataArr[ 'contributor_contribution' ]   = $contributor_contribution;

        return $returnDataArr;
    }
    public function arrearTotalContribution($sectionID, $arear_date){
        $totalContribution = 0;
        $contributionDate = date('Y-m', strtotime($arear_date));
        //START:: Current Active Member
        $getCurrentContributorMember = ContributorMember::join( 'contributors', 'contributors.id', '=', 'contributor_members.contributor_id' )
        ->where( 'contributors.section_id', $sectionID )
        ->where( 'contributor_members.start_date', '<=', $contributionDate )
        ->where( 'contributor_members.end_date', 'NULL' )
        ->where( 'contributor_members.status', 'ACTIVE' )
        ->get();

        foreach ( $getCurrentContributorMember AS $memberData ) { 
            $totalContribution+= $memberData->getMemberContributionAmount( $memberData->contributor_id, $memberData->member_id )+$memberData->getContributorContributionAmount( $memberData->contributor_id, $memberData->member_id );
        }
        //END:: Current Active Member

        //START:: Qualifying member
        $getQualifyingContributorMember = ContributorMember::join( 'contributors', 'contributors.id', '=', 'contributor_members.contributor_id' )
        ->where( 'contributors.section_id', $sectionID )
        ->where( 'contributor_members.start_date', '<=', $contributionDate )
        ->where( 'contributor_members.end_date', '>=', $contributionDate )
        ->where( 'contributor_members.end_date', '!=', 'NULL' )
        ->where( 'contributor_members.status', 'ACTIVE' )
        ->get();

        foreach ( $getQualifyingContributorMember AS $qualifiedMembers ) {
            $totalContribution+= $qualifiedMembers->getMemberContributionAmount( $qualifiedMembers->contributor_id, $qualifiedMembers->member_id )+$qualifiedMembers->getContributorContributionAmount( $qualifiedMembers->contributor_id, $qualifiedMembers->member_id );
        }

        return $totalContribution;
        //END:: Qualifying member
    }
    public function arrearRegister( $section_id, $contribution_period ) {
                    
                    $registerArrear = new Arrear;
                    $registerArrear->section_id     = $section_id;
                    $registerArrear->arrear_period  = $contribution_period;
                    $registerArrear->penalty_amount = 0;
                    $registerArrear->status         = 'ACTIVE';
                    $registerArrear->save();

                    $getCurrentContributorMember = ContributorMember::join( 'contributors', 'contributors.id', '=', 'contributor_members.contributor_id' )
                    ->where( 'contributors.section_id', $section_id )
                    ->where( 'contributor_members.start_date', '<=', $contribution_period )
                    ->where( 'contributor_members.end_date', 'NULL' )
                    ->where( 'contributor_members.status', 'ACTIVE' )
                    ->get();

                    if($getCurrentContributorMember->count() > 0){
                        foreach($getCurrentContributorMember as $data){
                            $pushArrearDetails = new ArrearDetail;
                            $pushArrearDetails->arrear_id = $registerArrear->id;
                            $pushArrearDetails->contributor_id = $data->contributor_id;
                            $pushArrearDetails->member_id = $data->member_id;
                            $pushArrearDetails->member_monthly_income = $data->getMemberMonthlyIncome( $data->member_id );
                            $pushArrearDetails->member_contribution = $data->getMemberContributionAmount( $data->contributor_id, $data->member_id );
                            $pushArrearDetails->contributor_contribution = $data->getContributorContributionAmount( $data->contributor_id, $data->member_id );
                            $pushArrearDetails->arrear_amount =$data->getMemberContributionAmount( $data->contributor_id, $data->member_id ) + $data->getContributorContributionAmount( $data->contributor_id, $data->member_id );
                            $pushArrearDetails->arrear_penalty_amount =0;
                            $pushArrearDetails->status='ACTIVE';
                            $pushArrearDetails->processing_status='ACTIVE';
                            $pushArrearDetails->save();
                        }
                    }
                    //END:: get Active Existing members
            
                    //START:: Qualifying member
                    $getQualifyingContributorMember = ContributorMember::join( 'contributors', 'contributors.id', '=', 'contributor_members.contributor_id' )
                    ->where( 'contributors.section_id', $section_id )
                    ->where( 'contributor_members.start_date', '<=', $contribution_period )
                    ->where( 'contributor_members.end_date', '>=', $contribution_period )
                    ->where( 'contributor_members.end_date', '!=', 'NULL' )
                    ->where( 'contributor_members.status', 'ACTIVE' )
                    ->get();

                    if($getQualifyingContributorMember->count() > 0){
                        foreach($getQualifyingContributorMember as $value){
                            $pushArrearDetails = new ArrearDetail;
                            $pushArrearDetails->arrear_id = $registerArrear->id;
                            $pushArrearDetails->contributor_id = $value->contributor_id;
                            $pushArrearDetails->member_id = $value->member_id;
                            $pushArrearDetails->member_monthly_income = $value->getMemberMonthlyIncome( $value->member_id );
                            $pushArrearDetails->member_contribution = $value->getMemberContributionAmount( $value->contributor_id, $value->member_id );
                            $pushArrearDetails->contributor_contribution = $value->getContributorContributionAmount( $value->contributor_id, $value->member_id );
                            $pushArrearDetails->arrear_amount =$value->getMemberContributionAmount( $value->contributor_id, $value->member_id ) + $value->getContributorContributionAmount( $value->contributor_id, $value->member_id );
                            $pushArrearDetails->arrear_penalty_amount =0;
                            $pushArrearDetails->status='ACTIVE';
                            $pushArrearDetails->processing_status='ACTIVE';
                            $pushArrearDetails->save();
                            
                        }
                    }
                    //END:: Qualifying member

    }

    public function arrearsPenaltyComputation( $arrearID, $current_date) {
        $getArrearData = Arrear::find( $arrearID );
        $arrear_period = $getArrearData->arrear_period.'-01';
        $arrearDaysElapsed = $this->arrearElapsedDaysAlgorithm( $arrear_period, $current_date );

        $getArrearControls = ArrearRecognition::where( 'status', 'ACTIVE' )->first();
        $gracePeriodDays = $getArrearControls->grace_period_days;

        if($arrearDaysElapsed >$gracePeriodDays  ){
            $arrearPenaltyDays = $arrearDaysElapsed- $gracePeriodDays;
            $months = $arrearPenaltyDays / 30;
        }else{
            $months = 0;
        }

        $totalRate = ($getArrearControls->penalty_rate/100) * $months;
        return $totalRate;
    }

    public function arrearElapsedDaysAlgorithm( $contribution_period, $current_date ) {
        // get number of days in the month
        $paymentDate        = Carbon::parse( $current_date );
        $contributionPeriod = Carbon::parse( $contribution_period );
        $daysDifferent      = $paymentDate->diffInDays( $contributionPeriod );


        $dateSegmentArr = explode( '-', $contribution_period);
        $year  = $dateSegmentArr[ 0 ];
        $month = $dateSegmentArr[ 1 ];
        $day   = $dateSegmentArr[ 2 ];// 

        $daysInMonth = Carbon::createFromDate( $year, $month )->daysInMonth;

        if($daysDifferent > 0 && $daysDifferent > $daysInMonth){
            $daysElapsed = $daysDifferent - $daysInMonth;
        }else{
            $daysElapsed = 0;
        }
        return $daysElapsed;
    }

}

<?php
namespace App\Lib;
use App\Models\Arrear;
use App\Models\Contribution;
use App\Models\ArrearRecognition;
use App\Models\ContributionDetail;
use App\Models\ContributorCatContrStructure;
use App\Models\Contributor;
use App\Models\ContributorIncomeTracker;
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
        $newDerivedMonhtlyIncome = 0;
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
        $returnDataArr[ 'monthly_income' ] = $newDerivedMonhtlyIncome;
        $returnDataArr[ 'contributor_monthly_income' ] = $contributorMonthlyIncome;
        $returnDataArr[ 'contributor_contribution' ] = $contributor_contribution;

        return $returnDataArr;
    }

    public function arrearRegister($contributionID){
        $updateContribution = Contribution::find( $contributionID );
        $getArrearControls = ArrearRecognition::where('status','ACTIVE')->first();
            
        $paymentDate = Carbon::parse($updateContribution->payment_date);
        $currentDate = Carbon::parse(date('Y-m-d'));
        $delayedDays = $paymentDate->diffInDays($currentDate);
        $months = ceil($delayedDays / 30);
        
        if($delayedDays > $getArrearControls->grace_period_days){

            if($months > 0){
                $getMembersContritbution = ContributionDetail::where('contribution_id', $contributionID)->where('status','ACTIVE')->get();
    
                if($getMembersContritbution){
                    foreach($getMembersContritbution as $data){
                        $registerArrear = new Arrear;
                        $registerArrear->contribution_details_id = $data->id;
                        $registerArrear->arrear_period = $updateContribution->contribution_period;
                        $registerArrear->status ='ACTIVE';
                        $registerArrear->save();
                    }
                }
            }

        }
    }
}

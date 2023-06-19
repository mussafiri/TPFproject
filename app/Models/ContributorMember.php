<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContributorMember extends Model
{
    use HasFactory;

    public function member(){
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function contributor(){
        return $this->belongsTo(Contributor::class, 'contributor_id');
    }

    public function memberMonthlyIncome($memberID){
        $memberIcome=120000;
        return $memberIcome;
    } 

    public function getMemberContributionAmount($memberID){
        $memberContribution=20000;
        return $memberContribution;
    }

    public function getContributorContributionAmount($memberID){
        $contributorContribution=20000;
        return $contributorContribution;
    }
}

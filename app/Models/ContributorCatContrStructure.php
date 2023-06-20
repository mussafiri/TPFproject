<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContributorCatContrStructure extends Model
{
    use HasFactory;

    public function contributorType(){
        return $this->belongsTo(ContributorType::class, 'contributor_category_id');
    }
    public function memberSalutation(){
        return $this->belongsTo(MemberSalutation::class, 'member_salutation_id');
    }
    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }
}

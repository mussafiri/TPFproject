<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contributor extends Model {
    use HasFactory;

    public function createdBy() {
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function section() {
        return $this->belongsTo( Section::class, 'section_id' );
    }

    public function contributor_type() {
        return $this->belongsTo( ContributorType::class, 'contributor_type_id' );
    }
}

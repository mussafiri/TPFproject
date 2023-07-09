<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Member extends Authenticatable implements AuthenticatableContract
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard = 'member';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /** 
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function createdBy() {
        return $this->belongsTo( User::class, 'created_by' );
    }
    public function salutationTitle() {
        return $this->belongsTo( MemberSalutation::class, 'member_salutation_id' );
    }
    public function contributor() {
        return $this->belongsTo(Contributor::class, 'contributor_id' );
    }
    public function idAttachment() {
        return $this->belongsTo(MemberIdentityType::class, 'id_type_id' );
    }

}

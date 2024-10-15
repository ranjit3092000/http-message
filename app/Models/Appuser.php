<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Appuser extends Authenticatable implements JWTSubject
{

    public $table = 'appuser';
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = ['email', 'password','name'];

    protected $primaryKey = 'id';


    public function getJWTIdentifier()
    {
        return $this->getKey();  // Usually the primary key of the model
    }

    /**
     * Return a key-value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}

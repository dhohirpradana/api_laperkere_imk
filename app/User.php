<?php

// namespace App;

// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Tymon\JWTAuth\Contracts\JWTSubject;

// class User extends Authenticatable implements JWTSubject
// {
//
// protected $fillable = [
//     'nama',
//     'email',
//     'password',
//     'hp',
//     'foto',
//     'is_deleted',
//     'created_at',
//     'updated_at',
// ];
// }

namespace App;
use Laravel\Passport\HasApiTokens;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable
{
    protected $fillable = [
        'nama',
        'email',
        'password',
        'hp',
        'foto',
        'is_deleted',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    use HasApiTokens, Notifiable;

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

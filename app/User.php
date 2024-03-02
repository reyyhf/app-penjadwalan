<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use SoftDeletes, Authenticatable;
    protected $table = 'users';
    protected $fillable = [
        'employee_id',
        'position_id',
        'name',
        'email',
        'password',
        'email_verified_at'
    ];
}

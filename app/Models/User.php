<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // Kalau connection default MySQL, ga perlu declare $connection

    protected $table = "users"; // table-nya 'users'

    protected $fillable = [
        'username',
        'email',
        'password', // tadi salah nulis 'passowrd'
    ];
}

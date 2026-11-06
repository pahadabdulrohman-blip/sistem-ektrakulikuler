<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilePhoto extends Model
{
    protected $fillable = [
        'username',
        'role',
        'photo_path',
    ];
}
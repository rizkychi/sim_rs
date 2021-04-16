<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cr_user extends Model
{
    use HasFactory;

    protected $table = 'cr_user';

    protected $hidden = [
        'kunci',
        'kunci_awal',
    ];
}

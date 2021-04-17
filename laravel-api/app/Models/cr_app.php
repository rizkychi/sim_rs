<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cr_app extends Model
{
    use HasFactory;

    protected $table = 'cr_app';

    const ID = 'rs-api';
}

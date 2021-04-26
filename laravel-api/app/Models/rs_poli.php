<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rs_poli extends Model
{
    use HasFactory;

    protected $table = 'rs_poli';

    protected $primaryKey = 'poli_id'; 

    protected $keyType = 'string';

    public $incrementing = false;
    
    public $timestamps = false;
}

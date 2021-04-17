<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cr_user extends Model
{
    use HasFactory;

    protected $table = 'cr_user';

    protected $primaryKey = 'user_id'; 

    protected $keyType = 'string';

    public $incrementing = false;
    
    public $timestamps = false;

    const PERAN = 'admin';

    protected $hidden = [
        'kunci',
        'kunci_awal',
    ];

    public function token()
    {
        return $this->hasOne(cr_token::class, 'user_id', 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cr_token extends Model
{
    use HasFactory;

    protected $table = 'cr_token';

    protected $primaryKey = 'token_id'; 

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;

    public function cr_user()
    {
        return $this->belongsTo(cr_user::class, 'user_id', 'user_id');
    }
}

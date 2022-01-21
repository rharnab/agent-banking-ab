<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{
    public function user(){
        return $this->belongsTo(User::class,'created_user_id');
    }
    
}

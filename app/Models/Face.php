<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Face extends Model
{
    public function customer(){
        return $this->belongsTo(Customer::class);
    }

}

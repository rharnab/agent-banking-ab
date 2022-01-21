<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class VerifiedCustomer extends Model
{
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function face(){
        return $this->belongsTo(Face::class, 'customer_id', 'customer_id');
    }

    public function ec(){
        return $this->belongsTo(Ecdata::class, 'nid_number', 'nid_number');
    }

    public function score(){
        return $this->belongsTo(Score::class, 'customer_id', 'customer_id');
    }
}

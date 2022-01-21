<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Face;

class Customer extends Model
{
    public function face(){
        return $this->hasOne(Face::class);
    }

    public function score(){
        return $this->hasOne(Score::class);
    }

    public function ec(){
        return $this->hasOne(ECdata::class, 'nid_number', 'nid_number');
    }

}

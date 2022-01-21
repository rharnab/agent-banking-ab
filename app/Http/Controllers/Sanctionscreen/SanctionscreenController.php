<?php

namespace App\Http\Controllers\Sanctionscreen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SanctionscreenController extends Controller
{
    public function sanctionscreen(){

    	return view('super-admin.paramete-setup.sanction.sanction_screen_setup');

    }

     public function sanctionscreenlistupload(){

    	return view('super-admin.paramete-setup.sanction.sanction_screen_list_upload');

    }
}

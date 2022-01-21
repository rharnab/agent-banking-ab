<?php

namespace App\Http\Controllers\Utilitybill;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UtilitybillController extends Controller
{
    public function wasa(){

   		 return view('utility-bill/wasa');

	}

	 public function wasagetdata(){

   		 return view('utility-bill/wasagetdata');

	}


	public function dpdc(){

   		 return view('utility-bill/dpdc');

	}

	public function dpdcaction(){

   		 return view('utility-bill/dpdcaction');

	}


	public function titas(){

   		 return view('utility-bill/titas');

	}

	public function titasaction(){

   		 return view('utility-bill/titasaction');

	}

	public function desco(){

   		 return view('utility-bill/desco');

	}

	public function descoaction(){

   		 return view('utility-bill/descoaction');

	}

	public function schoolfees(){

   		 return view('utility-bill/schoolfees');

	}

	public function creditcardbill(){

   		 return view('utility-bill/creditcardbill');

	}

}

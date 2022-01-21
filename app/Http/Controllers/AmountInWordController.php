<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class AmountInWordController extends Controller
{

    public function numberConverToWord(Request $request){
        $number = number_format($request->amount,2);
        return $this->amountInWord($number);
    }
    
    public function amountInWord($number){
        $number      = str_replace(",", "", $number);
        $numberArray = explode(".", $number);
        if($numberArray[1] > 0){
            $data = $this->converNumberToWord($numberArray[0])." taka & ".$this->converNumberToWord($numberArray[1])." paisa only";
        }else{
            $data = $this->converNumberToWord($numberArray[0])." Tk only ";
        }
        return $data;
    }


    
    public function converNumberToWord($number) 
    { 
        $my_number = $number;
        if (($number < 0) || ($number > 999999999)) { 
            throw new Exception("Number is out of range");
        } 
        $Kt      = floor($number / 10000000);  /* Koti */
        $number -= $Kt * 10000000;
        $Gn      = floor($number / 100000);    /* lakh  */
        $number -= $Gn * 100000;
        $kn      = floor($number / 1000);      /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn      = floor($number / 100);       /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn      = floor($number / 10);        /* Tens (deca) */
        $n       = $number % 10;               /* Ones */
        $res     = "";
        if ($Kt) 
        { 
            $res .= $this->converNumberToWord($Kt) . " Crore "; 
        } 
        if ($Gn) 
        { 
            $res .= $this->converNumberToWord($Gn) . " Lac"; 
        } 
        if ($kn) 
        { 
            $res .= (empty($res) ? "" : " ") . 
                $this->converNumberToWord($kn) . " Thousand"; 
        } 
        if ($Hn) 
        { 
            $res .= (empty($res) ? "" : " ") . 
                $this->converNumberToWord($Hn) . " Hundred"; 
        } 
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
            "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
            "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
            "Nineteen"); 
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
            "Seventy", "Eigthy", "Ninety"); 
        if ($Dn || $n) 
        { 
            if (!empty($res)) 
            { 
                $res .= "  "; 
            } 
            if ($Dn < 2) 
            { 
                $res .= $ones[$Dn * 10 + $n]; 
            } 
            else 
            { 
                $res .= $tens[$Dn]; 
                if ($n) 
                { 
                    $res .= "-" . $ones[$n]; 
                } 
            } 
        } 
        if (empty($res)) 
        { 
            $res = "zero"; 
        } 
        return $res; 
    }





}

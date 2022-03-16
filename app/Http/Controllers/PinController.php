<?php

namespace App\Http\Controllers;

use App\Models\Pin;
use Illuminate\Http\Request;

class PinController extends Controller
{
    
    public function list()
    {
        $pins = Pin::orderBy('created_at', 'desc')->get();
        
        return view('home', compact('pins'));
    }

    public function create()
    {
        $input = ['pin' => $this->generateUniqueCode()];
        $code = Pin::create($input);

        return $code ?
        redirect()->route('home')->with('success', 'New pin created successfully.') :
        redirect()->route('home')->with('warning', 'Error');

    }

    public function generateUniqueCode()
    {

        $code = random_int(1000, 9998);
        $arr = strval( $code ) ;
        $length = strlen($arr);
        for ($i = 0; $i < $length-1; $i++) {
            if ($arr[$i] === $arr[$i + 1] ){
                break;
            }elseif($code = Pin::where("pin", "=", $code)->first()){
                break;
            }else {
                $code = random_int(1000, 9998);

            }
        }
        return $code;
        
       

    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function htest(){
$arr =[2, -1, 5, 6, 0, -3];
$this->plusMinus($arr);
}

   public function plusMinus($arr) {
       $len = sizeof($arr);
        $positiveCount = 0;
         $negativeCount = 0;
         $zeroCount = 0;
       for ($i = 0; $i < $len; $i++) {
           if ($arr[$i] > 0) {
               $positiveCount++;
           }
           else if ($arr[$i] < 0) {
               $negativeCount++;
           }
           else if ($arr[$i] == 0) {
               $zeroCount++;
           }
       }
       echo $positiveCount / $len."     ";
       echo $negativeCount / $len."     ";
       echo $zeroCount / $len."     ";
      echo "/n";
    }
}

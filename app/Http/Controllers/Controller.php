<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
  function showhome(){
    return view('pages/index');
  }
    function showabout()
    {
        return view('pages/about');
    }
    function showcontact()
    {
        return view('pages/contact');
    }
    function showcauses()
    {
        return view('pages/causes');
    }
    function shownews()
    {
        return view('pages/news');
    }
}

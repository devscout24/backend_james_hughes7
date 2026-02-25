<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Lead;
use Carbon\Carbon;

class BackendController extends Controller
{
    // dashboard show
    public function index()
    {

      $totalleads=Lead::count();
      $leads=Lead::orderBy("created_at","desc")->take(5)->get();


        return view('backend.layouts.dashboard',compact('totalleads','leads'));
    }



}

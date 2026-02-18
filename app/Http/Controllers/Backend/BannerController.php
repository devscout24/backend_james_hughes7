<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
       return view('backend.layouts.banner.index');
    }

    public function store(Request $request)
    {
        // Logic to store a new banner
    }

    public function edit($id)
    {
        // Logic to edit a specific banner
    }

    public function update(Request $request, $id)
    {
        // Logic to update a specific banner
    }

    public function destroy($id)
    {
        // Logic to delete a specific banner
    }
}

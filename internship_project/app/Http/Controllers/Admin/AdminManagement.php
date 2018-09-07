<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminManagement extends Controller
{
    public function index(){
    	return view('layouts.admin.admin');
    }
}

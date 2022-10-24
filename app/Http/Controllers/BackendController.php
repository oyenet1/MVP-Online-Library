<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    //
    public function home()
    {
        return view('home');
    }

    public function admin()
    {
        return view('admin.panel');
    }

    // book collections
    public function library()
    {
        return view('books.library');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ViewsController extends Controller
{
    public function home()
    {
        return view('landing');
    }

    public function playback()
    {
        return view('playback');
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function profile()
    {
        return view('profile');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RenderController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function dashboard(){
        return view('task.index');
    }

    public function register(){
        return view('register');
    }
}

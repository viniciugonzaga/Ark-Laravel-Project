<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Adicione exatamente este bloco abaixo:
    public function index()
    {
        return view('welcome'); 
    }
}
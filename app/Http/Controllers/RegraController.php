<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegraController extends Controller
{
    public function index()
    {
        return view('regras.index');
    }

    public function download()
    {
        $file = public_path('pdfs/manual-ark.pdf');

        return response()->download($file);
    }
}
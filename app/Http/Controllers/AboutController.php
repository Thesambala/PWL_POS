<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function about()
    {
        return "Nama: John Doe <br> NIM: 123456789";
    }
}

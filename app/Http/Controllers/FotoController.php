<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Foto;

class FotoController extends Controller
{
    //
    public function index()
    {
        $lpm = Foto::all();

        $data = ['lpm' => $lpm];

        return $data;
    }
}

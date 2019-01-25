<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class FeatController extends Controller
{
    public function index01 () {
        dd(\TestEchoaa::testEcho());
        return view('index', compact('hello', 'hello_array'));
    }





}

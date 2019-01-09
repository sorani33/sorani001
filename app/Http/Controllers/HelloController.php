<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
// use App\Passport;


class HelloController extends Controller
{
  public function index () {
      $hello = user::find(1)->passport;
      dd($hello);
      return $hello;



      return view('index', compact('hello', 'hello_array'));
  }}

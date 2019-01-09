<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\mobile;
// use App\Passport;


class HelloController extends Controller
{
  public function index () {
      // $hello = user::find(1)->mobile;
      $users = user::all();
      foreach ($users as $user) {
        var_dump($user);
        dd($user->mobile);
      }
      dd($hello);
      return $hello;



      return view('index', compact('hello', 'hello_array'));
  }}

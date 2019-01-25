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
    }



    public function index02 () {
        session()->put(['email' => 'user@example.com']);
        return session()->get('email');
    }



    public function index03 () {
      // 削除 (指定の値を個別に)
      // session()->forget('email');
        return session()->all();
    }


}

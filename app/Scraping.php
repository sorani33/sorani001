<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scraping extends Model
{
    public static function hoge ($match) {
        $fuga = self::fuga($match);
    }


    public static function fuga ($match) {
        dd($match."www");
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uploader extends Model
{
    //
    protected $fillable = ['username'];


    public function pic_thum(){
        $fnamebase = \Config::get('fpath.thum').$this->id."/"."thum.";
        // dd($fnamebase);
        if(file_exists(public_path().$fnamebase."gif")){
            return $fnamebase."gif";
        }else if(file_exists(public_path().$fnamebase."png")){
            return $fnamebase."png";
        }else if(file_exists(public_path().$fnamebase."jpg")){
            return $fnamebase."jpg";
        }else if(file_exists(public_path().$fnamebase."jpeg")){
            return $fnamebase."jpeg";
        }else{
            return \Config::get('fpath.noimage');
        }
    }
}

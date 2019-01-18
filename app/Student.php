<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
  public $timestamps = false; //timesatampを利用しない
  protected $fillable = ['dept_id', 'name', 'email'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user extends Model
{
    public function mobile() {
      return $this->hasMany(mobile::class);
    }
}

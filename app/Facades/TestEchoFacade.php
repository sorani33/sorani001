<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class TestEchoFacade extends Facade
{
  protected static function getFacadeAccessor()
  {
    return 'TestEcho';
  }
}

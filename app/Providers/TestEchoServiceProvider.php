<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application; //追記した。サービスコンテナそのもの。
use App\Helpers\TestEchoHelper;  //追記した。使いたいヘルパー。


class TestEchoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->bind('TestEcho', function(Application $app){
        return new TestEchoHelper();
      });    }
}

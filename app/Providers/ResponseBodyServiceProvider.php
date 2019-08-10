<?php

namespace App\Providers;

use App\ResponseBody;
use function foo\func;
use Illuminate\Support\ServiceProvider;

class ResponseBodyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
         $this->app->bind('App\ResponseBody',function ($app){
             return new ResponseBody();
         });
    }
}

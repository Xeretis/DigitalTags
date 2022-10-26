<?php

namespace App\Helpers\JSend\Providers;

use Illuminate\Support\ServiceProvider;

class JSendServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (!function_exists("jsend")) {
            require_once '../helpers.php';
        }
    }

    public function boot() {}
}

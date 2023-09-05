<?php

namespace Agenciafmd\Facilita\Providers;

use Illuminate\Support\ServiceProvider;

class FacilitaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // 
    }

    public function register()
    {
        $this->loadConfigs();
    }

    protected function loadConfigs()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-facilita.php', 'laravel-facilita');
    }
}

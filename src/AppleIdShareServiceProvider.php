<?php

namespace AppleIdShare;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppleIdShareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // 合并配置文件
        $this->mergeConfigFrom(
            __DIR__.'/../config/appleid.php', 'appleid'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 发布配置文件
        $this->publishes([
            __DIR__.'/../config/appleid.php' => config_path('appleid.php'),
        ], 'appleid-config');

        // 发布视图文件
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/appleid-share'),
        ], 'appleid-views');

        // 加载视图
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'appleid-share');

        // 注册路由
        $this->registerRoutes();
    }

    /**
     * 注册路由
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::get('/share/appleid', [\AppleIdShare\ShareController::class, 'showAppleId'])
            ->name('appleid.share');
    }
}

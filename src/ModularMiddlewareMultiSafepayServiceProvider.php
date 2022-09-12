<?php

namespace ModularMultiSafepay\ModularMultiSafepay;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ModularMiddlewareMultiSafepayServiceProvider extends PackageServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MultisafepayClient::class, function () {
            return new MultisafepayClient(config('multisafepay.apiUrl'));
        });

        $this->app->singleton(MultiSafepay::class, function(){
            return new MultiSafepay(new MultisafepayClient(config('multisafepay.apiUrl')));
        });
    }

    public function boot() : void
    {
        $this->publishes([
            __DIR__.'/../config/multisafepay.php' => config_path('multisafepay.php'),
        ], 'modular-middleware');
        $this->loadRoutesFrom(base_path('routes/multisafepay.php'));
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('modular-middleware-multisafepay')
            ->hasConfigFile();
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 21/07/2015
 * Time: 00:33
 */

namespace Samcrosoft\MultiAuth\Providers;


use Illuminate\Auth\AuthServiceProvider as LaravelAuthServiceProvider;
use Samcrosoft\MultiAuth\Manager\Resolver\Auth\MultiAuthResolver;


/**
 * Class MultiAuthServiceProvider
 * @package Samcrosoft\MultiAuth\Providers
 */
class MultiAuthServiceProvider extends LaravelAuthServiceProvider
{

    public function register()
    {
        /*
         * Register the Session Service Provider
         */
        $this->app->register(MultiAuthSessionServiceProvider::class);

        /*
         * Call the register from the parent
         */
        parent::register();
    }
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registerAuthenticator()
    {
        $this->app->singleton('auth', function ($app) {
            // Once the authentication service has actually been requested by the developer
            // we will set a variable in the application indicating such. This helps us
            // know that we need to set any queued cookies in the after event later.
            $app['auth.loaded'] = true;
            return new MultiAuthResolver($app);
        });

        $this->app->singleton('auth.driver', function ($app) {
            $oDriver = $app['auth']->driver();
            return $oDriver;
        });
    }

}
<?php
namespace Samcrosoft\MultiAuth\Providers;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Session\SessionManager;
use Illuminate\Session\SessionServiceProvider;
use Samcrosoft\MultiAuth\Manager\Resolver\Auth\MultiAuthResolver;
use Samcrosoft\MultiAuth\Manager\Resolver\Session\MultiAuthSessionResolver;

/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 20/07/2015
 * Time: 23:31
 */

/**
 * Class MultiAuthSessionServiceProvider
 * @package Samcrosoft\MultiAuth\Providers
 */
class MultiAuthSessionServiceProvider extends SessionServiceProvider
{

    /**
     * @const
     */
    const SESSION_SINGLETON_NAME = "session";

    /**
     * Register the session manager instance.
     *
     * @return void
     */
    protected function registerSessionManager()
    {
        $sCookieName = (new MultiAuthSessionResolver($this->app))->resolveAppropriateSessionCookieName();

        /** @var Repository $oConfigRepository */
        $oConfigRepository = $this->app['config'];
        $oConfigRepository->set('session.cookie', $sCookieName);

        /*
         * This allows support for the cartalyst sentinel
         */
        $sRememberMeName = "remember_me";
        $oConfigRepository->set('cartalyst.sentinel.session', $sCookieName);
        $oConfigRepository->set('cartalyst.sentinel.cookie', "{$sRememberMeName}_{$sCookieName}");

        $this->app->singleton(self::SESSION_SINGLETON_NAME, function ($app) {
            return new SessionManager($app);
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path(MultiAuthResolver::MULTI_AUTH_CONFIG_FILE.'.php')
        ]);
    }


}
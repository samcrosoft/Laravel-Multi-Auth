<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 20/07/2015
 * Time: 23:37
 */

namespace Samcrosoft\MultiAuth\Manager\Auth;


use Illuminate\Auth\AuthManager as LaravelAuthManager;
use Samcrosoft\MultiAuth\Manager\Guard\MultiAuthGuard;

/**
 * Class MultiAuthManager
 * @package Samcrosoft\MultiAuth\Manager\Auth
 */
class MultiAuthManager extends LaravelAuthManager
{
    /**
     * Multi-auth configuration.
     *
     * @var array
     */
    protected $config;
    /**
     * Multiauth provider name.
     *
     * @var string
     */
    protected $name;


    public function __construct($app, $name)
    {
        parent::__construct($app);
        $this->name = $name;
    }


    /**
     * Create an instance of the Eloquent driver.
     *
     * @return MultiAuthGuard
     */
    public function createEloquentDriver()
    {
        $provider = $this->createEloquentProvider();
        return new MultiAuthGuard($provider, $this->app['session.store'], $this->name);
    }

}
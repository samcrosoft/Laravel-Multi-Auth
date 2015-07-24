<?php
namespace Samcrosoft\MultiAuth\Manager\Resolver\Auth;


use Samcrosoft\MultiAuth\Manager\Auth\MultiAuthManager;

/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 20/07/2015
 * Time: 23:42
 */

/**
 * Class MultiAuthResolver
 * @package Samcrosoft\MultiAuth\Manager\Resolver
 */
class MultiAuthResolver
{
    /**
     * @const
     */
    const MULTI_AUTH_CONFIG_FILE = 'samcrosoft.multiauth';

    /**
     * @const
     */
    const MULTI_SESSION_COOKIE_RESOLVER_KEY = "session_cookie_resolver";

    /**
     * Registered multi-auth providers.
     *
     * @var array
     */
    protected $providers = [];


    public function __construct($app)
    {
        $sKey = self::MULTI_AUTH_CONFIG_FILE.".". self::MULTI_SESSION_COOKIE_RESOLVER_KEY;
        $aConfig = $app['config'][$sKey];
        $aKeys = array_keys($aConfig);
        foreach ($aKeys as $iIndex => $sKey) {
            $this->providers[$sKey] = new MultiAuthManager($app, $sKey);
        }
    }

    /**
     * @param $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments = [])
    {
        if (array_key_exists($name, $this->providers)) {
            $oProvider = $this->providers[$name];
        } else {
            /*
             * If you cant resolve the appropriate provider, use the basic one
             */
            $oProvider = head($this->providers);
        }


        /*
         * Perform the main call
         */
        $oReturn = call_user_func_array([$oProvider, $name], $arguments);
        return $oReturn;
    }
}
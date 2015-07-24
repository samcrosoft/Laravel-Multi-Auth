<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 20/07/2015
 * Time: 23:55
 */

namespace Samcrosoft\MultiAuth\Manager\Guard;


use Illuminate\Auth\Guard as LaravelGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class MultiAuthGuard
 * @package Samcrosoft\MultiAuth\Manager\Guard
 */
class MultiAuthGuard extends LaravelGuard
{

    /**
     * @var string
     */
    var $sName;

    /**
     * Create a new authentication guard.
     *
     * @param  UserProvider $provider
     * @param  SessionInterface $session
     * @param string $sName
     * @param  Request $request
     */
    public function __construct(UserProvider $provider,
                                SessionInterface $session,
                                $sName,
                                Request $request = null)
    {

        parent::__construct($provider, $session, $request);

        /*
         * Save the auth name
         */
        $this->setAuthKeyName($sName);
    }

    /**
     * @param $sName
     */
    public function setAuthKeyName($sName)
    {
        $this->sName = $sName;
    }

    /**
     * @return string
     */
    private function getAuthKeyName()
    {
        $sExtra = $this->sName;
        return $sExtra;
    }

    /**
     * Get the name of the cookie used to store the "recaller".
     * @return string
     */
    public function getRecallerName()
    {
        $sExtra = $this->getAuthKeyName();
        $sReturn = "remember_{$sExtra}".md5(get_class($this));
        return $sReturn;
    }

    /**
     * Get a unique identifier for the auth session value.
     *
     * @return string
     */
    public function getName()
    {
        $sExtra = $this->getAuthKeyName();
        return "login_{$sExtra}".md5(get_class($this));
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 24/07/2015
 * Time: 15:10
 */

namespace Samcrosoft\MultiAuth\Manager\Resolver\Session;


use Illuminate\Contracts\Config\Repository;

/**
 * Class MultiAuthSessionResolver
 * @package Samcrosoft\MultiAuth\Manager\Resolver\Session
 */
class MultiAuthSessionResolver
{
    /**
     * @var
     */
    var $app;

    function __construct($app)
    {
        $this->app = $app;
    }


    /**
     * this method will resolve the appropriate session cookie key name
     * @return string
     */
    public function resolveAppropriateSessionCookieName()
    {
        $sDefaultSessionCookie = $this->app['config']['session.cookie'];
        $sReturn = $sDefaultSessionCookie;

        /** @var Repository $oConfig */
        $oConfig = $this->app['config'];
        $aResolverClosures = $oConfig->get("multiauth.session_cookie_resolver");
        if($aResolverClosures && is_array($aResolverClosures)){
            $oCurrentRequest = $this->app['request'];
            foreach ($aResolverClosures as $sKey=>$oClosure) {
                if(!($oClosure instanceof \Closure))
                    continue;
                else{
                    $bReturn = $oClosure($oCurrentRequest);
                    if($bReturn) {
                        $sReturn = $sKey;
                        break;      // break out of the loop check
                    }
                }
            }
        }

        return $sReturn;
    }


}
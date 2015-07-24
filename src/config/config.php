<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 24/07/2015
 * Time: 15:17
 */

return [
    'session_cookie_resolver' => [
        'cookie_one' => function ($oRequest) {
            /*
             * This Closure should contain the logic for separating a segment of the application
             */
            /** @var \Illuminate\Http\Request $oRequest */
            return strcmp($oRequest->segment(1), "cookie1") <> 0;
        },

        'cookie_two' => function ($oRequest) {
            /** @var \Illuminate\Http\Request $oRequest */
            return strcmp($oRequest->segment(1), "cookie2") == 0;
        }
    ]
];
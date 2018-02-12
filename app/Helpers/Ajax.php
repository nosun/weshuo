<?php

namespace App\Helpers;

use Response;

define('AJAX_SUCCESS', 200);
define('AJAX_INFO', 201);
define('AJAX_DATA_END', 210);
define('AJAX_ARGUMENT_ERROR', 400);
define('AJAX_SIGNATURE_ERROR', 401);
define('AJAX_FORBIDDEN', 403);
define('AJAX_DATA_EMPTY', 404);
define('AJAX_METHOD_NOT_ALLOW', 405);
define('AJAX_UN_PROCESSABLE_ENTITY', 422);
define('AJAX_TOO_MANY_ATTEMPTS', 428);
define('AJAX_TOO_MANY_REQUEST', 429);
define('AJAX_SERVER_ERROR', 500);

class Ajax
{

    private static function ajaxResponse($code, $data = array())
    {
        $out = array(
            'code' => $code
        );

        if (!empty($data)) {
            $out['data'] = $data;
        }

        return Response::json($out)->withHeaders(
            [
                'Access-Control-Allow-Origin' => '*',
                'Expires' => 'Mon, 26 Jul 1997 05:00:00 GMT',
                'Cache-Control' => 'no-store, no-cache, must-revalidate',
                'Cache-Control: post-check=0, pre-check=0' => false,
                'Pragma' => 'no-cache',
            ]
        );
    }

    /**
     * 200
     */
    public static function success($data = array())
    {
        return self::ajaxResponse(AJAX_SUCCESS, $data);
    }

    /**
     * 201
     */
    public static function info($message)
    {
        return self::ajaxResponse(AJAX_INFO, array('message' => $message));
    }

    /**
     * 210
     */
    public static function dataEnd($data)
    {
        return self::ajaxResponse(AJAX_DATA_END, $data);
    }

    /**
     * 400
     */
    public static function argumentsError()
    {
        return self::ajaxResponse(AJAX_ARGUMENT_ERROR);
    }

    /**
     * 400
     */
    public static function signatureError()
    {
        return self::ajaxResponse(AJAX_SIGNATURE_ERROR);
    }

    /**
     * 403
     */
    public static function forbidden()
    {
        return self::ajaxResponse(AJAX_FORBIDDEN);
    }

    /**
     * 404
     */
    public static function dataEmpty()
    {
        return self::ajaxResponse(AJAX_DATA_EMPTY);
    }

    /**
     * 405
     */
    public static function notAllow()
    {
        return self::ajaxResponse(AJAX_METHOD_NOT_ALLOW, ['message' => 'The message is not allowed']);
    }

    /**
     * 422
     */
    public static function dataTypeError()
    {
        return self::ajaxResponse(AJAX_UN_PROCESSABLE_ENTITY, ['message' => 'The request was well-formed but was unable to be followed due to semantic errors.']);
    }

    /**
     * 428
     */
    public static function tooManyAttempts($second)
    {
        return self::ajaxResponse(AJAX_TOO_MANY_ATTEMPTS, ['message' => 'Your attempts has reached the max attempts limit.', 'locked' => $second]);
    }

    /**
     * 500
     */
    public static function serverError($message)
    {
        return self::ajaxResponse(AJAX_SERVER_ERROR, array('message' => $message));
    }

}
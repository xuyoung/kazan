<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        Log::error($e);

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        app('translator')->setLocale('zh-CN');
        $errorCode  = $e->getCode();
        $statusCode = $e->getStatusCode();

        if ($errorCode == 2002) {
            echo json_encode(error_response('0x000022', 'common'));
        } else if ($errorCode == 10061) {
            echo json_encode(error_response('0x000023', 'common'));
        } else {
            if ($statusCode == '404') {
                echo json_encode(error_response('0x000404', 'common'));
            } else if ($statusCode == '401') {
                echo json_encode(error_response('0x000401', 'common'));
            } else {
                echo json_encode(error_response('0x000013', '', json_encode(["file" => $e->getFile(), "line" => $e->getLine()])));
            }
        }
        exit;

        return parent::render($request, $e);
    }
}

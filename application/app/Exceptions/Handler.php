<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        //return parent::render($request, $exception);
        if ($this->isHttpException($exception)) {
            switch ($exception->getStatusCode()) {
    
                // not authorized
                case '403':
                    $result["status"] = array("code" => "403", "response" => "error", "message" => "forbidden request");   
                    $result["result"] = null;         
                    return response()->json($result);   
                break;
    
                // not found
                case '404':
                    $result["status"] = array("code" => "404", "response" => "error", "message" => "request not found");   
                    $result["result"] = null;                
                    return response()->json($result);      
                break;
    
                // internal error
                case '500':
                    $result["status"] = array("code" => "500", "response" => "error", "message" => "internal server error");   
                    $result["result"] = null;        
                    return response()->json($result);        
                break;
    
                default:
                    return $this->renderHttpException($exception);
                break;
            }
        } else {
            return parent::render($request, $exception);
        }
    
        //return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}

<?php

namespace App\Exceptions;

use Illuminate\Support\Arr;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }


        // Checks if the guard is 'admin', 'superuser' else it returns the default
        $guard = Arr::get($exception->guards(), 0);

        switch ($guard) {
            case 'auth':
                $login = 'admin/login';
                break;

            case 'instructor':
                $login = 'instructor/login';
                break;

            default:
                $login = 'login';
                break;
        }

        return redirect()->guest(url($login));
    }
}

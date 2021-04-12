<?php

namespace App\Exceptions;


use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use ApiResponser;

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

        /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof HttpException)
        {
            $code = $exception->getStatusCode();
            $message = Response::$satusTexts[$code];

            return $this->errorReponse($message, $code);
        }

        if ($exception instanceOf ModelNotFoundException)
        {
            $model = strtolower(class_basename($exception->getModel()));

            return $this->errorResponse("Does not exist any instance of {$model} with the given id", Response::HTTP_NOT_FOUND );

        }

         if ($exception instanceOf AuthorizationException)
         {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_FORBIDDEN);
         }

           if ($exception instanceOf AuthenticationException)
         {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_UNAUTHORIZED);
         }

         if ($exception instanceOf ValidationException)
         {
            $errors = $exception->validator->errors()->getMessages();

            return $this->errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
         }

         if (env('APP_DEBUG', false)){
            return parent::render($request, $exception);
         }

        return $this->errorResponse('Unexpected error. Try later', Response::HTTP_INTERNAL_SERVER_ERROR);

    }
}

<?php

namespace App\Exceptions;

use App\Exceptions\exceptions\ApiException;
use App\Exceptions\exceptions\TaskAlreadyCompletedException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
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
    public function register(): void
    {
        $this->renderable(renderUsing: function (Throwable $e, $request) {
            if ($request->is("api/*")) {

                if ($e instanceof ApiException) {
                    return $e->render($request);
                }

                if ($e instanceof ValidationException) {
                    return response()->json([
                        "message" => "Os dados fornecidos são inválidos",
                        "errors" => $e->validator->errors()
                    ], 422);
                }

                if ($e instanceof NotFoundHttpException) {
                    return response()->json([
                        "message" => "Recurso não encontrado",
                    ], 404);
                }

                if ($e instanceof AuthenticationException) {
                    return response()->json([
                        "message" => "Não autenticado",
                    ], 401);
                }



                if ($e instanceof MethodNotAllowedHttpException) {
                    return response()->json([
                        "message" => $e->getMessage(),
                    ], 405);
                }

                if ($e instanceof HttpException) {
                    return response()->json([
                        "message" => $e->getMessage() ?: "Erro na requisição",
                        "errorclass" =>$e::class,
                    ], $e->getStatusCode());
                }


                $message = config('app.debug')
                    ? $e->getMessage()
                    : 'Erro interno do servidor.';

                return response()->json([
                    "message" => $message,
                    "errorclass" =>$e::class,
                ], 500);

            }
        });


    }
}

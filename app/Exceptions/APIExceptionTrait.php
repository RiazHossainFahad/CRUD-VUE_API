<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

use Symfony\Component\HttpFoundation\Response;

trait APIExceptionTrait
{
    public function apiException($req, $e)
    {
        if ($this->isModel($e)) {
            return $this->ModelResponse();
        }
        if ($this->isHttp($e)) {
            return $this->HttpResponse();
        }
        if ($this->isMethod($e)) {
            return $this->MethodResponse();
        }
        // return $this->unknownResponse($req, $e);
        return parent::render($req, $e);
    }

    protected function isModel($e)
    {
        return $e instanceof ModelNotFoundException;
    }

    protected function isHttp($e)
    {
        return $e instanceof NotFoundHttpException;
    }

    protected function isMethod($e)
    {
        return $e instanceof MethodNotAllowedHttpException;
    }


    protected function ModelResponse()
    {
        return response()->json([
            'errors' => "Opps!! Post not found."
        ], Response::HTTP_NOT_FOUND);
    }

    protected function HttpResponse()
    {
        return response()->json([
            'errors' => "Opps!! Incorrect route."
        ], Response::HTTP_NOT_FOUND);
    }

    protected function MethodResponse()
    {
        return response()->json([
            'errors' => "Opps!! Wrong Method."
        ], Response::HTTP_NOT_FOUND);
    }

    protected function unknownResponse($req, $e)
    {
        return response()->json([
            'errors' => "Opps!! Unknown error.",
            'exception' => $e
        ], Response::HTTP_NOT_FOUND);
    }
}
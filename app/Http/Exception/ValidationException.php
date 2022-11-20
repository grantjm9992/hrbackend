<?php

namespace App\Http\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidationException extends HttpException implements ExceptionInterface
{
    protected const CODE = 412;

    public function __construct(string $message)
    {
        parent::__construct(self::CODE, $message);
    }
}

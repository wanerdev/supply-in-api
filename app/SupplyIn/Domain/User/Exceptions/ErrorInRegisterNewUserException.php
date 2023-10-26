<?php

namespace App\SupplyIn\Domain\User\Exceptions;

use Exception;
use Throwable;
class ErrorInRegisterNewUserException extends Exception
{
    protected $code;
    protected $message;

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

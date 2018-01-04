<?php

namespace Exception;

use Throwable;

class MethodNotAllowedException extends \Exception
{
    public function __construct($message = "Invalid method.", $code = 405, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
<?php

namespace Exception;

use Throwable;

class NotFoundException extends \Exception
{
    public function __construct($message = "cannot access this uri.", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
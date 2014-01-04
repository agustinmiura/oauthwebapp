<?php

namespace ArComMiura\OAuthWeb\Exception;

use \RuntimeException as RuntimeException;

class ApplicationException extends RuntimeException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }

}
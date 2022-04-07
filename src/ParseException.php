<?php

namespace Deployhuman\GpsTransformation;

/**
 * Signals that an error has been reached unexpectedly while parsing. 
 * 
 */
class ParseException extends \Exception
{
    //construct the parent class with the message
    public function __construct($message, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

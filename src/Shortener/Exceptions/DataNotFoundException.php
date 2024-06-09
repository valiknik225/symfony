<?php

namespace App\Shortener\Exceptions;

use Exception;

class DataNotFoundException extends Exception
{
    protected $message = 'This data not found.';
}

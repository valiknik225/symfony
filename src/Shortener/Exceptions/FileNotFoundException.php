<?php

namespace App\Shortener\Exceptions;

class FileNotFoundException extends \Exception
{
    protected $message = 'The file does not exist';
}
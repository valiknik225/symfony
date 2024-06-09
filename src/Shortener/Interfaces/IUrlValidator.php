<?php

namespace App\Shortener\Interfaces;

use InvalidArgumentException;

interface IUrlValidator
{
    /**
     * @param string $url
     * @throws InvalidArgumentException
     * @return void
     */
    public function validateUrl(string $url): void;

    /**
     * @param string $url
     * @throws InvalidArgumentException
     * @return void
     */
    public function validateIsRealUrl(string $url): void;
}
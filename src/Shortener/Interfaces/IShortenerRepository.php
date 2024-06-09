<?php

namespace App\Shortener\Interfaces;

use App\Shortener\Exceptions\DataNotFoundException;

interface IShortenerRepository
{
    /**
     * @param string $code
     * @return string|false
     * @throws DataNotFoundException
     */
    public function getUrlByCode(string $code): string|false;

    /**
     * @param string $url
     * @return string|int|false
     * @throws DataNotFoundException
     */
    public function getCodeByUrl(string $url): string|int|false;

    public function codeIsset(string $code): bool;

    public function addNewUrl(string $code, string $url): void;
}
<?php

namespace App\Shortener\Services;

use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\Interfaces\IShortenerRepository;
use App\Shortener\Interfaces\IUrlDecoder;
use InvalidArgumentException;

class UrlDecodeServices implements IUrlDecoder
{
    public function __construct(protected IShortenerRepository $repository)
    {
        //
    }

    /**
     * @param string $code
     * @throws InvalidArgumentException
     * @return string
     */
    public function decode(string $code): string
    {
        try {
            return $this->repository->getUrlByCode($code);
        } catch (DataNotFoundException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}
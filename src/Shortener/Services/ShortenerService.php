<?php

namespace App\Shortener\Services;

use App\Shortener\Interfaces\IUrlDecoder;
use App\Shortener\Interfaces\IUrlEncoder;
use InvalidArgumentException;

class ShortenerService implements IUrlEncoder, IUrlDecoder
{
    public function __construct(protected IUrlEncoder $urlEncoder, protected IUrlDecoder $urlDecoder)
    {
        //
    }

    /**
     * @param string $url
     * @return string
     * @throws InvalidArgumentException
     */
    public function encode(string $url): string
    {
        return $this->urlEncoder->encode($url);
    }

    /**
     * @param string $code
     * @return string
     * @throws InvalidArgumentException
     */
    public function decode(string $code): string
    {
        return $this->urlDecoder->decode($code);
    }
}
<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

use function parse_url;

class FaviconExtension extends AbstractExtension
{

    public function __construct() {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('favicon_url', [$this, 'getFaviconFromUrl']),
            new TwigFunction('print_favicon', [$this, 'imgFavicon'], []),
        ];
    }

    public function getFaviconFromUrl(string $url): string
    {
        $urlParts = parse_url($url);
        return $urlParts['scheme'] . '://' . $urlParts['host'] . '/favicon.ico';
    }

    public function imgFavicon(string $url): string
    {
        return '<img class="avatar" src="'. $this->getFaviconFromUrl($url) .'"  alt="favicon">';
    }
}
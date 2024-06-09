<?php

namespace App\Controller;

use App\Shortener\Interfaces\IUrlDecoder;
use App\Shortener\Interfaces\IUrlEncoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/shortener', name: 'shortener')]
class ShortenerController extends AbstractController
{
    #[Route('/encode', name: 'encode')]
    public function encode(Request $request, IUrlEncoder $encoder): Response
    {
        $url = $request->get('url');
        try {
            if (!$url) {
                throw new \InvalidArgumentException('URL not provided');
            }
            $result = $encoder->encode($url);
        } catch (\InvalidArgumentException $exception) {
            $result = $exception->getMessage();
        }
        return $this->render('templates/shortener/index.html.twig', [
            'result' => $result,
        ]);
    }

    #[Route('/decode/{code}', name: 'decode', requirements: ['code'=>'\w{6,10}'])]
    public function decode(IUrlDecoder $decoder, string $code): Response
    {
        try {
            $result = $decoder->decode($code);
        } catch (\InvalidArgumentException $exception) {
            $result = $exception->getMessage();
        }
        return $this->render('templates/shortener/index.html.twig', [
            'result' => $result,
        ]);
    }
}

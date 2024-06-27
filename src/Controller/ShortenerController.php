<?php

namespace App\Controller;

use App\Entity\Shortener;
use App\Services\IncrementorService;
use App\Services\ShortenerEntityService;
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
            $result = $encoder->encode($url);
        } catch (\InvalidArgumentException $exception) {
            $result = $exception->getMessage();
        }
        return $this->render('shortener/index.html.twig', [
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
        return $this->render('shortener/index.html.twig', [
            'result' => $result,
        ]);
    }

    #[Route('/{shortener}/info', name: 'shortener_info')]
    public function codeInfo(Shortener $shortener): Response
    {
        return $this->render('shortener/show_info.html.twig', [
            'shortener' =>  $shortener,
        ]);
    }

    #[Route('/code_list', name: 'shortener_list')]
    public function allStats(ShortenerEntityService $service): Response
    {
        return $this->render('shortener/user_codes.html.twig', [
            'shortener_list' =>  $service->getAllByUser(),
        ]);
    }

    #[Route('/{code}', name: 'redirect', requirements: ['code'=>'\w{6,8}'])]
    public function redirectUrl(Shortener $shortener, IncrementorService $incrementorService): Response
    {
        $incrementorService->incrementAndSave($shortener);
        return $this->redirect($shortener->getUrl());
    }
}

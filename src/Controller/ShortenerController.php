<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShortenerController extends AbstractController
{
    #[Route('/shortener', name: 'app_shortener')]
    public function index(): Response
    {
        return $this->render('shortener/index.html.twig', [
            'controller_name' => 'ShortenerController',
        ]);
    }
}

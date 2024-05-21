<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/main', name: 'app_main')]
class MainController extends AbstractController
{
    public function __construct(private HttpClientInterface $httpClient)
    {
    }

    #[Route('/', name: 'app')]
    public function index(): Response
    {
        return $this->render('templates/main/index.html.twig', [
            'result' => 'MainController',
        ]);
    }

    #[Route('/sum/{number1}/{number2}', name: 'count')]
    public function count(int $number1, int $number2): Response
    {
        $result = $number1 + $number2;
        return $this->render('templates/main/sum.html.twig', [
            'result' => $result,
        ]);
    }

    #[Route('/hello/{name}', name: 'hello')]
    public function helloWorld($name): Response
    {
        $string = 'Hello, ' . $name . '!';
        return $this->render('templates/main/sum.html.twig', [
            'result' => $string,
        ]);
    }

    #[Route('/check-url', name: 'validate_url')]
    public function urlCheck(Request $request): Response
    {
        $return = new Response('URL parameter is missing', Response::HTTP_BAD_REQUEST);

        if ($url = $request->query->get('url')) {
            $isAccessible = false;
            $statusCode = null;

            try {
                $response = $this->httpClient->request('GET', $url);
                $statusCode = $response->getStatusCode();
                $statusText = $response->getContent(false);
                $isAccessible = ($statusCode >= 200 && $statusCode < 300);
                $urlInfo = parse_url($url);
            } catch (
                Exception|TransportExceptionInterface|
                ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface
                $e
            ) {
                $statusText = $e->getMessage();
            }

            $return = $this->render('templates/main/url-status.html.twig', [
                'url' => $url,
                'isAccessible' => $isAccessible,
                'statusCode' => $statusCode,
                'statusText' => $statusText,
                'urlInfo' => $urlInfo ?? '',
            ]);
        }

        return $return;
    }
}

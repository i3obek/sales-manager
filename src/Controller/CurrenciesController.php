<?php

namespace App\Controller;

use App\Service\ExchangeRate\ExchangeRateInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CurrenciesController extends AbstractController
{
    public function __construct(ExchangeRateInterface $exchangeRate)
    {
    }

    #[Route('/api/currencies', name: 'currencies', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CurrenciesController.php',
        ]);
    }
}

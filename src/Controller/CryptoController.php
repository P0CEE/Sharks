<?php

namespace App\Controller;

use App\Service\CryptoPriceService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CryptoController extends AbstractController
{
    private CryptoPriceService $cryptoPriceService;

    public function __construct(CryptoPriceService $cryptoPriceService)
    {
        $this->cryptoPriceService = $cryptoPriceService;
    }

    #[Route('/crypto/{cryptoId}', name: 'crypto_price')]
    public function index(string $cryptoId): Response
    {
        try {
            $price = $this->cryptoPriceService->getCryptoPrice($cryptoId);
        } catch (Exception $e) {
            return new Response('Error fetching crypto price: ' . $e->getMessage(), 500);
        }

        return new Response(sprintf('The price of %s is $%s', $cryptoId, $price));
    }
}

<?php

namespace App\Controller;

use App\Service\ZooWeb;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api-root')]
class WebApiController extends AbstractController
{
    private ZooWeb $zooWeb;

    public function __construct(ZooWeb $zooWeb)
    {
        $this->zooWeb = $zooWeb;
    }

    #[Route('/market', name: 'api-market')]
    public function ApiMarket(): JsonResponse
    {
        return $this->json($this->zooWeb->RenderMarket());
    }

    #[Route('/market-history', name: 'api-market-history')]
    public function ApiMarketHistory(): JsonResponse
    {
        return $this->json($this->zooWeb->RenderMarketHistory());
    }

    #[Route('/chest-history', name: 'api-chest-history')]
    public function ApiChestHistory(): JsonResponse
    {
        return $this->json($this->zooWeb->RenderChestHistory());
    }

    #[Route('/nft', name: 'api-nft')]
    public function ApiNft(): JsonResponse
    {
        return $this->json($this->zooWeb->RenderNFT());
    }

    #[Route('/wallet', name: 'api-nft')]
    public function ApiWallet(): JsonResponse
    {
        return $this->json($this->zooWeb->RenderWallet());
    }
}

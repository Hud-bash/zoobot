<?php

namespace App\Controller;

use App\Service\ZooWeb;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api-root/")
 */
class WebApiController extends AbstractController
{
    private ZooWeb $zooWeb;

    public function __construct(ZooWeb $zooWeb)
    {
        $this->zooWeb = $zooWeb;
    }

    /**
     * @Route("/market", name="api-market")
     */
    public function ApiMarket(): JsonResponse
    {
        return $this->json($this->zooWeb->RenderMarket());
    }

    /**
     * @Route("/market-history/{page}-{skip}", name="api-market-history", requirements={"page"="\d+"})
     */
    public function ApiMarketHistory($page = 1, $skip = 1): JsonResponse
    {
        $paginate[] = array(
            'page' => $page,
            'skip' => $skip
            );
        return $this->json($this->zooWeb->RenderMarketHistory($paginate));
    }

    /**
     * @Route("/chest-history", name="api-chest-history")
     */
    public function ApiChestHistory(): JsonResponse
    {
        return $this->json($this->zooWeb->RenderChestHistory());
    }

    /**
     * @Route("/nft", name="api-nft")
     */
    public function ApiNft(): JsonResponse
    {
        return $this->json($this->zooWeb->RenderNFT());
    }

    /**
     * @Route("/wallet", name="api-wallet")
     */
    public function ApiWallet(): JsonResponse
    {
        return $this->json($this->zooWeb->RenderWallet());
    }

    /**
     * @Route("/profile/{wallet}", name="api-profile")
     */
    public function ApiProfile(string $wallet): JsonResponse
    {
        return $this->json($this->zooWeb->RenderProfile($wallet));
    }

}

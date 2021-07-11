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
    @Route("/market/{page}-{skip}", name="api-market", requirements={"page"="\d+","skip"="\d+"})
     */
    public function ApiMarket($page = 1, $skip = 25): JsonResponse
    {
        $paginate = array(
            'page' => $page,
            'skip' => $skip
        );
        return $this->json($this->zooWeb->RenderMarket($paginate));
    }

    /**
     * @Route("/market-history/{page}-{skip}", name="api-market-history", requirements={"page"="\d+","skip"="\d+"})
     */
    public function ApiMarketHistory($page = 1, $skip = 25): JsonResponse
    {
        $paginate = array(
            'page' => $page,
            'skip' => $skip
            );
        return $this->json($this->zooWeb->RenderMarketHistory($paginate));
    }

    /**
     * @Route("/chest-history/{page}-{skip}", name="api-chest-history", requirements={"page"="\d+","skip"="\d+"})
     */
    public function ApiChestHistory($page = 1, $skip = 25): JsonResponse
    {
        $paginate = array(
            'page' => $page,
            'skip' => $skip
        );
        return $this->json($this->zooWeb->RenderChestHistory($paginate));
    }

    /**
     * @Route("/nft/{page}-{skip}", name="api-nft", requirements={"page"="\d+","skip"="\d+"})
     */
    public function ApiNft($page = 1, $skip = 25): JsonResponse
    {
        $paginate = array(
            'page' => $page,
            'skip' => $skip
        );
        return $this->json($this->zooWeb->RenderNFT($paginate));
    }

    /**
     * @Route("/wallet/{page}-{skip}", name="api-wallet", requirements={"page"="\d+","skip"="\d+"})
     */
    public function ApiWallet($page = 1, $skip = 25): JsonResponse
    {
        $paginate = array(
            'page' => $page,
            'skip' => $skip
        );
        return $this->json($this->zooWeb->RenderWallet($paginate));
    }

    /**
     * @Route("/profile/{wallet}", name="api-profile")
     */
    public function ApiProfile(string $wallet): JsonResponse
    {
        return $this->json($this->zooWeb->RenderProfile($wallet));
    }

}

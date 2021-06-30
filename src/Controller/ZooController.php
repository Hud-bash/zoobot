<?php
namespace App\Controller;

use App\Service\ZooName;
use App\Service\ZooWeb;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ZooController extends AbstractController {
    private ZooWeb $zooWeb;

    public function __construct(ZooWeb $zooWeb)
    {
        $this->zooWeb = $zooWeb;
    }

    /**
     * @Route("/market1", name="market")
     */
    public function Market()
    {
        $MarketCollection = $this->zooWeb->RenderMarket();

        return $this->render("market.html.twig", array (
                'MarketCollection' => $MarketCollection,
            )
        );
    }

    /**
     * @Route("/market-history1", name="market-history")
     */
    public function MarketHistory()
    {
        $MarketHistoryCollection = $this->zooWeb->RenderMarketHistory();

        return $this->render("markethistory.html.twig", array (
                'MarketHistoryCollection' => $MarketHistoryCollection,
            )
        );
    }

    /**
     * @Route("/chest-history1", name="chest-history")
     */
    public function ChestHistory(): Response
    {
        $ChestCollection = $this->zooWeb->RenderChestHistory();

        return $this->render("chesthistory.html.twig", array (
                'ChestCollection' => $ChestCollection,
            )
        );
    }

    /**
     * @Route("/nft1", name="nft")
     */
    public function Nft(): Response
    {
        $NftCollection = $this->zooWeb->RenderNFT();

        return $this->render("nft.html.twig", array (
            'NftCollection' => $NftCollection,
            )
        );
    }

    /**
     * @Route("/me1", name="profile")
     */
    public function Profile(string $wallet): Response
    {
        $Profile = $this->zooWeb->RenderProfile($wallet);

        return $this->render("profile.html.twig", array (
                'Profile' => $Profile,
            )
        );
    }

}
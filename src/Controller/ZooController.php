<?php
namespace App\Controller;

use App\Service\ZooWeb;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ZooController extends AbstractController {
    private ZooWeb $zooWeb;

    public function __construct(ZooWeb $zooWeb)
    {
        $this->zooWeb = $zooWeb;
    }

    /**
     * @Route("/market", name="market")
     */
    public function Market()
    {
//        return $this->render("market.html.twig", array (
//                'market' => $market,
//            )
//        );
    }

    /**
     * @Route("/market-history", name="market-history")
     */
    public function MarketHistory()
    {
//        return $this->render("markethistory.html.twig", array (
//                'markethistory' => $markethistory,
//            )
//        );
    }

    /**
     * @Route("/chest-history", name="chest-history")
     */
    public function ChestHistory()
    {
//        return $this->render("chesthistory.html.twig", array (
//                'chesthistory' => $chesthistory,
//            )
//        );
    }

    /**
     * @Route("/nft", name="nft")
     */
    public function Nft()
    {
        $NftCollection = $this->zooWeb->UpdateNFT();

        return $this->render("nft.html.twig", array (
            'NftCollection' => $NftCollection,
            )
        );
    }
}
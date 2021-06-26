<?php


namespace App\Service;


use App\Entity\MarketHistory;
use Doctrine\ORM\EntityManagerInterface;

class ZooWeb
{
    private EntityManagerInterface $em;
    public static string $defaultName = 'zoobot:update';
    private $wanAPItokenArtUrl;

    public function __construct(EntityManagerInterface $em, $wanAPItokenArtUrl)
    {
        $this->em = $em;
        $this->wanAPItokenArtUrl = $wanAPItokenArtUrl;
    }

    public function RenderNFT(): array
    {
        $inNft = $this->em->getRepository('App:Nft')->findAllDescending('nft_id');
        $outNft = array();

        foreach ($inNft as $nft)
        {
        $add = array(
            "url" => $nft->getImgUrl(),
            "id" => $nft->getNftId(),
            "name" => $nft->getName(),
            "category" => $this->setCategory($nft->getCategory()),
            "item" => $this->setClass($nft->getItem()),
            "level" => $this->setLevel($nft->getLevel()),
            "isLocked" => $this->setLock($nft->getIsLocked())
        );

        $outNft[] = $add;
        }

        return $outNft;
    }

    public function RenderChestHistory(): array
    {
        $inHistory = $this->em->getRepository('App:ChestHistory')->findAllDescending('block');
        $chests = array();
        $top20 = $this->em->getRepository('App:ChestHistory')->topChesties(20);

        foreach ($inHistory as $chest)
        {
            $nft = (is_null($chest->getNft()) ? "" : $chest->getNft()->getName());
            $wallet = (is_null($chest->getWallet()) ? null : $chest->getWallet());

            $add = array(
                'txHash' => $chest->getTxHash(),
                'timestamp' => $chest->getTimestamp(),
                'nft' => $nft,
                'wallet_id' => $wallet->getWalletId(),
                'type' => $this->setChestType($chest->getType(), $nft),
                'amount' => $chest->getAmount(),
                'name' => $wallet->getName(),
                'animal' => $wallet->getAnimal()
            );

            $chests[] = $add;
        };

        return array('history' => $chests, 'topchesties' => $top20);
    }

    public function RenderMarket(): array
    {
        $inMarket = $this->em->getRepository('App:Market')->findAllDescending('timestamp');
        $markets = array();

        foreach ($inMarket as $market)
        {
            $nft = $market->getNft();
            $seller = $market->getSeller();

            $add = array(
                'nft' => $nft->getName(),
                'nftimg' => $nft->getImgUrl(),
                'nftId' => $nft->getNftId(),
                'seller' => $seller->getName() . ' ' . $seller->getAnimal(),
                'price' => $market->getPrice(),
                'currency' => strtolower($this->wanAPItokenArtUrl . $market->getCurrency() . '.png'),
                'timestamp' => $market->getTimestamp(),
                'chainId' => $market->getChainId()
            );
            $markets[] = $add;
        }
        return $markets;
    }

    public function RenderMarketHistory(): array
    {
        $inHistory = $this->em->getRepository('App:MarketHistory')->findAllDescending('timestamp');
        $markets = array();

        foreach ($inHistory as $market)
        {
            $nft = $market->getNft();
            $buyer = $market->getBuyer();
            $seller = $market->getSeller();

            $add = array(
                'nft' => $nft->getName() . '[' . $nft->getNftId() . ']',
                'seller' => $seller->getName() . ' ' . $seller->getAnimal(),
                'buyer' => $buyer->getName() . ' ' . $buyer->getAnimal(),
                'price' => $market->getPrice(),
                'currency' => $market->getCurrency(),
                'timestamp' => $market->getTimestamp(),
                'chainId' => $market->getChainId(),
                'txHash' => $market->getTxHash()
            );
            $markets[] = $add;
        }
        return array(
            'history' => $markets,
            'topseller' => $this->em->getRepository('App:MarketHistory')->topSeller(10),
            'topbuyer' => $this->em->getRepository('App:MarketHistory')->topBuyer(10)
        );

    }

    private function setCategory(int $i): String
    {
        switch ($i)
        {
            case 1:
                return '<img src="' . '/img/fruits.png"><' . '/img>';
            case 2:
                return '<img src="' . '/img/dishes.png"><' . '/img>';
            case 3:
                return '<img src="' . '/img/sweets.png"><' . '/img>';
            case 4:
                return '<img src="' . '/img/potions.png"><' . '/img>';
            case 5:
                return '<img src="' . '/img/magic.png"><' . '/img>';
            case 6:
                return '<img src="' . '/img/spices.png"><' . '/img>';
            default:
                return strval($i);
        }

    }

    private function setLock(int $i): String
    {
        switch ($i)
        {
            case 0:
                return '';
            case 1:
                return '<img src="' . '/img/locked.png" style="width:25px;height:25px;"><' . '/img>';
            default:
                return strval($i);
        }
    }

    private function setClass(int $i): String
    {
        switch ($i)
        {
            case 1:
                return '<img src="' . '/img/N.png"><' . '/img>';
            case 2:
                return '<img src="' . '/img/R.png"><' . '/img>';
            case 3:
                return '<img src="' . '/img/SR.png"><' . '/img>';
            case 4:
                return '<img src="' . '/img/SSR.png"><' . '/img>';
            case 5:
                return '<img src="' . '/img/UR.png"><' . '/img>';
            default:
                return strval($i);
        }
    }

    private function setLevel(int $i): String
    {
        switch ($i) {
            case ($i <= 3):
                $html = '';
                for($x = 1; $x <= $i; $x++)
                {
                    $html = $html . '<img src="' . '/img/star18x18.png"><' . '/img>';
                }
                return $html;
            case 4:
                return '<img src="' . '/img/max.png"><' . '/img>';
            default:
                return strval($i);
        }
    }

    private function setChestType(string $type, $nft): String
    {
        if(str_contains($type, 'ilver'))
        {
            if($nft == "")
            {
                return '<img src="' . '/img/silverboxfail42x42.png"><' . '/img>';
            }
            else
            {
                return '<img src="' . '/img/silverbox42x42.png"><' . '/img>';
            }
        }
        else
        {
            return '<img src="' . '/img/goldenbox42x42.png"><' . '/img>';
        }
    }


}
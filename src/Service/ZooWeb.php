<?php


namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class ZooWeb
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
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
            "level" => $nft->getLevel(),
            "isLocked" => $nft->getIsLocked()
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
            $nft = (is_null($chest->getNft()) ? "" : $chest->getNft()->toArray());
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
            $add = array(
                'nft' => $this->em->getRepository('App:Nft')->findOneByNftId($market->getNft())->toArray(),
                'seller' => $this->em->getRepository('App:Wallet')->findOneByWalletId($market->getSeller())->toArray(),
                'price' => $market->getPrice(),
                'currency' => $market->getCurrency(),
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
            $nft = $market->getNft()->toArray();
            $buyer = $market->getBuyer()->toArray();
            $seller = $market->getSeller()->toArray();
            $currency = $this->em->getRepository('App:Token')->findOneBy(['address'=>$market->getCurrency()]);

            $add = array(
                'nft' => $nft,
                'seller' => $seller,
                'buyer' => $buyer,
                'price' => $market->getPrice(),
                'currency' => $currency->getLogo(),
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

    public function RenderProfile(string $address): array
    {
        $user = $this->em->getRepository('App:Wallet')->findOneBy(['wallet_id' => $address])->toArray();
        $chesties = $this->em->getRepository('App:ChestHistory')->findbywallet($address);
        $market = $this->em->getRepository('App:Market')->findByWalletId($address);
        $marketHistory = $this->em->getRepository('App:MarketHistory')->findbyWalletId($address);

        $profile[] = array(
            'profile' => $user,
            'chesties' => $chesties,
            'market' => $market,
            'marketHistory' => $marketHistory,
        );

        return $profile;
    }

    public function RenderWallet(): array
    {
        $inWallet = $this->em->getRepository('App:Wallet')->findAll();
        $outWallet[] = array();

        foreach ($inWallet as $wallet)
        {
            $outWallet[] = array(
                'wallet' => $wallet->getWalletId(),
                'name' => $wallet->getName(),
                'animal' => $wallet->getAnimal()
            );
        }

        return $outWallet;
    }

    private function setCategory(int $i): String
    {
        switch ($i)
        {
            case 1:
                return '/img/fruits.png';
            case 2:
                return 'img/dishes.png';
            case 3:
                return '/img/sweets.png';
            case 4:
                return '/img/potions.png';
            case 5:
                return '/img/magic.png';
            case 6:
                return '/img/spices.png';
            default:
                return strval($i);
        }

    }

    private function setClass(int $i): String
    {
        switch ($i)
        {
            case 1:
                return '/img/N.png';
            case 2:
                return '/img/R.png';
            case 3:
                return '/img/SR.png';
            case 4:
                return '/img/SSR.png';
            case 5:
                return '/img/UR.png';
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
                return '/img/silverboxfail42x42.png';
            }
            else
            {
                return '/img/silverbox42x42.png';
            }
        }
        else
        {
            return '/img/goldenbox42x42.png';
        }
    }


}
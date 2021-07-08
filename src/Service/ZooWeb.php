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
        $outNft[] = $nft->toArray();
        }
        return $outNft;
    }

    public function RenderChestHistory($paginate): array
    {
        $inHistory = $this->em->getRepository('App:ChestHistory')->findByPaginate($paginate);
        $chests = array();
        $top20 = $this->em->getRepository('App:ChestHistory')->topChesties(20);
        $count = $this->em->getRepository('App:ChestHistory')->getCount();

        foreach ($inHistory as $chest)
        {
            $nft = (is_null($chest->getNft()) ? "" : $chest->getNft()->toArray());
            $add = array(
                'txHash' => $chest->getTxHash(),
                'timestamp' => $chest->getTimestamp(),
                'nft' => $nft,
                'wallet' => $chest->getWallet()->toArray(),
                'type' => $chest->getType(),
                'amount' => $chest->getAmount(),
            );

            $chests[] = $add;
        };

        return array(
            'count' => $count,
            'history' => $chests,
            'topchesties' => $top20);
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

    public function RenderMarketHistory($paginate): array
    {
        $inHistory = $this->em->getRepository('App:MarketHistory')->findByPaginate($paginate);
        $recordCount = $this->em->getRepository('App:MarketHistory')->getCount();
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
            'count' => $recordCount,
            'history' => $markets,
            'topsellers' => $this->em->getRepository('App:MarketHistory')->topSeller(10),
            'topbuyers' => $this->em->getRepository('App:MarketHistory')->topBuyer(10)
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
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

    public function RenderNFT($paginate): array
    {
        $nfts = $this->em->getRepository('App:Nft')->findByPaginate($paginate);
        $count = $this->em->getRepository('App:Nft')->getCount();

        return [
            'count' => $count,
            'nfts' => $this->entityToArray($nfts)
        ];
    }

    public function RenderChestHistory($paginate): array
    {
        $chests = $this->em->getRepository('App:ChestHistory')->findByPaginate($paginate);
        $count = $this->em->getRepository('App:ChestHistory')->getCount();
        $top20 = $this->em->getRepository('App:ChestHistory')->topChesties(20);

        return [
            'count' => $count,
            'history' => $this->entityToArray($chests),
            'topchesties' => $top20];
    }

    public function RenderMarket($paginate): array
    {
        $markets = $this->em->getRepository('App:Market')->findByPaginate($paginate);
        $count = $this->em->getRepository('App:Market')->getCount();

        return [
            'count' => $count,
            'market' => $this->entityToArray($markets)
        ];
    }

    public function RenderMarketHistory($paginate): array
    {
        $sales = $this->em->getRepository('App:MarketHistory')->findByPaginate($paginate);
        $count = $this->em->getRepository('App:MarketHistory')->getCount();
        $salesArray = array();

        foreach ($sales as $sale)
        {
            $nft = $sale->getNft()->toArray();
            $buyer = $sale->getBuyer()->toArray();
            $seller = $sale->getSeller()->toArray();
            $currency = $this->em->getRepository('App:Token')->findOneBy(['address'=>$sale->getCurrency()])->toArray();

            $salesArray[] = array(
                'nft' => $nft,
                'seller' => $seller,
                'buyer' => $buyer,
                'price' => $sale->getPrice(),
                'currency' => $currency,
                'timestamp' => $sale->getTimestamp(),
                'chainId' => $sale->getChainId(),
                'txHash' => $sale->getTxHash()
            );
        }
        return [
            'count' => $count,
            'history' => $salesArray,
            'topSellers' => $this->em->getRepository('App:MarketHistory')->topSeller(10),
            'topBuyers' => $this->em->getRepository('App:MarketHistory')->topBuyer(10)
        ];
    }

    public function RenderWallet($paginate): array
    {
        $wallets = $this->em->getRepository('App:Wallet')->findByPaginate($paginate);
        $count = $this->em->getRepository('App:Wallet')->getCount();

        return [
            'count' => $count,
            'wallets' => $this->entityToArray($wallets)
        ];
    }

    public function RenderProfile(string $address): array
    {
        $user = $this->em->getRepository('App:Wallet')->findOneBy(['wallet_id' => $address]);
        $chesties = $this->em->getRepository('App:ChestHistory')->findbywallet($address);
        $market = $this->em->getRepository('App:Market')->findByWalletId($address);
        $salesHistory = $this->em->getRepository('App:MarketHistory')->sellerByWalletId($address);
        $buyHistory = $this->em->getRepository('App:MarketHistory')->buyerByWalletId($address);

        return [
            'profile' => $this->entityToArray($user),
            'chesties' => $this->entityToArray($chesties),
            'market' => $this->entityToArray($market),
            'salesHistory' => $this->entityToArray($salesHistory),
            'buyHistory' => $this->entityToArray($buyHistory),
        ];
    }

    //entity needs to have the toArray() function
    public function entityToArray($entity)
    {
        if(is_array($entity))
        {
            $output = [];
            foreach ($entity as $item)
            {
                $output[] = $item->toArray();
            }
        }
        else
        {
            $output = $entity;
        }

        return $output;
    }
}
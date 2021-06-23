<?php
namespace App\Service;

use App\Entity\Wallet;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Nft;
use App\Entity\Market;
use App\Entity\MarketHistory;
use App\Entity\ChestHistory;

class ZooBotSQL {

    private ZooBotAPI $zapi;
    private EntityManagerInterface $em;
    
    public function __construct(ZooBotAPI $zapi, EntityManagerInterface $em)
    {
        $this->zapi = $zapi;
        $this->em = $em;
    }

    public function UpdateNft(): string
    {
        $updates = $this->zapi->nftJson;
        $table = $this->em->getRepository("App:Nft");
               
        foreach($updates as $row)
        {
            $exists = $table->findOneBy(['nft_id' => $row->tokenId]);

            if (!$exists)
            {
                $this->MakeNft($row->tokenId);
            }
        }

        return 'NFTs tractorbeamed.';
    }

    public function UpdateNftLock(): string
    {
        $updates = $this->zapi->nftLockJson;
        $table = $this->em->getRepository("App:Nft");
        $currentIds = array();

        foreach($updates->lockedNft as $row)
        {
            $currentIds[] = $row->tokenId;
        }

        $table->UpdateLockState($currentIds);

        return 'Locked NFTs analyzed --bzzzrrrrrrz--';
    }

    public function UpdateMarket(): string
    {
        $updates = $this->zapi->marketJson;
        $table = $this->em->getRepository("App:Market");
        $currentIds = array();

        foreach($updates->markets as $row)
        {
            //List to be used at the end to clear market table of items no longer in market
            $currentIds[] = $row->tokenId;

            //Create objects for the NFT & Wallet.
            $nft = $this->MakeNft($row->tokenId);
            $wallet = $this->MakeWallet($row->owner);

            //check for existing entry in database
            $marketEntry = $this->em->getRepository('App:Market')->findByNftId($row->tokenId);

            //if the entry is null, we create a new Market object and insert into the NFT
            if(!$marketEntry)
            {
                $market = new Market();
                $market->setPrice($row->price);
                $market->setCurrency($row->token);
                $market->setExpiration($row->expiration);
                $market->setSeller($wallet);
                $market->setTimestamp(DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s', $row->createTime)));
                $market->setChainId($row->orderId);

                $nft->setInMarket($market);

                $this->em->persist($nft);
            }
            //Otherwise the market entry exists and requires updating instead of creating a new.
            else
            {
                //Only update if the order ID has changed.  Otherwise it is still the same listing, so ignore.
                if($row->orderId != $marketEntry->getChainId())
                {
                    $marketEntry->setPrice($row->price);
                    $marketEntry->setCurrency($row->token);
                    $marketEntry->setExpiration($row->expiration);
                    $marketEntry->setTimestamp(DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s', $row->createTime)));
                    $marketEntry->setChainId($row->orderId);

                    $this->em->persist($marketEntry);
                }
            }
        }
        $table->CleanMarket($currentIds);

        $this->em->flush();
        $this->em->clear();

        return 'New market listings added.';
    }

    public function UpdateMarketHistory(): string
    {
        $updates = $this->zapi->marketHistoryJson;
        $table = $this->em->getRepository("App:MarketHistory");

        foreach($updates as $row)
        {
            $rowExists = $table->findOneBy(['chain_id' => $row->_id]);

            if (!$rowExists)
            {
                $nft = $this->MakeNft($row->tokenId);
                
                //timestamp raw string is fucked up, so we need to format it to DateTime
                $timestamp = explode('T', $row->time);
                $date = $timestamp[0];
                $time = substr($timestamp[1], 0, -5);
                $correctDate = date('Y-m-d H:i:s', strtotime($date . ' ' . $time));
                
                $marketHistory = new MarketHistory();
                $marketHistory->setPrice($row->price);
                $marketHistory->setCurrency($row->symbol);
                $marketHistory->setBuyer($this->MakeWallet($row->buyer));
                $marketHistory->setSeller($this->MakeWallet($row->seller));
                $marketHistory->setTimestamp(DateTime::createFromFormat('Y-m-d H:i:s', $correctDate));
                $marketHistory->setChainId($row->_id);
                $marketHistory->setBlock($row->blockNumber);
                $marketHistory->setTxHash($row->txHash);

                $nft->addMarketHistory($marketHistory);

                $this->em->persist($nft);
                $this->em->flush();
                $this->em->clear();
            }
        }
        return 'Market history gud.';
    }

    public function UpdateChestHistory(): string
    {
        $updates = $this->zapi->chestHistoryJson;
        $table = $this->em->getRepository("App:ChestHistory");

        foreach($updates as $row)
        {
            $rowExists = $table->findOneBy(['txHash' => $row->txHash]);

            if (!$rowExists)
            {
                //timestamp raw string.  We need to format it to DateTime
                $timestamp = explode('T', $row->time);
                $date = $timestamp[0];
                $time = substr($timestamp[1], 0, -5);
                $correctDate = date('Y-m-d H:i:s', strtotime($date . ' ' . $time));
                
                $chestHistory = new ChestHistory();
                $chestHistory->setType($row->type);
                $chestHistory->setAmount($row->price);
                $chestHistory->setWallet($this->MakeWallet($row->user));
                $chestHistory->setTimestamp(DateTime::createFromFormat('Y-m-d H:i:s', $correctDate));
                $chestHistory->setChainId($row->_id);
                $chestHistory->setBlock($row->block);
                $chestHistory->setTxHash($row->txHash);

                if ($row->tokenId == 0)
                {   
                    //tokenId of 0 means a silver chest does not produce a NFT, so we do not associate.
                    $this->em->persist($chestHistory);
                }
                else
                {
                    //Save chest history to NFT.  If NFT does not exist, fetch details and update.
                    $nft = $this->MakeNft($row->tokenId);
                    $nft->setChestHistory($chestHistory);

                    $this->em->persist($nft);
                }

                $this->em->flush();
                $this->em->clear();
            }
        }
        return 'Chestie bois inspected...LEH GO';
    }

    public function MakeWallet(string $id): Wallet
    {
        $wallet = $this->em->getRepository('App:Wallet')->findOneBy(['wallet_id' => $id]);

        //check if wallet id exists in Wallet table.  Add if not exist.
        if(!$wallet)
        {
            $wallet = new Wallet();
            $wallet->setWalletId($id);
            $this->em->persist($wallet);
            $this->em->flush();
        }

        return $this->em->getRepository('App:Wallet')->findOneBy(['wallet_id' => $id]);
    }

    public function MakeNft(int $id): Nft
    {
        $rpcUpdates = $this->zapi->nftJson;
        $nft = $this->em->getRepository('App:Nft')->findOneBy(['nft_id' => $id]);

        if(!$nft)
        {
            foreach ($rpcUpdates as $row)
            {
                if($row->tokenId == $id)
                {
                    $nft = new Nft();
                    $nft->setNftId($row->tokenId);
                    $nft->setName($row->name);
                    $nft->setCategory($row->category);
                    $nft->setItem($row->item);
                    $nft->setLevel($row->level);
                    $nft->setBoost($row->boosting);
                    $nft->setReduction($row->reduce);
                    $nft->setRandom($row->random);
                    $nft->setTimestamp(DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s', $row->timestamp)));
                    $nft->setChainId($row->_id);
                    $nft->setBlock($row->blockNumber);
                    $nft->setTxHash($row->txHash);
                    $nft->setImgURL($row->image);

                    $this->em->persist($nft);
                    $this->em->flush();
                }
            }
        }

        return $this->em->getRepository('App:Nft')->findOneBy(['nft_id' => $id]);
    }
}
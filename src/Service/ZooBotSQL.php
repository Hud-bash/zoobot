<?php
namespace App\Service;

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
        $updates = $this->zapi->GetNft();
        $table = $this->em->getRepository("App:Nft");
               
        foreach($updates as $row)
        {
            $exists = $table->findOneBy(['nft_id' => $row->tokenId]);

            if (!$exists)
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
            }
        }

        $this->em->flush();
        $this->em->clear();

        return 'NFTs tractorbeamed.';
    }

    public function UpdateNftLock(): string
    {
        $updates = $this->zapi->GetNftLock();
        $table = $this->em->getRepository("App:Nft");
        $currentIds = array();

        foreach($updates->lockedNft as $row)
        {
            $currentIds[] = $row->tokenId;
        }
        
        // Set isLocked to true (1) for nft_ids in json webget
        $table->createQueryBuilder('')
        ->update("App:Nft", 'e')
        ->set('e.isLocked', 1)
        ->where('e.nft_id IN (:ids)')
        ->setParameter('ids', $currentIds)
        ->getQuery()
        ->execute();

        // Set isLocked to false (0) for nft_ids no longer present in json webget
        $table->createQueryBuilder('')
        ->update("App:Nft", 'e')
        ->set('e.isLocked', 0)
        ->where('e.isLocked = 1 AND e.nft_id NOT IN (:ids)')
        ->setParameter('ids', $currentIds)
        ->getQuery()
        ->execute();

        $this->em->flush();
        $this->em->clear();

        return 'Locked NFTs analyzed --bzzzrrrrrrz--';
    }

    public function UpdateMarket(): string
    {
        $updates = $this->zapi->GetMarket();
        $table = $this->em->getRepository("App:Market");
        $currentIds = array();

        foreach($updates->markets as $row)
        {
            //ID List to be used at the end to clear market table of items no longer in market
            $currentIds[] = $row->tokenId;

            //Create objects for the NFT & market entry.
            $nft = $this->em->find('App:Nft', $row->tokenId);
            $marketEntry = $table->findOneBy(['nft' => $row->tokenId]);

            //Check if NFT exists.  If not, then update NFT list.  NFT discovered after last refresh.
            if(!$nft)
            {
                $this->UpdateNft();
                $nft = $this->em->find('App:Nft', $row->tokenId);
            }

            //if the entry is null it will be false, so we create a new Market object and insert into the NFT
            if(!$marketEntry)
            {
                $market = new Market();
                $market->setPrice($row->price);
                $market->setCurrency($row->token);
                $market->setExpiration($row->expiration);
                $market->setSeller($row->owner);
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
                    $marketEntry->setSeller($row->owner);
                    $marketEntry->setTimestamp(DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s', $row->createTime)));
                    $marketEntry->setChainId($row->orderId);

                    $this->em->persist($marketEntry);
                }
            }
        }
        //Purge table of any listings with nft_id
        $table->createQueryBuilder('')
        ->delete("App:Market", 'm')
        ->where('m.nft NOT IN (:ids)')
        ->setParameter('ids', $currentIds)
        ->getQuery()
        ->execute();

        $this->em->flush();
        $this->em->clear();

        return 'New market listings added.';
    }

    public function UpdateMarketHistory(): string
    {
        $updates = $this->zapi->GetMarketHistory();
        $table = $this->em->getRepository("App:MarketHistory");

        foreach($updates as $row)
        {
            $rowExists = $table->findOneBy(['chain_id' => $row->_id]);

            if (!$rowExists)
            {
                $nft = $this->em->getRepository("App:Nft")->findOneBy(['nft_id' => $row->tokenId]);
                
                //timestamp raw string is fucked up, so we need to format it to DateTime
                $timestamp = explode('T', $row->time);
                $date = $timestamp[0];
                $time = substr($timestamp[1], 0, -5);
                $correctDate = date('Y-m-d H:i:s', strtotime($date . ' ' . $time));
                
                $insertrow = new MarketHistory();
                $insertrow->setPrice($row->price);
                $insertrow->setCurrency($row->symbol);
                $insertrow->setBuyer($row->buyer);
                $insertrow->setSeller($row->seller);
                $insertrow->setTimestamp(DateTime::createFromFormat('Y-m-d H:i:s', $correctDate));
                $insertrow->setChainId($row->_id);
                $insertrow->setBlock($row->blockNumber);
                $insertrow->setTxHash($row->txHash);

                $nft->addMarketHistory($insertrow);

                $this->em->persist($nft);
                $this->em->flush();
                $this->em->clear();
            }
        }
        return 'Market history guud.';
    }

    public function UpdateChestHistory(): string
    {
        $updates = $this->zapi->GetChestHistory();
        $table = $this->em->getRepository("App:ChestHistory");

        foreach($updates as $row)
        {
            $rowExists = $table->findOneBy(['txHash' => $row->txHash]);

            if (!$rowExists)
            {
                //timestamp raw string is fucked up, so we need to format it to DateTime
                $timestamp = explode('T', $row->time);
                $date = $timestamp[0];
                $time = substr($timestamp[1], 0, -5);
                $correctDate = date('Y-m-d H:i:s', strtotime($date . ' ' . $time));
                
                $insertrow = new ChestHistory();
                $insertrow->setType($row->type);
                $insertrow->setAmount($row->price);
                $insertrow->setOwner($row->user);
                $insertrow->setTimestamp(DateTime::createFromFormat('Y-m-d H:i:s', $correctDate));
                $insertrow->setChainId($row->_id);
                $insertrow->setBlock($row->block);
                $insertrow->setTxHash($row->txHash);

                if ($row->tokenId == 0)
                {   
                    //Save new chest history with NULL nft_id.  This can happen when a silver chest does not produce anything.
                    $this->em->persist($insertrow);
                }
                else
                {
                    //Save new chest history to existing NFT
                    $nft = $this->em->getRepository("App:Nft")->findOneBy(['nft_id' => $row->tokenId]);
                    $nft->setChestHistory($insertrow);

                    $this->em->persist($nft);
                }

                $this->em->flush();
                $this->em->clear();
            }
        }
        return 'Chestie bois inspected...LEH GO';
    }
}
?>
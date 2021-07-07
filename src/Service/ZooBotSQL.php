<?php
namespace App\Service;

use App\Entity\Token;
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

    public function UpdateToken(): string
    {
        $jsonObjects = $this->zapi->tokenJson;

        foreach ($jsonObjects->tokens as $object)
        {
            $this->MakeToken($object->address);
        }

        return 'Token table updates YEEEEET.';
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

    public function UpdateMarket(): string
    {
        $updates = $this->zapi->marketJson;
        $table = $this->em->getRepository("App:Market");
        $currentIds = array();

        foreach($updates->markets as $row)
        {
            //List to be used at the end to clear market table of items no longer in market
            $currentIds[] = $row->tokenId;

            //Create objects for the NFT, Currency Token & Wallet.
            $nft = $this->MakeNft($row->tokenId);
            $wallet = $this->MakeWallet($row->owner);
            $currency = $this->MakeToken($row->token);

            //if the entry is null, we create a new Market object and insert into the NFT
            if(!$nft->getInMarket())
            {
                $market = new Market();
                $market->setPrice($row->price / pow(10, $currency->getDecimalLength()));
                $market->setCurrency($currency->getLogo());
                $market->setExpiration($row->expiration);
                $market->setSeller($wallet);
                $market->setTimestamp(DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s', $row->createTime)));
                $market->setChainId($row->orderId);

                $nft->setInMarket($market);

                $this->em->persist($nft);
            }
            //Otherwise the market entry exists and may require updating.
            else
            {
                //Only update if the order ID has changed.  Otherwise it is still the same listing, so ignore.
                if($row->orderId != $nft->getInMarket()->getChainId())
                {
                    $nft->getInMarket()->setPrice($row->price / pow(10, $currency->getDecimalLength()));
                    $nft->getInMarket()->setCurrency($currency->getLogo());
                    $nft->getInMarket()->setExpiration($row->expiration);
                    $nft->getInMarket()->setTimestamp(DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s', $row->createTime)));
                    $nft->getInMarket()->setChainId($row->orderId);

                    $this->em->persist($nft);
                }
            }
        }
        //deletes rows from table that no longer exist in the market feed.
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
                $currency = $this->em->getRepository('App:Token')->findOneBySymbol($row->symbol);

                $marketHistory = new MarketHistory();
                $marketHistory->setPrice($row->price);
                $marketHistory->setCurrency($currency->getAddress());
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
        $jsonUpdate = $this->zapi->nftJson;
        $nft = $this->em->getRepository('App:Nft')->findOneBy(['nft_id' => $id]);
        //Check if nft exists
        if(!$nft)
        {
            //if it does not, we loop through ZooKeeper rpc results to find the NFT details
            foreach ($jsonUpdate as $item)
            {
                //When found, we create a new NFT with the information.
                if($item->tokenId == $id)
                {
                    $nft = new Nft();
                    $nft->setNftId($item->tokenId);
                    $nft->setName($item->name);
                    $nft->setCategory($item->category);
                    $nft->setItem($item->item);
                    $nft->setLevel($item->level);
                    $nft->setBoost(($item->boosting / pow(10, 10) - 100) * .01);
                    $nft->setReduction(($item->reduce / pow(10, 10) - 100) * .01);
                    $nft->setRandom($item->random);
                    $nft->setTimestamp(DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s', $item->timestamp)));
                    $nft->setChainId($item->_id);
                    $nft->setBlock($item->blockNumber);
                    $nft->setTxHash($item->txHash);
                    $nft->setImgURL($item->image);

                    $this->em->persist($nft);
                    $this->em->flush();
                }
            }
        }

        return $this->em->getRepository('App:Nft')->findOneBy(['nft_id' => $id]);
    }

    public function MakeToken(string $id): ?object
    {
        $jsonUpdate = $this->zapi->tokenJson;
        $exists = $this->em->getRepository('App:Token')->findOneBy(['address' => $id]);

        if(!$exists)
            {
                foreach ($jsonUpdate->tokens as $item)
                {
                    if ($item->address == $id and $item->chainId == '888')
                    {
                        $token = new Token();
                        $token->setAddress($item->address);
                        $token->setName($item->name);
                        $token->setDecimalLength($item->decimals);
                        $token->setSymbol($item->symbol);
                        $token->setLogo($item->logoURI);

                        $this->em->persist($token);
                        $this->em->flush();
                    }
                }
            }
        return $this->em->getRepository('App:Token')->findOneBy(['address' => $id]);
    }

    public function FixBoostPercent(): string
    {
        $jsonUpdate = $this->zapi->nftJson;

        foreach ($jsonUpdate as $item)
        {
            $nft = $this->em->getRepository('App:Nft')->findOneByNftId($item->tokenId);

            $nft->setBoost(($item->boosting / pow(10, 10) - 100) * .01);
            $nft->setReduction(($item->reduce / pow(10, 10) - 100) * .01);

            $this->em->persist($nft);
            $this->em->flush();
        }
        return 'Boost/Reduction values calculated.';
    }
}
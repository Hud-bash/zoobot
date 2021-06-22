<?php
namespace App\Service;

use App\Entity\MarketHistory;
use App\Entity\Wallet;
use Doctrine\ORM\EntityManagerInterface;
use Nubs\RandomNameGenerator\Alliteration;

class ZooName
{

    private EntityManagerInterface $em;
    private string $firstNameGenUrl;

    public function __construct(EntityManagerInterface $em, string $firstNameGenUrl)
    {
        $this->em = $em;
        $this->firstNameGenUrl = $firstNameGenUrl;
    }

    private function GenerateName(): array
    {
        $getFirstName = $this->webGet();
        $firstnameSplit = explode(' ', $getFirstName->name);

        $lastNameGen = new Alliteration();

        $firstName = $firstnameSplit[0] . ' ' . $firstnameSplit[1];
        $lastName = $lastNameGen->getName();

        $name[] = $firstName;
        $name[] = $lastName;
        return $name;
    }

    private function webGet()
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
                CURLOPT_URL => $this->firstNameGenUrl,
                CURLOPT_RETURNTRANSFER => 'true'
            ]
        );
        return json_decode(curl_exec($ch));
    }

    public function CreateWalletName()
    {
        $name = $this->GenerateName();
        dump($name);die;
    }

    public function UpdateWallet()
    {
        $marketHistoryEntity = $this->em->getRepository("App:MarketHistory");
        $chestHistoryEntity = $this->em->getRepository("App:ChestHistory")->getUniqueWallets();
        $walletEntity = $this->em->getRepository("App:Wallet");
        
        if(!$walletEntity->findBy(['wallet_id' => $marketHistoryEntity]))
        {
            $wallet = new Wallet();
            $wallet->setWalletId($x->getWalletId);
            $this->em->persist($wallet);
            $this->em->flush();
            $this->em->clear();
        }
        if(!$x = $walletEntity->findBy(['wallet_id' => $marketHistoryEntity]))
        {
            $wallet = new Wallet();
            $wallet->setWalletId($x->getWalletId);
            $this->em->persist($wallet);
            $this->em->flush();
            $this->em->clear();
        }
        if(!$x = $walletEntity->findBy(['wallet_id' => $chestHistoryEntity->owner]))
        {
            $wallet = new Wallet();
            $wallet->setWalletId($x->getWalletId);
            $this->em->persist($wallet);
            $this->em->flush();
            $this->em->clear();
        }

    }
}
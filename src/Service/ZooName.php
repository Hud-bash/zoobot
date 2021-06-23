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

    protected function webGet()
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
                CURLOPT_URL => $this->firstNameGenUrl,
                CURLOPT_RETURNTRANSFER => 'true'
            ]
        );
        return json_decode(curl_exec($ch));
    }

    protected function GenerateName(): array
    {
        $getFirstName = $this->webGet();
        $firstnameSplit = explode(' ', $getFirstName->name);

        $lastNameGen = new Alliteration();

        $firstName = $firstnameSplit[0] . ' ' . $firstnameSplit[1];
        $lastName = $lastNameGen->getName();

        $name = array('name' => $firstName, 'animal' => $lastName);

        return $name;
    }

    protected function SetWalletName(Wallet $wallet): Wallet
    {
        $name = $this->GenerateName();
        $wallet->setName($name['name']);
        $wallet->setAnimal($name['animal']);

        return $wallet;
    }

    public function UpdateNullNames(): string
    {
        $list = $this->em->getRepository('App:Wallet')->FindNullNames();
        foreach($list as $item)
        {
            $this->SetWalletName($item);
            $this->em->persist($item);
            $this->em->flush();
        }

        $this->em->clear();

        return 'Job done.';
    }
}
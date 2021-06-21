<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class ZooName {

    private EntityManagerInterface $em;
    private string $firstNameGenUrl;

    public function __construct(EntityManagerInterface $em, string $firstNameGenUrl)
    {
        $this->em = $em;
        $this->firstNameGenUrl = $firstNameGenUrl;
    }

    public function GenerateName(): string
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
                CURLOPT_URL => $this->firstNameGenUrl,
                CURLOPT_RETURNTRANSFER => 'true'
            ]
        );
        $decoded = json_decode(curl_exec($ch));
        $fullname = $decoded->name;
        dump($fullname);die;

        return '';
    }
}
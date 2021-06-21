<?php


namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;

class ZooWeb
{
    private EntityManagerInterface $em;
    public static string $defaultName = 'zoobot:update';

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function UpdateNFT(): array
    {
        $inNft = $this->em->getRepository('App:Nft')->findAllDescending();

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

    public function setCategory(int $i): String
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

    public function setLock(int $i): String
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

    public function setClass(int $i): String
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

    public function setLevel(int $i): String
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
}
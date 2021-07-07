<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WalletRepository::class)
 */
class Wallet
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true)
     */
    public $wallet_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $animal;

    public function __construct()
    {
    }

    public function getWalletId(): ?string
    {
        return $this->wallet_id;
    }

    public function setWalletId(string $wallet_id): self
    {
        $this->wallet_id = $wallet_id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAnimal(): ?string
    {
        return $this->animal;
    }

    public function setAnimal(string $animal): self
    {
        $this->animal = $animal;

        return $this;
    }

    public function toArray()
    {
        return
        [
            'wallet'=>$this->wallet_id,
            'name'=>$this->name,
            'animal'=>$this->animal,
        ];
    }
}

<?php

namespace App\Entity;

use App\Repository\MarketRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MarketRepository::class)
 */
class Market
{
    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity=Nft::class, inversedBy="inMarket", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $nft;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chain_id;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Token::class, inversedBy="address", cascade={"persist"})
     * @ORM\JoinColumn(name="currency_id", nullable=false, referencedColumnName="address")
     */
    private $currency;

    /**
     * @ORM\Column(type="integer")
     */
    private $expiration;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * @ORM\ManyToOne(targetEntity=Wallet::class, inversedBy="markets", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, referencedColumnName="wallet_id")
     */
    private $seller;

    public function getNft(): ?Nft
    {
        return $this->nft;
    }

    public function setNft(Nft $nft): self
    {
        $this->nft = $nft;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCurrency(): ?Token
    {
        return $this->currency;
    }

    public function setCurrency(Token $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getExpiration(): ?int
    {
        return $this->expiration;
    }

    public function setExpiration(int $expiration): self
    {
        $this->expiration = $expiration;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getChainId(): ?string
    {
        return $this->chain_id;
    }

    public function setChainId(string $chain_id): self
    {
        $this->chain_id = $chain_id;

        return $this;
    }

    public function getSeller(): ?Wallet
    {
        return $this->seller;
    }

    public function setSeller(?Wallet $seller): self
    {
        $this->seller = $seller;

        return $this;
    }

    public function toArray(): array
    {
        return (
            [
            'nft'=>$this->nft->toArray(),
            'seller'=>$this->seller->toArray(),
            'chain_id'=>$this->chain_id,
            'price'=>$this->price,
            'currency'=>$this->currency->toArray(),
            'timestamp'=>$this->timestamp,
            ]
        );
    }
}

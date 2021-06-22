<?php

namespace App\Entity;

use App\Repository\MarketHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MarketHistoryRepository::class)
 */
class MarketHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Nft::class, inversedBy="marketHistory", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $nft;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $currency;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $chain_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $block;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $txHash;

    /**
     * @ORM\ManyToOne(targetEntity=Wallet::class, inversedBy="sellHistory", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $seller;

    /**
     * @ORM\ManyToOne(targetEntity=Wallet::class, inversedBy="buyHistory", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $buyer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNft(): ?Nft
    {
        return $this->nft;
    }

    public function setNft(?Nft $nft): self
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

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

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

    public function getBlock(): ?int
    {
        return $this->block;
    }

    public function setBlock(int $block): self
    {
        $this->block = $block;

        return $this;
    }

    public function getTxHash(): ?string
    {
        return $this->txHash;
    }

    public function setTxHash(string $txHash): self
    {
        $this->txHash = $txHash;

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

    public function getBuyer(): ?Wallet
    {
        return $this->buyer;
    }

    public function setBuyer(?Wallet $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }
}

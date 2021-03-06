<?php

namespace App\Entity;

use App\Repository\ChestHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChestHistoryRepository::class)
 */
class ChestHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Nft::class, inversedBy="chestHistory", cascade={"persist", "remove"})
     */
    private $nft;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * @ORM\Column(type="string", length=255)
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
     * @ORM\ManyToOne(targetEntity=Wallet::class, inversedBy="chestHistory")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="wallet_id")
     */
    private $wallet;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

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

    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    public function setWallet(?Wallet $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }

    public function toArray()
    {
        return
            [
                'id'=> $this->id,
                'nft'=> is_null($this->nft) ? "" : $this->nft->toArray(),
                'wallet'=> $this->wallet->toArray(),
                'type'=> $this->type,
                'amount'=> $this->amount,
                'timestamp'=> $this->timestamp,
                'chain_id'=> $this->chain_id,
                'block'=> $this->block,
                'txHash'=> $this->txHash,
            ];
    }
}

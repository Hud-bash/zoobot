<?php

namespace App\Entity;

use App\Repository\NftRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NftRepository::class)
 */
class Nft
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $nft_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $category;

    /**
     * @ORM\Column(type="integer")
     */
    private $item;

    /**
     * @ORM\Column(type="integer")
     */
    private $level;

    /**
     * @ORM\Column(type="string")
     */
    private $boost;

    /**
     * @ORM\Column(type="string")
     */
    private $reduction;

    /**
     * @ORM\Column(type="integer")
     */
    private $random;

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
     * @ORM\Column(type="integer")
     */
    private $isLocked = 0;

    /**
     * @ORM\OneToOne(targetEntity=ChestHistory::class, mappedBy="nft", cascade={"persist", "remove"})
     */
    private $chestHistory;

    /**
     * @ORM\OneToMany(targetEntity=MarketHistory::class, mappedBy="nft", cascade={"persist"})
     */
    private $marketHistory;

    /**
     * @ORM\OneToOne(targetEntity=Market::class, mappedBy="nft", cascade={"persist", "remove"})
     */
    private $inMarket;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imgURL;

    public function __construct()
    {
        $this->marketHistory = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNftId(): ?int
    {
        return $this->nft_id;
    }

    public function setNftId(int $nft_id): self
    {
        $this->nft_id = $nft_id;

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

    public function getCategory(): ?int
    {
        return $this->category;
    }

    public function setCategory(int $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getItem(): ?int
    {
        return $this->item;
    }

    public function setItem(int $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getBoost(): ?string
    {
        return $this->boost;
    }

    public function setBoost(string $boost): self
    {
        $this->boost = $boost;

        return $this;
    }

    public function getReduction(): ?string
    {
        return $this->reduction;
    }

    public function setReduction(string $reduction): self
    {
        $this->reduction = $reduction;

        return $this;
    }

    public function getRandom(): ?int
    {
        return $this->random;
    }

    public function setRandom(int $random): self
    {
        $this->random = $random;

        return $this;
    }

    public function getTimestamp(): ?DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(DateTimeInterface $timestamp): self
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

    public function getIsLocked(): ?int
    {
        return $this->isLocked;
    }

    public function setIsLocked(int $isLocked): self
    {
        $this->isLocked = $isLocked;

        return $this;
    }

    public function getChestHistory(): ?ChestHistory
    {
        return $this->chestHistory;
    }

    public function setChestHistory(?ChestHistory $chestHistory): self
    {
        // unset the owning side of the relation if necessary
        if ($chestHistory === null && $this->chestHistory !== null) {
            $this->chestHistory->setNft(null);
        }

        // set the owning side of the relation if necessary
        if ($chestHistory !== null && $chestHistory->getNft() !== $this) {
            $chestHistory->setNft($this);
        }

        $this->chestHistory = $chestHistory;

        return $this;
    }

    /**
     * @return Collection|MarketHistory[]
     */
    public function getMarketHistory(): Collection
    {
        return $this->marketHistory;
    }

    public function addMarketHistory(MarketHistory $marketHistory): self
    {
        if (!$this->marketHistory->contains($marketHistory)) {
            $this->marketHistory[] = $marketHistory;
            $marketHistory->setNft($this);
        }

        return $this;
    }

    public function removeMarketHistory(MarketHistory $marketHistory): self
    {
        if ($this->marketHistory->removeElement($marketHistory)) {
            // set the owning side to null (unless already changed)
            if ($marketHistory->getNft() === $this) {
                $marketHistory->setNft(null);
            }
        }

        return $this;
    }

    public function getInMarket(): ?Market
    {
        return $this->inMarket;
    }

    public function setInMarket(Market $inMarket): self
    {
        // set the owning side of the relation if necessary
        if ($inMarket->getNft() !== $this) {
            $inMarket->setNft($this);
        }

        $this->inMarket = $inMarket;

        return $this;
    }

    public function getImgURL(): ?string
    {
        return $this->imgURL;
    }

    public function setImgURL(string $imgURL): self
    {
        $this->imgURL = $imgURL;

        return $this;
    }
}

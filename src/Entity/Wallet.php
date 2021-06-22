<?php

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WalletRepository::class)
 */
class Wallet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    public string $wallet_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $animal;

    /**
     * @ORM\OneToMany(targetEntity=Nft::class, mappedBy="wallet")
     */
    private Collection $nft;

    /**
     * @ORM\OneToMany(targetEntity=Market::class, mappedBy="seller")
     */
    private Collection $market;

    /**
     * @ORM\OneToMany(targetEntity=ChestHistory::class, mappedBy="wallet")
     */
    private Collection $chestHistory;

    /**
     * @ORM\OneToMany(targetEntity=MarketHistory::class, mappedBy="seller")
     */
    private $sellHistory;

    /**
     * @ORM\OneToMany(targetEntity=MarketHistory::class, mappedBy="buyer")
     */
    private $buyHistory;

    public function __construct()
    {
        $this->nft = new ArrayCollection();
        $this->market = new ArrayCollection();
        $this->chestHistory = new ArrayCollection();
        $this->sellHistory = new ArrayCollection();
        $this->buyHistory = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Nft[]
     */
    public function getNft(): Collection
    {
        return $this->nft;
    }

    public function addNft(Nft $nft): self
    {
        if (!$this->nft->contains($nft)) {
            $this->nft[] = $nft;
            $nft->setWallet($this);
        }

        return $this;
    }

    public function removeNft(Nft $nft): self
    {
        if ($this->nft->removeElement($nft)) {
            // set the owning side to null (unless already changed)
            if ($nft->getWallet() === $this) {
                $nft->setWallet(null);
            }
        }

        return $this;
    }

      /**
     * @return Collection|Market[]
     */
    public function getMarket(): Collection
    {
        return $this->market;
    }

    public function addMarket(Market $market): self
    {
        if (!$this->market->contains($market)) {
            $this->market[] = $market;
            $market->setSeller($this);
        }

        return $this;
    }

    public function removeMarket(Market $market): self
    {
        if ($this->market->removeElement($market)) {
            // set the owning side to null (unless already changed)
            if ($market->getSeller() === $this) {
                $market->setSeller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChestHistory[]
     */
    public function getChestHistory(): Collection
    {
        return $this->chestHistory;
    }

    public function addChestHistory(ChestHistory $chestHistory): self
    {
        if (!$this->chestHistory->contains($chestHistory)) {
            $this->chestHistory[] = $chestHistory;
            $chestHistory->setWallet($this);
        }

        return $this;
    }

    public function removeChestHistory(ChestHistory $chestHistory): self
    {
        if ($this->chestHistory->removeElement($chestHistory)) {
            // set the owning side to null (unless already changed)
            if ($chestHistory->getWallet() === $this) {
                $chestHistory->setWallet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MarketHistory[]
     */
    public function getSellHistory(): Collection
    {
        return $this->sellHistory;
    }

    public function addSellHistory(MarketHistory $sellHistory): self
    {
        if (!$this->sellHistory->contains($sellHistory)) {
            $this->sellHistory[] = $sellHistory;
            $sellHistory->setSeller($this);
        }

        return $this;
    }

    public function removeSellHistory(MarketHistory $sellHistory): self
    {
        if ($this->sellHistory->removeElement($sellHistory)) {
            // set the owning side to null (unless already changed)
            if ($sellHistory->getSeller() === $this) {
                $sellHistory->setSeller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MarketHistory[]
     */
    public function getBuyHistory(): Collection
    {
        return $this->buyHistory;
    }

    public function addBuyHistory(MarketHistory $buyHistory): self
    {
        if (!$this->buyHistory->contains($buyHistory)) {
            $this->buyHistory[] = $buyHistory;
            $buyHistory->setBuyer($this);
        }

        return $this;
    }

    public function removeBuyHistory(MarketHistory $buyHistory): self
    {
        if ($this->buyHistory->removeElement($buyHistory)) {
            // set the owning side to null (unless already changed)
            if ($buyHistory->getBuyer() === $this) {
                $buyHistory->setBuyer(null);
            }
        }

        return $this;
    }
}

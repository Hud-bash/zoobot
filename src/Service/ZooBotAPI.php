<?php
namespace App\Service;

class ZooBotAPI {
    public string $baseZooKeeperUrl;
    public string $baseWanSwapUrl;
    public $marketJson;
    public $marketHistoryJson;
    public $nftJson;
    public $chestHistoryJson;
    public $nftLockJson;
    public $tokenJson;

    public function __construct($baseZooKeeperUrl, $baseWanSwapUrl) {
        $this->baseZooKeeperUrl = $baseZooKeeperUrl;
        $this->baseWanSwapUrl = $baseWanSwapUrl;
        $this->GetNft();
        $this->GetNftLock();
        $this->GetMarket();
        $this->GetMarketHistory();
        $this->GetChestHistory();
        $this->GetToken();
    }

    public function webGet(string $suffix, string $site) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $site . $suffix,
            CURLOPT_RETURNTRANSFER => 'true'
            ]
        );
        return json_decode(curl_exec($ch)); 
    }

    public function GetMarket() {
        $this->marketJson = $this->webGet('zookeeper', $this->baseZooKeeperUrl);
        return $this->marketJson;
    }

    public function GetMarketHistory() {
        $this->marketHistoryJson = $this->webGet('market', $this->baseZooKeeperUrl);
        return $this->marketHistoryJson;
    }

    public function GetChestHistory() {
        $this->chestHistoryJson = $this->webGet('chest', $this->baseZooKeeperUrl);
        return $this->chestHistoryJson;
    }

    public function GetNft() {
        $this->nftJson = $this->webGet('nft', $this->baseZooKeeperUrl);
        return $this->nftJson;
    }

    public function GetNftLock() {
        $this->nftLockJson = $this->webGet('nftInfo', $this->baseZooKeeperUrl);
        return $this->nftLockJson;
    }

    public function GetToken() {
        $this->tokenJson = $this->webGet('wanswap.tokenlist.json', $this->baseWanSwapUrl);
        return $this->tokenJson->tokens;
    }
}
<?php
namespace App\Service;

class ZooBotAPI {
    public string $baseUrl;
    public $marketJson;
    public $marketHistoryJson;
    public $nftJson;
    public $chestHistoryJson;
    public $nftLockJson;

    public function __construct($baseUrl) {
        $this->baseUrl = $baseUrl;
        $this->nftJson = $this->webGet("nft");
        $this->nftLockJson = $this->webGet("nftInfo");
        $this->marketJson = $this->webGet("zookeeper");
        $this->marketHistoryJson = $this->webGet("market");
        $this->chestHistoryJson = $this->webGet("chest");
    }

    public function webGet(string $suffix) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->baseUrl . $suffix,
            CURLOPT_RETURNTRANSFER => 'true'
            ]
        );
        return json_decode(curl_exec($ch)); 
    }

    public function GetMarket() {
        $this->marketJson = $this->webGet("zookeeper");
        return $this->marketJson;
    }

    public function GetMarketHistory() {
        $this->marketHistoryJson = $this->webGet("market");
        return $this->marketHistoryJson;
    }

    public function GetChestHistory() {
        $this->chestHistoryJson = $this->webGet("chest");
        return $this->chestHistoryJson;
    }

    public function GetNft() {
        $this->nftJson = $this->webGet("nft");
        return $this->nftJson;
    }

    public function GetNftLock() {
        $this->nftLockJson = $this->webGet("nftInfo");
        return $this->nftLockJson;
    }
}
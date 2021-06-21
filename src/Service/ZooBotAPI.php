<?php
namespace App\Service;

class ZooBotAPI {
    public $baseUrl;

    public function __construct(string $baseUrl) {
        $this->baseUrl = $baseUrl;
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
        $r = $this->webGet("zookeeper");   
        return $r;
    }

    public function GetMarketHistory() {
        $r = $this->webGet("market");
        return $r;
    }

    public function GetChestHistory() {
        $r = $this->webGet("chest");
        return $r;
    }

    public function GetNft() {
        $r = $this->webGet("nft");
        return $r;
    }

    public function GetNftLock() {
        $r = $this->webGet("nftInfo");
        return $r;
    }
}
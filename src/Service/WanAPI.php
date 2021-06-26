<?php
namespace App\Service;

class WanAPI {

    private string $wanAPItokenArtUrl;

    public function __construct(string $wanAPItokenArtUrl)
    {
        $this->wanAPItokenArtUrl = $wanAPItokenArtUrl;
    }

    public function webGet(string $url) {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 'true'
            ]
        );
        return curl_exec($ch);
    }

    public function GetTokenId(string $tokenAddress): string
    {
        $result = $this->webGet($this->wanAPItokenArtUrl . $tokenAddress);
        dump($this->wanAPItokenArtUrl . $tokenAddress);
        dump(PHP_EOL);

        return 'Token retrieved';
    }
}
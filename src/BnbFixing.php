<?php

namespace Mchervenkov\BnbFixing;


use Mchervenkov\BnbFixing\Exceptions\BnbFixingException;

class BnbFixing
{
    /**
     * BnbFixing XML Url
     */
    private string $url;

    public function __construct()
    {
        $this->url = config('bnb_fixing.xml_url');
    }

    /**
     * set url
     *
     * @param  string $url
     * @return void
     */
    public function setBaseUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * get url
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getXmlContent(): string
    {
        return file_get_contents($this->url);
    }

    /**
     * Get Certain exchange rate by code for certain bulgarian lev amount
     */
    public function getExchangeRateAmount(string $exchangeRateCode, int|float $amount): float|int
    {
        $exchangeRate = $this->findExchangeRate($exchangeRateCode);

        return $amount * $exchangeRate->reverse_rate;
    }

    /**
     * Get Bulgarian Lev Rate for certain exchange rate and amount
     */
    public function getReverseExchangeRateAmount(string $exchangeRateCode, int|float $amount): float|int
    {
        $exchangeRate = $this->findExchangeRate($exchangeRateCode);

        return ($amount / $exchangeRate->ratio) * $exchangeRate->rate;
    }

    protected function findExchangeRate(string $exchangeRateCode)
    {
        $exchangeRate = \Mchervenkov\BnbFixing\Models\BnbFixing::query()
            ->where('code', $exchangeRateCode)
            ->first();

        if(!$exchangeRate) {
            throw new BnbFixingException('The Exchange rate code is not found in Bnb Fixing table');
        }

        return $exchangeRate;
    }

}

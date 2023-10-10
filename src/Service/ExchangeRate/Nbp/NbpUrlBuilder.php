<?php

namespace App\Service\ExchangeRate\Nbp;

use App\Enum\NbpTable;
use App\Exception\NbpUrlException;

class NbpUrlBuilder
{
    private NbpUrl $nbpUrl;

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): void
    {
        $this->nbpUrl = new NbpUrl();
    }
    public function setBaseUrl(string $baseUrl): void
    {
        $this->nbpUrl->baseUrl = $baseUrl;
    }

    public function setTable(NbpTable $table): void
    {
        $this->nbpUrl->table = $table;
    }

    public function setCode(string $code): void
    {
        $this->nbpUrl->code = $code;
    }

    public function setSeriesAmount(int $seriesAmount): void
    {
        if ($this->nbpUrl->date || $this->nbpUrl->endDate) {
            throw new NbpUrlException('Cannot use returned amount along with dates');
        }

        $this->nbpUrl->seriesAmount = 'last/'.$seriesAmount;
    }

    public function setDate(\DateTime $date): void
    {
        if ($this->nbpUrl->seriesAmount) {
            throw new NbpUrlException('Cannot use dates along with returned amount');
        }

        $this->nbpUrl->date = $date;
    }

    public function setEndDate(\DateTime $endDate): void
    {
        if ($this->nbpUrl->seriesAmount) {
            throw new NbpUrlException('Cannot use dates along with returned amount');
        }

        $this->nbpUrl->endDate = $endDate;
    }

    public function build(): NbpUrl
    {
        if (! $this->nbpUrl->date && $this->nbpUrl->endDate) {
            throw new NbpUrlException('start or end Date missing');
        }

        $result = $this->nbpUrl;
        $this->reset();

        return $result;
    }
}

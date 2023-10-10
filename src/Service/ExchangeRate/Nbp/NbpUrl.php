<?php

namespace App\Service\ExchangeRate\Nbp;

use App\Enum\NbpTable;

class NbpUrl
{
    public string $baseUrl       = 'http://api.nbp.pl/api/exchangerates/tables';
    public NbpTable $table       = NbpTable::A;
    public ?string $code         = null;
    public ?string $seriesAmount = null;
    public ?\DateTime $date      = null;
    public ?\DateTime $endDate   = null;

    public function url(): string
    {
        return implode('/', array_filter([
            $this->baseUrl,
            $this->table->name,
            $this->code,
            $this->seriesAmount,
            $this->date?->format('Y-m-d'),
            $this->endDate?->format('Y-m-d'),
        ]));
    }
}

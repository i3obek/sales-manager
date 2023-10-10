<?php

namespace App\Enum;

enum CurrencyType: int
{
    case FIAT   = 0;
    case CRYPTO = 1;
    case NFT    = 2;
}

<?php

namespace App\Enums;

enum OrderSources: string
{
    case WALMART= 'walmart';
    case EBAY= 'ebay';
    case AMAZON= 'amazon';
}

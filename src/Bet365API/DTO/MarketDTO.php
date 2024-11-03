<?php

namespace DarksLight2\BetsApiSDK\Bet365API\DTO;

use Illuminate\Support\Collection;

class MarketDTO
{
    public function __construct(
        public int|string $id,
        public string $name,
        public Collection $odds
    ) {}
}

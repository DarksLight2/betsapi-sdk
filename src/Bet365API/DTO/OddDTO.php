<?php

namespace DarksLight2\BetsApiSDK\Bet365API\DTO;

class OddDTO
{
    public function __construct(
        public int $id,
        public string $odds,
        public string $header,
        public string $name,
        public string $handicap
    ) {}
}

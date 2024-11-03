<?php

namespace DarksLight2\BetsApiSDK\Bet365API\DTO;

readonly class EventLeagueDTO
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
}

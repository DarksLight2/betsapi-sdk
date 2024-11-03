<?php

namespace DarksLight2\BetsApiSDK\Bet365API\DTO;

readonly class EventTeamDTO
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
}

<?php

namespace DarksLight2\BetsApiSDK\EverythingAPI\DTO;

use DarksLight2\BetsApiSDK\EverythingAPI\Enums\SportType;
use DarksLight2\BetsApiSDK\EverythingAPI\Enums\TimeStatus;

readonly class EventLeagueDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $cc = null,
    ) {}
}

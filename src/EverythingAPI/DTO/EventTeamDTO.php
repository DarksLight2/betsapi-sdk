<?php

namespace DarksLight2\BetsApiSDK\EverythingAPI\DTO;

use DarksLight2\BetsApiSDK\EverythingAPI\Enums\SportType;
use DarksLight2\BetsApiSDK\EverythingAPI\Enums\TimeStatus;

readonly class EventTeamDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public ?int $image_id = null,
        public ?string $cc = null,
    ) {}
}

<?php

namespace DarksLight2\BetsApiSDK\Bet365API\DTO\Odd\Soccer;

readonly class AsianCornersDTO
{
    public function __construct(
        public int $id,
        public string $over_od,
        public string $handicap,
        public string $under_od,
        public ?string $ss,
        public ?string $ss2,
        public int|string|null $time_str,
        public int $add_time,
    ) {}
}

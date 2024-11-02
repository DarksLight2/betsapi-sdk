<?php

namespace DarksLight2\BetsApiSDK\DTO\Odd\Soccer;

readonly class AsianHandicapDTO
{
    public function __construct(
        public int $id,
        public string $home_od,
        public string $handicap,
        public string $away_od,
        public string $ss,
        public int $time_str,
        public int $add_time,
    ) {}
}

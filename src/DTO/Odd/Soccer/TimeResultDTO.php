<?php

namespace DarksLight2\BetsApiSDK\DTO\Odd\Soccer;

readonly class TimeResultDTO
{
    public function __construct(
        public int $id,
        public string $home_od,
        public string $draw_od,
        public string $away_od,
        public string $ss,
        public int $time_str,
        public int $add_time,
    ) {}
}

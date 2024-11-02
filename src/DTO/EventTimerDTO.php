<?php

namespace DarksLight2\BetsApiSDK\DTO;

use DarksLight2\BetsApiSDK\Enums\SportType;
use DarksLight2\BetsApiSDK\Enums\TimeStatus;

readonly class EventTimerDTO
{
    /**
     * @param int $tm - Time minute
     * @param int $ts - Time second
     * @param int $tt -
     * @param int $ta
     * @param int $md
     */
    public function __construct(
        public int $tm = 0,
        public int $ts = 0,
        public int $tt = 0,
        public int $ta = 0,
        public int $md = 0,
    ) {}
}

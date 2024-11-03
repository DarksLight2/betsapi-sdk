<?php

namespace DarksLight2\BetsApiSDK\EverythingAPI\DTO;

use DarksLight2\BetsApiSDK\EverythingAPI\Enums\SportType;
use DarksLight2\BetsApiSDK\EverythingAPI\Enums\TimeStatus;

readonly class EventDTO
{
    public function __construct(
        public int $id,
        public SportType $sport_type,
        public int $time,
        public TimeStatus $time_status,
        public EventLeagueDTO $league,
        public EventTeamDTO $home,
        public EventTeamDTO $away,
        public ?string $ss,
        public array $scores,
        public ?int $bet365_id,
        public ?EventTimerDTO $timer,
        public EventStatDTO $stats,
    ) {}
}

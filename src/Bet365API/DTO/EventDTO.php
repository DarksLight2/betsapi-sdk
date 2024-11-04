<?php

namespace DarksLight2\BetsApiSDK\Bet365API\DTO;

use DarksLight2\BetsApiSDK\Bet365API\Enums\SportType;
use DarksLight2\BetsApiSDK\Bet365API\Enums\TimeStatus;

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
        public string|int $our_event_id,
        public string|int|null $r_id,
        public string|int|null $ev_id,
        public int $updated_at,
    ) {}
}

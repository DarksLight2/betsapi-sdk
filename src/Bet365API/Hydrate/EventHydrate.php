<?php

namespace DarksLight2\BetsApiSDK\Bet365API\Hydrate;

use Illuminate\Support\Collection;
use DarksLight2\BetsApiSDK\Bet365API\DTO\EventDTO;
use DarksLight2\BetsApiSDK\Bet365API\Enums\SportType;
use DarksLight2\BetsApiSDK\Bet365API\DTO\EventTeamDTO;
use DarksLight2\BetsApiSDK\Bet365API\Enums\TimeStatus;
use DarksLight2\BetsApiSDK\Bet365API\DTO\EventLeagueDTO;

class EventHydrate
{
    public static function hydrate(array $events): Collection
    {
        return collect($events)->map(function ($event) {
            $league = new EventLeagueDTO(
                id: $event['league']['id'],
                name: $event['league']['name'],
            );

            $home = new EventTeamDTO(
                id: $event['home']['id'],
                name: $event['home']['name'],
            );

            $away = new EventTeamDTO(
                id: $event['away']['id'],
                name: $event['away']['name'],
            );

            return new EventDTO(
                id: $event['id'],
                sport_type: SportType::from($event['sport_id']),
                time: $event['time'],
                time_status: TimeStatus::from($event['time_status']),
                league: $league,
                home: $home,
                away: $away,
                ss: $event['ss'] ?? '0-0',
                our_event_id: $event['our_event_id'],
                r_id: $event['r_id'],
                ev_id: $event['ev_id'],
                updated_at: $event['updated_at'],
            );
        });
    }
}

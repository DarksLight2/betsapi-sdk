<?php

namespace DarksLight2\BetsApiSDK\Hydrate;

use Illuminate\Support\Collection;
use DarksLight2\BetsApiSDK\DTO\EventDTO;
use DarksLight2\BetsApiSDK\DTO\LeagueDTO;
use DarksLight2\BetsApiSDK\Enums\SportType;
use DarksLight2\BetsApiSDK\DTO\EventTeamDTO;
use DarksLight2\BetsApiSDK\Enums\TimeStatus;
use DarksLight2\BetsApiSDK\DTO\EventStatDTO;
use DarksLight2\BetsApiSDK\DTO\EventTimerDTO;
use DarksLight2\BetsApiSDK\DTO\EventLeagueDTO;

class LeagueHydrate
{
    public static function hydrate(array $events): Collection
    {
        return collect($events)->map(function ($event) {
            return new LeagueDTO(
                id: $event['id'],
                name: $event['name'],
                cc: $event['cc'],
                has_league_table: $event['has_leaguetable'],
                has_top_list: $event['has_toplist'],
            );
        });
    }
}

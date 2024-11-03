<?php

namespace DarksLight2\BetsApiSDK\EverythingAPI\Hydrate;

use Illuminate\Support\Collection;
use DarksLight2\BetsApiSDK\EverythingAPI\DTO\EventDTO;
use DarksLight2\BetsApiSDK\EverythingAPI\DTO\LeagueDTO;
use DarksLight2\BetsApiSDK\EverythingAPI\DTO\EventTeamDTO;
use DarksLight2\BetsApiSDK\EverythingAPI\DTO\EventStatDTO;
use DarksLight2\BetsApiSDK\EverythingAPI\DTO\EventTimerDTO;
use DarksLight2\BetsApiSDK\EverythingAPI\DTO\EventLeagueDTO;

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

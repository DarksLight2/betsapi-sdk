<?php

namespace DarksLight2\BetsApiSDK\Bet365API\Hydrate;

use Illuminate\Support\Collection;
use DarksLight2\BetsApiSDK\Bet365API\DTO\OddDTO;
use DarksLight2\BetsApiSDK\Bet365API\DTO\EventDTO;
use DarksLight2\BetsApiSDK\Bet365API\DTO\MarketDTO;
use DarksLight2\BetsApiSDK\Bet365API\Enums\SportType;
use DarksLight2\BetsApiSDK\Bet365API\DTO\EventTeamDTO;
use DarksLight2\BetsApiSDK\Bet365API\Enums\TimeStatus;
use DarksLight2\BetsApiSDK\Bet365API\DTO\EventLeagueDTO;

class OddHydrate
{
    public static function hydrate(array $data): Collection
    {
        if(!isset($data[0]['others']) || !isset($data[0]['main']))
            return collect();

        $others = array_reduce($data[0]['others'], function ($carry, $item) {
            return array_merge($carry, $item['sp']);
        }, []);

        return self::one($data[0]['main']['sp'])
            ->merge(self::one($others));
    }

    private static function one(array $arr): Collection
    {
        $markets = collect();
        foreach ($arr as $market) {
            $odds = collect();

            foreach ($market['odds'] as $odd) {
                $odds->push(new OddDTO(
                    id: $odd['id'],
                    odds: $odd['odds'],
                    header: $odd['header'] ?? '',
                    name: $odd['name'] ?? '',
                    handicap: $odd['handicap'] ?? ''
                ));
            }

            $markets->push(new MarketDTO(
                id: $market['id'],
                name: $market['name'],
                odds: $odds
            ));
        }

        return $markets;
    }
}

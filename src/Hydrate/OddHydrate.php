<?php

namespace DarksLight2\BetsApiSDK\Hydrate;

use Illuminate\Support\Collection;
use DarksLight2\BetsApiSDK\DTO\Odd\Soccer;
use DarksLight2\BetsApiSDK\Collections\OddCollection;

class OddHydrate
{
    public static function hydrate(array $markets): OddCollection
    {
        $c = new OddCollection();

        foreach ($markets as $market_key => $market) {
            $odds_collection = collect();
            foreach ($market as $odd) {
                $dto_class = self::resolveDTO($market_key);
                $odds_collection->push(new $dto_class(...$odd));
            }
            $c->put($market_key, $odds_collection);
        }
        return $c;
    }

    public static function resolveDTO(string $market_key): string
    {
        return match ($market_key) {
            '1_1', '1_8' => Soccer\TimeResultDTO::class,
            '1_2', '1_5' => Soccer\AsianHandicapDTO::class,
            '1_3', '1_6' => Soccer\GoalLineDTO::class,
            '1_4', '1_7' => Soccer\AsianCornersDTO::class,
        };
    }
}

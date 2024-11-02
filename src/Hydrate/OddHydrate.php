<?php

namespace DarksLight2\BetsApiSDK\Hydrate;

use Illuminate\Support\Collection;
use DarksLight2\BetsApiSDK\DTO\Odd\Soccer;

class OddHydrate
{
    public static function hydrate(array $markets): Collection
    {
        return collect($markets)->map(function ($odds, string $market_key) {
            foreach ($odds as $odd) {
                $dto_class = self::resolveDTO($market_key);
                return new $dto_class(...$odd);
            }
            return null;
        });
    }

    private static function resolveDTO(string $market_key): string
    {
        return match ($market_key) {
            '1_1', '1_8' => Soccer\TimeResultDTO::class,
            '1_2', '1_5' => Soccer\AsianHandicapDTO::class,
            '1_3', '1_6' => Soccer\GoalLineDTO::class,
            '1_4', '1_7' => Soccer\AsianCornersDTO::class,
        };
    }
}

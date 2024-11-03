<?php

namespace DarksLight2\BetsApiSDK\EverythingAPI;

use DarksLight2\BetsApiSDK\EverythingAPI\DTO\Odd\Soccer;

class OddDTOResolver
{
    public static function resolve(string $market_key): string
    {
        return match ($market_key) {
            '1_1', '1_8' => Soccer\TimeResultDTO::class,
            '1_2', '1_5' => Soccer\AsianHandicapDTO::class,
            '1_3', '1_6' => Soccer\GoalLineDTO::class,
            '1_4', '1_7' => Soccer\AsianCornersDTO::class,
        };
    }
}

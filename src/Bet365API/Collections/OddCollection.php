<?php

namespace DarksLight2\BetsApiSDK\Collections;

use Illuminate\Support\Collection;
use DarksLight2\BetsApiSDK\OddDTOResolver;
use DarksLight2\BetsApiSDK\Bet365API\DTO\Odd\Soccer;

class OddCollection extends Collection
{
    public function latest(): self
    {
        return $this->map(function ($odds, $marketKey) {
            $dtoClass = OddDTOResolver::resolve($marketKey);

            if ($dtoClass === Soccer\TimeResultDTO::class) {
                return $odds->sortByDesc('add_time')->first();
            } else {
                return $odds->groupBy('handicap')->map(function ($group) {
                    return $group->sortByDesc('add_time')->first();
                })->values();
            }
        });
    }
}

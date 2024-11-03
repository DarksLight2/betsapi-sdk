<?php

namespace DarksLight2\BetsApiSDK\EverythingAPI\Hydrate;

use Illuminate\Support\Collection;
use DarksLight2\BetsApiSDK\EverythingAPI\OddDTOResolver;

class OddSummaryHydrate
{
    public static function hydrate(array $bookmakers): Collection
    {
        $result = collect();
        foreach ($bookmakers as $bookmaker_key => $bookmaker) {
            $variants_collection = collect();
            foreach ($bookmaker['odds'] as $variant_key => $variants) {
                $odds_collection = collect();
                foreach ($variants as $market_key => $odd) {
                    if(is_null($odd)) {
                        $odds_collection->push(null);
                        continue;
                    }
                    $dto_class = OddDTOResolver::resolve($market_key);
                    $odds_collection->put($market_key, new $dto_class(...$odd));
                }
                $variants_collection->put($variant_key, $odds_collection);
            }
            $result->put($bookmaker_key, $variants_collection);
        }

        return $result;
    }
}

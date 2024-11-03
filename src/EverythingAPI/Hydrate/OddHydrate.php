<?php

namespace DarksLight2\BetsApiSDK\EverythingAPI\Hydrate;

use DarksLight2\BetsApiSDK\EverythingAPI\OddDTOResolver;
use DarksLight2\BetsApiSDK\Collections\EverythingAPI\OddCollection;

class OddHydrate
{
    public static function hydrate(array $markets): OddCollection
    {
        $c = new OddCollection();

        foreach ($markets as $market_key => $market) {
            $odds_collection = collect();
            foreach ($market as $odd) {
                $dto_class = OddDTOResolver::resolve($market_key);
                $odds_collection->push(new $dto_class(...$odd));
            }
            $c->put($market_key, $odds_collection);
        }
        return $c;
    }
}

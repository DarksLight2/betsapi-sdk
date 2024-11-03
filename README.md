# Installing

### 1. Install package
```shell
composer require darkslight2/betsapi-sdk
```
### 2. Add to .env 
```dotenv
BETSAPI_TOKEN=
BETSAPI_URL=https://api.b365api.com
```

# Enums
```php
use DarksLight2\BetsApiSDK\Enums\SportType;
use DarksLight2\BetsApiSDK\Enums\CountryCode;
use DarksLight2\BetsApiSDK\Enums\TimeStatus;
```

# Using BET365 API
### Getting in-play filter events
Available fot soccer, volleyball, basketball, baseball
```php
use DarksLight2\BetsApiSDK\Bet365API\RequestMaker;
use DarksLight2\BetsApiSDK\Bet365API\DTO\EventDTO;
use DarksLight2\BetsApiSDK\Bet365API\Enums\SportType;
use DarksLight2\BetsApiSDK\Bet365API\Hydrate\EventHydrate;

EventHydrate::hydrate(RequestMaker::inPlayFilter(SportType::Soccer))
    ->each(function (EventDTO $event) {
        // do something...
    })
```
### Getting result
Available fot `soccer`, `volleyball`, `basketball`, `baseball`.

Using `EventHydrate` from `EverythingAPI` because it has the same fields.
```php
use DarksLight2\BetsApiSDK\Bet365API\RequestMaker;
use DarksLight2\BetsApiSDK\EverythingAPI\Hydrate\EventHydrate;
use DarksLight2\BetsApiSDK\EverythingAPI\DTO\EventDTO;

EventHydrate::hydrate(RequestMaker::result(<event_id>))
    ->each(function (EventDTO $event) {
        // do something...
    })
```
# Using EVERYTHING API
### Getting events
```php
use DarksLight2\BetsApiSDK\EverythingAPI\RequestMaker;
use DarksLight2\BetsApiSDK\EverythingAPI\DTO\EventDTO;
use DarksLight2\BetsApiSDK\EverythingAPI\Enums\SportType;
use DarksLight2\BetsApiSDK\EverythingAPI\Hydrate\EventHydrate;

$upcoming = EventHydrate::hydrate(RequestMaker::upcoming(SportType::Soccer, day: now()))
    ->each(function (EventDTO $event) {
        // do something...
    });

$in_play = EventHydrate::hydrate(RequestMaker::inPlay(SportType::Soccer))
    ->each(function (EventDTO $event) {
        // do something...
    });
```
### Getting leagues
```php
use DarksLight2\BetsApiSDK\EverythingAPI\RequestMaker;
use DarksLight2\BetsApiSDK\EverythingAPI\Enums\SportType;
use DarksLight2\BetsApiSDK\EverythingAPI\Hydrate\EventHydrate;

foreach (CountryCode::cases() as $country_code) {
    LeagueHydrate::hydrate(RequestMaker::leagues(SportType::Soccer, $country_code))
        ->each(function (LeagueDTO $league) {
            // do something...
        });
}
```
### Getting odds
```php
use DarksLight2\BetsApiSDK\EverythingAPI\Collections\OddCollection;
use DarksLight2\BetsApiSDK\EverythingAPI\RequestMaker;
use DarksLight2\BetsApiSDK\EverythingAPI\Hydrate\OddHydrate;

OddHydrate::hydrate(RequestMaker::odds(<event_id>, 'bet365'))
    ->each(function (OddCollection $collection) {
        // do something...
    });
```
### Getting summary odds
```php
use DarksLight2\BetsApiSDK\EverythingAPI\RequestMaker;
use DarksLight2\BetsApiSDK\EverythingAPI\Hydrate\OddHydrate;
use DarksLight2\BetsApiSDK\EverythingAPI\Hydrate\OddSummaryHydrate;

OddSummaryHydrate::hydrate(RequestMaker::oddsSummary(<event_id>, limit:100))
    ->each(function (Collection $collection) {
        // do something...
    });
```

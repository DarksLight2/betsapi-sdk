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

# Using
### Getting events

```php
use DarksLight2\BetsApiSDK\RequestMaker;
use DarksLight2\BetsApiSDK\DTO\EventDTO;use DarksLight2\BetsApiSDK\Enums\SportType;
use DarksLight2\BetsApiSDK\Hydrate\EventHydrate;

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
use DarksLight2\BetsApiSDK\RequestMaker;
use DarksLight2\BetsApiSDK\Enums\SportType;
use DarksLight2\BetsApiSDK\Hydrate\EventHydrate;

foreach (CountryCode::cases() as $country_code) {
    LeagueHydrate::hydrate(RequestMaker::leagues(SportType::Soccer, $country_code))
        ->each(function (LeagueDTO $league) {
            // do something...
        });
}
```
### Getting odds
```php

```
### Getting teams
```php

```

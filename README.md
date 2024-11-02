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

# Using

```php
use DarksLight2\BetsApiSDK\RequestMaker;
use DarksLight2\BetsApiSDK\Enums\SportType;
use DarksLight2\BetsApiSDK\Hydrate\EventHydrate;

$upcoming = RequestMaker::upcoming(SportType::Soccer, day: now());
$in_play = RequestMaker::inPlay(SportType::Soccer);

$upcoming_events = EventHydrate::hydrate($raw_data);
$in_play_events = EventHydrate::hydrate($in_play);
```

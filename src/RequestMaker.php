<?php

namespace DarksLight2\BetsApiSDK;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use DarksLight2\BetsApiSDK\Enums\SportType;
use DarksLight2\BetsApiSDK\Enums\CountryCode;

class RequestMaker
{
    public static function resolveErrors(Response $response)
    {
        $json = $response->json();

        if(!$response->ok() || empty($json) || !$json['success']) {
            throw new \Exception('Something went wrong');
        }

        return $json;
    }

    public static function paging(string $endpoint, array $queries = []): array
    {
        try {
            $current_page = 0;
            $result = [];
            do {
                $current_page += 1;
                $response = Http::withHeaders([
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                    ->get($endpoint, array_merge($queries, ['page' => $current_page]));

                $data = self::resolveErrors($response);
                $pages_amount = (int)round($data['pager']['total'] / $data['pager']['per_page']) + 1;
                $result = array_merge($result, $data['results']);
            } while ($data['pager']['page'] !== $pages_amount);

            return $result;

        } catch (\Exception $e) {
            report($e);
            return [];
        }
    }

    public static function make(string $uri, SportType $sport_type, array $queries = []): array
    {
        $q = [
            'sport_id' => $sport_type->value,
            'token' => config('betsapi-sdk.token')
        ];

        $endpoint = config('betsapi-sdk.url') . $uri;

        return self::paging($endpoint, array_merge($q, $queries));
    }

    /**
     * @param SportType $sport_type - R-SportID
     * @param string|int|null $league_id - useful when you want only one league
     * @return array
     */
    public static function inPlay(SportType $sport_type, string|int|null $league_id = null): array
    {
        $q = is_null($league_id) ? [] : ['league_id' => $league_id];
        $uri = '/' . config('betsapi-sdk.endpoint_versions.inplay') . '/events/inplay';

        return self::make($uri, $sport_type, $q);
    }

    /**
     * @param SportType $sport_type - R-SportID
     * @param string|int|null $league_id - useful when you want only one league
     * @param string|int|null $team_id - useful when you want only one team
     * @param CountryCode|null $cc - R-Countries
     * @param Carbon|string|null $day - format YYYYMMDD, eg: 20161201
     * @param bool $skip_esports - skip Esoccer, Ebasketball etc. in the result
     * @return mixed
     */
    public static function upcoming(
        SportType $sport_type,
        string|int|null $league_id = null,
        string|int|null $team_id = null,
        CountryCode|null $cc = null,
        Carbon|string $day = null,
        bool $skip_esports = true,
    ): array
    {
        $q = [];

        if(!is_null($league_id)) $q['league_id'] = $league_id;
        if(!is_null($team_id)) $q['team_id'] = $team_id;
        if(!is_null($cc)) $q['cc'] = $cc->value;
        if(!is_null($day)) $q['day'] = is_string($day) ? $day : $day->format('Ymd');
        if(!is_null($skip_esports)) $q['skip_esports'] = $skip_esports;

        $uri = '/' . config('betsapi-sdk.endpoint_versions.upcoming') . '/events/upcoming';

        return self::make($uri, $sport_type, $q);
    }

    public function ended()
    {
        throw new \Exception('Not implemented');
    }

    public function search()
    {
        throw new \Exception('Not implemented');

    }

    public function view()
    {
        throw new \Exception('Not implemented');

    }

    public function history()
    {
        throw new \Exception('Not implemented');

    }

    public function oddsSummary()
    {
        throw new \Exception('Not implemented');

    }

    public function odds(
        string|int $event_id,
        ?string $source = null,
        ?string $since_time = null,
        ?string $odds_market = null,
    )
    {
        throw new \Exception('Not implemented');
        $q = ['event_id' => $event_id];

        if(!is_null($source)) $q['source'] = $source;
        if(!is_null($since_time)) $q['since_time'] = $since_time;
        if(!is_null($odds_market)) $q['odds_market'] = $odds_market;

        $uri = '/' . config('betsapi-sdk.endpoint_versions.odds') . '/events/upcoming';

        return self::make($uri, $q);
    }

    public function statsTrend()
    {
        throw new \Exception('Not implemented');

    }

    public function lineup()
    {
        throw new \Exception('Not implemented');

    }

    public static function leagues(
        SportType $sport_type,
        ?CountryCode $country_code = null
    )
    {
        $q = is_null($country_code) ? [] : ['cc' => $country_code->value];
        $uri = '/' . config('betsapi-sdk.endpoint_versions.league') . '/league';

        return self::make($uri, $sport_type, $q);
    }
}

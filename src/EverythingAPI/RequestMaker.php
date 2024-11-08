<?php

namespace DarksLight2\BetsApiSDK\EverythingAPI;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use DarksLight2\BetsApiSDK\EverythingAPI\Enums\SportType;
use DarksLight2\BetsApiSDK\EverythingAPI\Enums\CountryCode;

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

    public static function paging(string $endpoint, array $queries = [], ?int $limit = null): array
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

                if(!is_null($limit) && count($result) > $limit) {
                    return array_slice($result, 0, $limit);
                }

                if(!isset($data['pager']))
                    return $data['results'];

                $pages_amount = (int)round($data['pager']['total'] / $data['pager']['per_page']) + 1;
                $result = array_merge($result, $data['results']);
            } while ($data['pager']['page'] !== $pages_amount && (is_null($limit) || count($result) < $limit));

            return $result;

        } catch (\Exception $e) {
            report($e);
            return [];
        }
    }

    public static function make(string $uri, ?SportType $sport_type = null, array $queries = [], ?int $limit = null): array
    {
        $q = ['token' => config('betsapi-sdk.token')];

        if(isset($sport_type)) $q['sport_id'] = $sport_type->value;

        $endpoint = config('betsapi-sdk.url') . $uri;

        return self::paging($endpoint, array_merge($q, $queries), limit: $limit);
    }

    /**
     * @param SportType $sport_type - R-SportID
     * @param string|int|null $league_id - useful when you want only one league
     * @return array
     */
    public static function inPlay(SportType $sport_type, string|int|null $league_id = null, ?int $limit = null): array
    {
        $q = is_null($league_id) ? [] : ['league_id' => $league_id];
        $uri = '/' . config('betsapi-sdk.endpoint_versions.everything_api.inplay') . '/events/inplay';

        return self::make($uri, $sport_type, $q, $limit);
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
        ?int $limit = null
    ): array
    {
        $q = [];

        if(!is_null($league_id)) $q['league_id'] = $league_id;
        if(!is_null($team_id)) $q['team_id'] = $team_id;
        if(!is_null($cc)) $q['cc'] = $cc->value;
        if(!is_null($day)) $q['day'] = is_string($day) ? $day : $day->format('Ymd');
        if(!is_null($skip_esports)) $q['skip_esports'] = $skip_esports;

        $uri = '/' . config('betsapi-sdk.endpoint_versions.everything_api.upcoming') . '/events/upcoming';

        return self::make($uri, $sport_type, $q, $limit);
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

    public static function oddsSummary(string|int $event_id, ?int $limit = null)
    {
        $q = ['event_id' => $event_id];
        $uri = '/' . config('betsapi-sdk.endpoint_versions.everything_api.odds_summary') . '/event/odds/summary';
        return self::make($uri, queries: $q, limit: $limit);
    }

    public static function odds(
        string|int $event_id,
        ?string $source = null,
        ?string $since_time = null,
        ?string $odds_market = null,
        ?int $limit = null
    )
    {
        $q = ['event_id' => $event_id];

        if(!is_null($source)) $q['source'] = $source;
        if(!is_null($since_time)) $q['since_time'] = $since_time;
        if(!is_null($odds_market)) $q['odds_market'] = $odds_market;

        $uri = '/' . config('betsapi-sdk.endpoint_versions.everything_api.odds') . '/event/odds';

        return self::make($uri, queries: $q, limit: $limit);
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
        ?CountryCode $country_code = null,
        ?int $limit = null
    )
    {
        $q = is_null($country_code) ? [] : ['cc' => $country_code->value];
        $uri = '/' . config('betsapi-sdk.endpoint_versions.everything_api.league') . '/league';

        return self::make($uri, $sport_type, $q, limit: $limit);
    }
}

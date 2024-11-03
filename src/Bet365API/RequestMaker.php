<?php

namespace DarksLight2\BetsApiSDK\Bet365API;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use DarksLight2\BetsApiSDK\Bet365API\Enums\SportType;

class RequestMaker
{
    public static function resolveErrors(Response $response)
    {
        $json = $response->json();

        if (!$response->ok() || empty($json) || !$json['success']) {
            throw new \Exception('Something went wrong');
        }

        return $json;
    }

    public static function paging(string $endpoint, array $queries = [], ?int $limit = null): array
    {
        try {
            $current_page = 0;
            $result       = [];
            do {
                $current_page += 1;
                $response     = Http::withHeaders([
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                    ->get($endpoint, array_merge($queries, ['page' => $current_page]));

                $data = self::resolveErrors($response);

                if (!isset($data['pager'])) {
                    return !is_null($limit) ? array_slice($data['results'], 0, $limit) : $data['results'];
                }

                $pages_amount = (int)round($data['pager']['total'] / $data['pager']['per_page']) + 1;
                $result       = array_merge($result, $data['results']);

                if (!is_null($limit) && count($result) > $limit) {
                    return array_slice($result, 0, $limit);
                }
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

        if (isset($sport_type)) $q['sport_id'] = $sport_type->value;

        $endpoint = config('betsapi-sdk.url') . $uri;

        return self::paging($endpoint, array_merge($q, $queries), limit: $limit);
    }

    public static function inPlayFilter(
        SportType       $sport_type,
        string|int|null $league_id = null,
        int|null        $limit = null,
        bool            $skip_esports = false,
    )
    {
        $q = [];

        if (!is_null($league_id)) $q['league_id'] = $league_id;
        if (!is_null($skip_esports)) $q['skip_esports'] = $skip_esports;

        $uri = '/' . config('betsapi-sdk.endpoint_versions.bet365_api.inplay_filter') . '/inplay_filter';

        return self::make($uri, $sport_type, queries: $q, limit: $limit);
    }

    public static function upcoming(
        SportType $sport_type,
        string|int|null $league_id = null,
        int|null        $limit = null,
        bool            $skip_esports = false,
        string|Carbon $day = null
    )
    {
        $q = [];

        if(!is_null($league_id)) $q['league_id'] = $league_id;
        if(!is_null($day)) $q['day'] = is_string($day) ? $day : $day->format('Ymd');
        if(!is_null($skip_esports)) $q['skip_esports'] = $skip_esports;

        $uri = '/' . config('betsapi-sdk.endpoint_versions.bet365_api.upcoming') . '/upcoming';
        return self::make($uri, $sport_type, queries: $q, limit: $limit);
    }

    public static function preMatchOdds(string|int $event_id)
    {
        $uri = '/' . config('betsapi-sdk.endpoint_versions.bet365_api.pre_match_odds') . '/prematch';
        return self::make($uri, queries: ['FI' => $event_id]);
    }

    public static function result(string|int $event_id)
    {
        $uri = '/' . config('betsapi-sdk.endpoint_versions.bet365_api.result') . '/result';
        return self::make($uri, queries: ['event_id' => $event_id]);
    }
}

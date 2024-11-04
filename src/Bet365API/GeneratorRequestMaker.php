<?php

namespace DarksLight2\BetsApiSDK\Bet365API;

use Generator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use DarksLight2\BetsApiSDK\Bet365API\Enums\SportType;

#TODO Need refactoring
class GeneratorRequestMaker
{
    public static function resolveErrors(Response $response)
    {
        $json = $response->json();

        if (!$response->ok() || empty($json) || !$json['success']) {
            throw new \Exception('Something went wrong');
        }

        return $json;
    }

    /**
     * If
     * @param array $results
     * @param array $data_limit
     * @param array &$count_limits
     * @return array
     */
    private static function filterResults(array $results, array $data_limit, array &$count_limits): array
    {
        if(empty($data_limit)) return $results;

        $filtered = [];

        foreach ($results as $item) {
            foreach ($data_limit as $key => $limits) {
                if(
                    !isset($count_limits[$key][$item[$key]]) ||
                    $count_limits[$key][$item[$key]] === $limits[$item[$key]]
                )
                    continue;

                if (is_array($limits) && isset($item[$key]) && isset($limits[$item[$key]])) {
                    if ($count_limits[$key][$item[$key]] < $limits[$item[$key]]) {
                        $filtered[] = $item;
                        $count_limits[$key][$item[$key]] = $count_limits[$key][$item[$key]] + 1;
                        break;
                    }
                }
            }
        }

        return $filtered;
    }

    public static function paging(string $endpoint, array $queries = [], array $data_limit = []): Generator
    {
        try {
            $current_page = 0;
            $count_limits = $data_limit;

            foreach ($count_limits as $key => $limits) {
                $count_limits[$key] = array_fill_keys(array_keys($limits), 0);
            }

            do {
                $current_page += 1;
                $response     = Http::withHeaders([
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                    ->get($endpoint, array_merge($queries, ['page' => $current_page]));

                $data = self::resolveErrors($response);

                if (!isset($data['pager'])) {
                    yield self::filterResults($data['results'], $data_limit, $count_limits);
                }

                $pages_amount    = (int)round($data['pager']['total'] / $data['pager']['per_page']) + 1;
                yield self::filterResults($data['results'], $data_limit, $count_limits);

            } while ($data['pager']['page'] !== $pages_amount);
        } catch (\Exception $e) {
            report($e);
            yield [];
        }
    }

    public static function make(string $uri, ?SportType $sport_type = null, array $queries = [], ?int $limit = null, array $data_limit = []): Generator
    {
        $q = ['token' => config('betsapi-sdk.token')];

        if (isset($sport_type)) $q['sport_id'] = $sport_type->value;

        $endpoint = config('betsapi-sdk.url') . $uri;

        return self::paging($endpoint, array_merge($q, $queries), data_limit: $data_limit);
    }

    public static function inPlayFilter(
        SportType       $sport_type,
        string|int|null $league_id = null,
        int|null        $limit = null,
        bool            $skip_esports = false,
    ): Generator
    {
        $q = [];

        if (!is_null($league_id)) $q['league_id'] = $league_id;
        if (!is_null($skip_esports)) $q['skip_esports'] = $skip_esports;

        $uri = '/' . config('betsapi-sdk.endpoint_versions.bet365_api.inplay_filter') . '/inplay_filter';

        return self::make($uri, $sport_type, queries: $q, limit: $limit);
    }

    public static function upcoming(
        SportType       $sport_type,
        string|int|null $league_id = null,
        int|null        $limit = null,
        bool            $skip_esports = false,
        string|Carbon   $day = null,
        array $data_limit = []
    ): Generator
    {
        $q = [];

        if (!is_null($league_id)) $q['league_id'] = $league_id;
        if (!is_null($day)) $q['day'] = is_string($day) ? $day : $day->format('Ymd');
        if (!is_null($skip_esports)) $q['skip_esports'] = $skip_esports;

        $uri = '/' . config('betsapi-sdk.endpoint_versions.bet365_api.upcoming') . '/upcoming';
        return self::make($uri, $sport_type, queries: $q, limit: $limit, data_limit: $data_limit);
    }

    public static function preMatchOdds(string|int $event_id): Generator
    {
        $uri = '/' . config('betsapi-sdk.endpoint_versions.bet365_api.pre_match_odds') . '/prematch';
        return self::make($uri, queries: ['FI' => $event_id]);
    }

    public static function result(string|int $event_id): Generator
    {
        $uri = '/' . config('betsapi-sdk.endpoint_versions.bet365_api.result') . '/result';
        return self::make($uri, queries: ['event_id' => $event_id]);
    }
}

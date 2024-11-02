<?php

return [
    'token'             => env('BETSAPI_TOKEN', ''),
    'url'               => env('BETSAPI_URL', ''),
    'endpoint_versions' => [
        'inplay'         => 'v3',
        'upcoming'       => 'v3',
        'ended'          => 'v3',
        'search'         => 'v1',
        'view'           => 'v1',
        'history'        => 'v1',
        'odds_summary'   => 'v2',
        'odds'           => 'v2',
        'stats_trend'    => 'v1',
        'lineup'         => 'v1',
        'league'         => 'v1',
        'league_table'   => 'v3',
        'league_toplist' => 'v1',
        'team'           => 'v1',
        'team_squad'     => 'v1',
        'team_members'   => 'v1',
        'player'         => 'v1',
        'tennis_ranking' => 'v1',
        'merge_history'  => 'v1',
    ]
];

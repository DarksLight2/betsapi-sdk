<?php

namespace DarksLight2\BetsApiSDK\DTO;

use DarksLight2\BetsApiSDK\Enums\SportType;
use DarksLight2\BetsApiSDK\Enums\TimeStatus;

readonly class EventStatDTO
{
    public function __construct(
        public int $home_attacks = 0,
        public int $away_attacks = 0,
        public int $home_corners = 0,
        public int $away_corners = 0,
        public int $home_corners_h = 0,
        public int $away_corners_h = 0,
        public int $home_dangerous_attacks = 0,
        public int $away_dangerous_attacks = 0,
        public int $home_goals = 0,
        public int $away_goals = 0,
        public int $home_off_target = 0,
        public int $away_off_target = 0,
        public int $home_on_target = 0,
        public int $away_on_target = 0,
        public int $home_penalties = 0,
        public int $away_penalties = 0,
        public int $home_red_cards = 0,
        public int $away_red_cards = 0,
        public int $home_yellow_cards = 0,
        public int $away_yellow_cards = 0,
        public int $home_substitutions = 0,
        public int $away_substitutions = 0,
        public float $home_action_areas = 0.0,
        public float $away_action_areas = 0.0,
        public int $home_ball_safe = 0,
        public int $away_ball_safe = 0,
        public int $home_crosses = 0,
        public int $away_crosses = 0,
        public float $home_crossing_accuracy = 0.0,
        public float $away_crossing_accuracy = 0.0,
        public int $home_fouls = 0,
        public int $away_fouls = 0,
        public int $home_goal_attempts = 0,
        public int $away_goal_attempts = 0,
        public int $home_key_passes = 0,
        public int $away_key_passes = 0,
        public float $home_passing_accuracy = 0.0,
        public float $away_passing_accuracy = 0.0,
        public int $home_possession_rt = 0,
        public int $away_possession_rt = 0,
        public int $home_saves = 0,
        public int $away_saves = 0,
        public int $home_shots_blocked = 0,
        public int $away_shots_blocked = 0,
        public float $home_xg = 0.0,
        public float $away_xg = 0.0,
        public int $home_yellow_red_cards = 0,
        public int $away_yellow_red_cards = 0
    ) {}
}


<?php

namespace DarksLight2\BetsApiSDK\EverythingAPI\Hydrate;

use Illuminate\Support\Collection;
use DarksLight2\BetsApiSDK\EverythingAPI\DTO\EventDTO;
use DarksLight2\BetsApiSDK\EverythingAPI\Enums\SportType;
use DarksLight2\BetsApiSDK\EverythingAPI\DTO\EventTeamDTO;
use DarksLight2\BetsApiSDK\EverythingAPI\Enums\TimeStatus;
use DarksLight2\BetsApiSDK\EverythingAPI\DTO\EventStatDTO;
use DarksLight2\BetsApiSDK\EverythingAPI\DTO\EventTimerDTO;
use DarksLight2\BetsApiSDK\EverythingAPI\DTO\EventLeagueDTO;

class EventHydrate
{
    public static function hydrate(array $events): Collection
    {
        return collect($events)->map(function ($event) {
            $league = new EventLeagueDTO(
                id: $event['league']['id'],
                name: $event['league']['name'],
                cc: $event['league']['cc'],
            );

            $home = new EventTeamDTO(
                id: $event['home']['id'],
                name: $event['home']['name'],
                image_id: $event['home']['image_id'],
                cc: $event['home']['cc'],
            );

            $away = new EventTeamDTO(
                id: $event['away']['id'],
                name: $event['away']['name'],
                image_id: $event['away']['image_id'],
                cc: $event['away']['cc'],
            );

            if(isset($event['timer'])) {
                $timer = new EventTimerDTO(
                    tm: $event['timer']['tm'],
                    ts: $event['timer']['ts'],
                    tt: $event['timer']['tt'],
                    ta: $event['timer']['ta'],
                    md: $event['timer']['md'],
                );
            }

            $stats = new EventStatDTO(
                home_attacks: isset($event['stats']['attacks']) ? $event['stats']['attacks'][0] : 0,
                away_attacks: isset($event['stats']['attacks']) ? $event['stats']['attacks'][1] : 0,
                home_corners: isset($event['stats']['corners']) ? $event['stats']['corners'][0] : 0,
                away_corners: isset($event['stats']['corners']) ? $event['stats']['corners'][1] : 0,
                home_corners_h: isset($event['stats']['corner_h']) ? $event['stats']['corner_h'][0] : 0,
                away_corners_h: isset($event['stats']['corner_h']) ? $event['stats']['corner_h'][1] : 0,
                home_dangerous_attacks: isset($event['stats']['dangerous_attacks']) ? $event['stats']['dangerous_attacks'][0] : 0,
                away_dangerous_attacks: isset($event['stats']['dangerous_attacks']) ? $event['stats']['dangerous_attacks'][1] : 0,
                home_goals: isset($event['stats']['goals']) ? $event['stats']['goals'][0] : 0,
                away_goals: isset($event['stats']['goals']) ? $event['stats']['goals'][1] : 0,
                home_off_target: isset($event['stats']['off_target']) ? $event['stats']['off_target'][0] : 0,
                away_off_target: isset($event['stats']['off_target']) ? $event['stats']['off_target'][1] : 0,
                home_on_target: isset($event['stats']['on_target']) ? $event['stats']['on_target'][0] : 0,
                away_on_target: isset($event['stats']['on_target']) ? $event['stats']['on_target'][1] : 0,
                home_penalties: isset($event['stats']['penalties']) ? $event['stats']['penalties'][0] : 0,
                away_penalties: isset($event['stats']['penalties']) ? $event['stats']['penalties'][1] : 0,
                home_red_cards: isset($event['stats']['redcards']) ? $event['stats']['redcards'][0] : 0,
                away_red_cards: isset($event['stats']['redcards']) ? $event['stats']['redcards'][1] : 0,
                home_yellow_cards: isset($event['stats']['yellowcards']) ? $event['stats']['yellowcards'][0] : 0,
                away_yellow_cards: isset($event['stats']['yellowcards']) ? $event['stats']['yellowcards'][1] : 0,
                home_substitutions: isset($event['stats']['substitutions']) ? $event['stats']['substitutions'][0] : 0,
                away_substitutions: isset($event['stats']['substitutions']) ? $event['stats']['substitutions'][1] : 0,
                home_action_areas: isset($event['stats']['action_areas']) ? $event['stats']['action_areas'][0] : 0,
                away_action_areas: isset($event['stats']['action_areas']) ? $event['stats']['action_areas'][1] : 0,
                home_ball_safe: isset($event['stats']['ball_safe']) ? $event['stats']['ball_safe'][0] : 0,
                away_ball_safe: isset($event['stats']['ball_safe']) ? $event['stats']['ball_safe'][1] : 0,
                home_crosses: isset($event['stats']['crosses']) ? $event['stats']['crosses'][0] : 0,
                away_crosses: isset($event['stats']['crosses']) ? $event['stats']['crosses'][1] : 0,
                home_crossing_accuracy: isset($event['stats']['crossing_accuracy']) ? $event['stats']['crossing_accuracy'][0] : 0,
                away_crossing_accuracy: isset($event['stats']['crossing_accuracy']) ? $event['stats']['crossing_accuracy'][1] : 0,
                home_fouls: isset($event['stats']['fouls']) ? $event['stats']['fouls'][0] : 0,
                away_fouls: isset($event['stats']['fouls']) ? $event['stats']['fouls'][1] : 0,
                home_goal_attempts: isset($event['stats']['goalattempts']) ? $event['stats']['goalattempts'][0] : 0,
                away_goal_attempts: isset($event['stats']['goalattempts']) ? $event['stats']['goalattempts'][1] : 0,
                home_key_passes: isset($event['stats']['key_passes']) ? $event['stats']['key_passes'][0] : 0,
                away_key_passes: isset($event['stats']['key_passes']) ? $event['stats']['key_passes'][1] : 0,
                home_passing_accuracy: isset($event['stats']['passing_accuracy']) ? $event['stats']['passing_accuracy'][0] : 0,
                away_passing_accuracy: isset($event['stats']['passing_accuracy']) ? $event['stats']['passing_accuracy'][1] : 0,
                home_possession_rt: isset($event['stats']['possession_rt']) ? $event['stats']['possession_rt'][0] : 0,
                away_possession_rt: isset($event['stats']['possession_rt']) ? $event['stats']['possession_rt'][1] : 0,
                home_saves: isset($event['stats']['saves']) ? $event['stats']['saves'][0] : 0,
                away_saves: isset($event['stats']['saves']) ? $event['stats']['saves'][1] : 0,
                home_shots_blocked: isset($event['stats']['shots_blocked']) ? $event['stats']['shots_blocked'][0] : 0,
                away_shots_blocked: isset($event['stats']['shots_blocked']) ? $event['stats']['shots_blocked'][1] : 0,
                home_xg: isset($event['stats']['xg']) ? floatval($event['stats']['xg'][0]) : 0,
                away_xg: isset($event['stats']['xg']) ? floatval($event['stats']['xg'][1]) : 0,
                home_yellow_red_cards: isset($event['stats']['yellowred_cards']) ? $event['stats']['yellowred_cards'][0] : 0,
                away_yellow_red_cards: isset($event['stats']['yellowred_cards']) ? $event['stats']['yellowred_cards'][1] : 0
            );

            return new EventDTO(
                id: $event['id'],
                sport_type: SportType::from($event['sport_id']),
                time: $event['time'],
                time_status: TimeStatus::from($event['time_status']),
                league: $league,
                home: $home,
                away: $away,
                ss: $event['ss'],
                scores: $event['scores'] ?? [],
                bet365_id: $event['bet365_id'] ?? null,
                timer: $timer ?? null,
                stats: $stats,
            );
        });
    }
}

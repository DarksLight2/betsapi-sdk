<?php

namespace DarksLight2\BetsApiSDK\EverythingAPI\DTO;

readonly class LeagueDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $cc = null,
        public bool $has_league_table = false,
        public bool $has_top_list = false,
    ) {}
}

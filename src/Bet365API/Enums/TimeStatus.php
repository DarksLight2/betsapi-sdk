<?php

namespace DarksLight2\BetsApiSDK\Bet365API\Enums;

enum TimeStatus: int
{
    case NotStarted  = 0;
    case InPlay      = 1;
    case ToBeFixed   = 2;
    case Ended       = 3;
    case Postponed   = 4;
    case Canceled    = 5;
    case Walkover    = 6;
    case Interrupted = 7;
    case Abandoned   = 8;
    case Retired     = 9;
    case Suspended   = 10;
    case DecidedByFA = 11;
    case Removed     = 99;
}

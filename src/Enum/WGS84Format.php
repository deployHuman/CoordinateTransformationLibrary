<?php

namespace Deployhuman\GpsTransformation\Enum;

enum  WGS84Format: int
{
    case Degrees = 0;
    case DegreesMinutes = 1;
    case DegreesMinutesSeconds = 2;
}

<?php

namespace Deployhuman\GpsTransformation\Enum;

enum Grid: int
{
    case RT90 = 0;
    case WGS84 = 1;
    case SWEREF99 = 3;
}

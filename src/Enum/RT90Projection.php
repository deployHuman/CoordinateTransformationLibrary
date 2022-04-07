<?php

namespace Deployhuman\GpsTransformation\Enum;

enum RT90Projection: int
{
    case rt90_7_5_gon_v = 0;
    case rt90_5_0_gon_v = 1;
    case rt90_2_5_gon_v = 2;
    case rt90_0_0_gon_v = 3;
    case rt90_2_5_gon_o = 5;
    case rt90_5_0_gon_o = 6;
}

<?php

use Deployhuman\GpsTransformation\Enum\WGS84Format;
use Deployhuman\GpsTransformation\Position\SWEREF99Position;
use PHPUnit\Framework\TestCase;

class SWEREF99PositionTest extends TestCase
{

  //@Test
  public function testSwerefToWGS84()
  {
    $swePos = new SWEREF99Position(6652797.165, 658185.201);
    $wgsPos = $swePos->toWGS84();

    // String values from Lantmateriet.se, they convert DMS only.
    // Reference: http://www.lantmateriet.se/templates/LMV_Enkelkoordinattransformation.aspx?id=11500
    $latDmsStringFromLM = "N 59º 58' 55,23001\"";
    $lonDmsStringFromLM = "E 17º 50' 6,11997\"";

    $this->assertEquals($latDmsStringFromLM, $wgsPos->latitudeToString(WGS84Format::DegreesMinutesSeconds));
    $this->assertEquals($lonDmsStringFromLM, $wgsPos->longitudeToString(WGS84Format::DegreesMinutesSeconds));
  }
}

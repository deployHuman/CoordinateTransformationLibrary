<?php


use Deployhuman\GpsTransformation\Enum\WGS84Format;
use Deployhuman\GpsTransformation\Position\RT90Position;
use PHPUnit\Framework\TestCase;

class RT90PositionTest extends TestCase
{

  //@Test
  public function testRT90ToWGS84()
  {
    $position = new RT90Position(6583052, 1627548);
    $wgsPos = $position->toWGS84();

    // Values from Hitta.se for the conversion
    $latFromHitta = 59.3489;
    $lonFromHitta = 18.0473;

    $lat = ((float) round($wgsPos->getLatitude() * 10000)) / 10000;
    $lon = ((float) round($wgsPos->getLongitude() * 10000)) / 10000;

    $this->assertEquals($latFromHitta, $lat); //TODO: fix rounding according to extra parameter: 0.00001d
    $this->assertEquals($lonFromHitta, $lon);

    // String values from Lantmateriet.se, they convert DMS only.
    // Reference: http://www.lantmateriet.se/templates/LMV_Enkelkoordinattransformation.aspx?id=11500
    $latDmsStringFromLM = "N 59º 20' 56,09287\"";
    $lonDmsStringFromLM = "E 18º 2' 50,34806\"";

    $this->assertEquals($latDmsStringFromLM, $wgsPos->latitudeToString(WGS84Format::DegreesMinutesSeconds));
    $this->assertEquals($lonDmsStringFromLM, $wgsPos->longitudeToString(WGS84Format::DegreesMinutesSeconds));
  }
}

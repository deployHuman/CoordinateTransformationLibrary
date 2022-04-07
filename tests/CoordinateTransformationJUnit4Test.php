<?php

use Deployhuman\GpsTransformation\Enum\RT90Projection;
use Deployhuman\GpsTransformation\Enum\SWEREFProjection;
use Deployhuman\GpsTransformation\Enum\WGS84Format;
use Deployhuman\GpsTransformation\ParseException;
use Deployhuman\GpsTransformation\Position\RT90Position;
use Deployhuman\GpsTransformation\Position\SWEREF99Position;
use Deployhuman\GpsTransformation\Position\WGS84Position;
use PHPUnit\Framework\TestCase;

class CoordinateTransformationJUnit4Test extends TestCase
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

  //@Test
  public function testWGS84ToRT90()
  {
    $wgsPos = null;
    $rtPos = null;
    try {
      $wgsPos = new WGS84Position("N 59º 58' 55.23\" E 017º 50' 06.12\"", WGS84Format::DegreesMinutesSeconds);
      $rtPos = new RT90Position($wgsPos, RT90Projection::rt90_2_5_gon_v);
    } catch (ParseException $e) {
      $this->fail($e->getMessage());
    }
    // Conversion values from Lantmateriet.se, they convert from DMS only.
    // Reference: http://www.lantmateriet.se/templates/LMV_Enkelkoordinattransformation.aspx?id=11500
    $xPosFromLM = 6653174.343;
    $yPosFromLM = 1613318.742;

    $lat = ((float) round($rtPos->getLatitude() * 1000) / 1000);
    $lon = ((float) round($rtPos->getLongitude() * 1000) / 1000);

    $this->assertEquals($lat, $xPosFromLM); //fix accuracy: 0.0001d
    $this->assertEquals($lon, $yPosFromLM);
  }

  //@Test
  public function testWGS84ToSweref()
  {
    $wgsPos = new WGS84Position();

    $wgsPos->setLatitudeFromString("N 59º 58' 55.23\"", WGS84Format::DegreesMinutesSeconds);
    $wgsPos->setLongitudeFromString("E 017º 50' 06.12\"", WGS84Format::DegreesMinutesSeconds);

    $rtPos = new SWEREF99Position($wgsPos, SWEREFProjection::sweref_99_tm);

    // Conversion values from Lantmateriet.se, they convert from DMS only.
    // Reference: http://www.lantmateriet.se/templates/LMV_Enkelkoordinattransformation.aspx?id=11500
    $xPosFromLM = 6652797.165;
    $yPosFromLM = 658185.201;

    $lat = ((float)round($rtPos->getLatitude() * 1000) / 1000);
    $lon = ((float) round($rtPos->getLongitude() * 1000) / 1000);
    $this->assertEquals($lat, $xPosFromLM);
    $this->assertEquals($lon, $yPosFromLM);
  }

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

  //@Test
  public function testWGS84Parse()
  {
    // Values from Eniro.se
    $wgsPosDM = null;
    $wgsPosDMs = null;
    try {
      $wgsPosDM = new WGS84Position("N 62º 10.560' E 015º 54.180'", WGS84Format::DegreesMinutes);
      $wgsPosDMs = new WGS84Position("N 62º 10' 33.60\" E 015º 54' 10.80\"", WGS84Format::DegreesMinutesSeconds);
    } catch (ParseException $e) {
      $this->fail($e->getMessage());
    }
    $lat = ((float) round($wgsPosDM->getLatitude() * 1000) / 1000);
    $lon = ((float) round($wgsPosDM->getLongitude() * 1000) / 1000);

    $this->assertEquals(62.176, $lat);
    $this->assertEquals(15.903, $lon);

    $lat_s = ((float) round($wgsPosDMs->getLatitude() * 1000) / 1000);
    $lon_s = ((float) round($wgsPosDMs->getLongitude() * 1000) / 1000);

    $this->assertEquals(62.176, $lat_s);
    $this->assertEquals(15.903, $lon_s);
  }
}

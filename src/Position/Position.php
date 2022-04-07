<?php

namespace Deployhuman\GpsTransformation\Position;

abstract class Position
{

  protected $latitude;
  protected $longitude;
  protected $gridFormat;

  public function __construct()
  {
    $args = func_get_args();
    if (count($args) == 3) {
      call_user_func_array(array($this, 'setPositionLatLonFormat'), $args);
    } else if (count($args) == 1) {
      call_user_func_array(array($this, 'setPositionFormat'), $args);
    }
  }

  private function setPositionLatLonFormat($lat, $lon, $format)
  {
    $this->latitude = $lat;
    $this->longitude = $lon;
    //@todo: validation?
    $this->gridFormat = $format;
  }

  private function setPositionFormat($format)
  {
    //@todo: validation?
    $this->gridFormat = $format;
  }

  public function getLatitude()
  {
    return $this->latitude;
  }
  public function getLongitude()
  {
    return $this->longitude;
  }
}

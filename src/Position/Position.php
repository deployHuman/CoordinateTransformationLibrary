<?php

namespace Deployhuman\GpsTransformation\Position;

use Deployhuman\GpsTransformation\Enum\Grid;

abstract class Position
{

  protected $latitude;
  protected $longitude;
  protected Grid $gridFormat;

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

  /**
   * Sets Grid Format
   *
   * @param Grid $format
   * @return self
   */
  private function setPositionFormat(Grid $format): self
  {
    //@todo: validation?
    $this->gridFormat = $format;
    return $this;
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

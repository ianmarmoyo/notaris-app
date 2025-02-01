<?php

namespace App\Helpers;

use App\Models\StatusOrder;

class StatusOrderMapping
{
  public static function getData($key)
  {
    return StatusOrder::where('key', $key)->first()->id ?: null;
  }

  public static function START_ORDER()
  {
    return self::getData('START_ORDER');
  }

  public static function PAYMENT_PENDING()
  {
    return self::getData('PAYMENT_PENDING');
  }

  public static function CANCLED_EXPIRED()
  {
    return self::getData('CANCLED_EXPIRED');
  }

  public static function PAYMENT_COMPLETED()
  {
    return self::getData('PAYMENT_COMPLETED');
  }

  public static function CANCLED_ORDER()
  {
    return self::getData('CANCLED_ORDER');
  }

  public static function BOOKING_IN_REVIEW()
  {
    return self::getData('BOOKING_IN_REVIEW');
  }

  public static function BOOKING_CONFIRMED()
  {
    return self::getData('BOOKING_CONFIRMED');
  }

  public static function FINDING_DRIVER()
  {
    return self::getData('FINDING_DRIVER');
  }

  public static function DRIVER_ASSIGNED()
  {
    return self::getData('DRIVER_ASSIGNED');
  }

  public static function DRIVER_OTW_LOCATION()
  {
    return self::getData('DRIVER_OTW_LOCATION');
  }

  public static function DRIVER_ARRIVED_PICKUP_LOCATION()
  {
    return self::getData('DRIVER_ARRIVED_PICKUP_LOCATION');
  }

  public static function DRIVER_OWT_PUSPAKOM()
  {
    return self::getData('DRIVER_OWT_PUSPAKOM');
  }

  public static function INSPECTION_IN_PROGRESS()
  {
    return self::getData('INSPECTION_IN_PROGRESS');
  }

  public static function INSPECTION_IS_COMPLETED()
  {
    return self::getData('INSPECTION_IS_COMPLETED');
  }

  public static function DRIVER_OTW_RETURNING_VEHICLE()
  {
    return self::getData('DRIVER_OTW_RETURNING_VEHICLE');
  }

  public static function VEHICLE_IS_RETURNED()
  {
    return self::getData('VEHICLE_IS_RETURNED');
  }

  public static function CONFIRMED_BY_DRIVER()
  {
    return self::getData('CONFIRMED_BY_DRIVER');
  }

  public static function COMPLETED()
  {
    return self::getData('COMPLETED');
  }
}

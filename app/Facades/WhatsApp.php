<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *  Define facades accessor
 */

class WhatsApp extends Facade
{

  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return '\App\Services\WaService';
  }
}

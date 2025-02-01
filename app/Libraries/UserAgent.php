<?php

namespace App\Libraries;

use Phattarachai\LaravelMobileDetect\Agent;

class UserAgent
{
  /**
   * Retrieves the user agent information.
   *
   * This function creates a new instance of the Agent class and returns it.
   *
   * @return Agent The user agent information.
   */
  public function userAgent()
  {
    $agent = new Agent();
    return $agent;
  }
}

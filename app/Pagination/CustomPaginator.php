<?php

namespace App\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;

class CustomPaginator extends LengthAwarePaginator
{
  public function url($page)
  {
    // Kustomisasi URL di sini
    return parent::url($page) . '&custom_param=value';
  }
}

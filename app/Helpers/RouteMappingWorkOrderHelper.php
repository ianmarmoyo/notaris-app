<?php

namespace App\Helpers;
class RouteMappingWorkOrderHelper{
  public static function slugWorkOrder($slug)
  {
    switch ($slug) {
      case 'balik_nama_waris':
        return self::routeMapping($slug);
        break;
      case 'balik_nama_jual_beli':
        return self::routeMapping($slug);
        break;
      case 'pendirian_pt':
        return self::routeMapping($slug);
        break;
      case 'balik_nama_hibah':
        return self::routeMapping($slug);
        break;
      case 'balik_aphb':
        return self::routeMapping($slug);
        break;
      case 'balik_nama_sertifikat':
        return self::routeMapping($slug);
        break;
      case 'pemecah_sertifikat':
        return self::routeMapping($slug);
        break;
      default:
        # code...
        break;
    }
  }

  public static function routeMapping($slug){
    $slugMap = [
      'balik_nama_waris' => 'admin/balik-nama-waris/work-order-assignment',
      'pendirian_pt' => 'admin/pendirian-pt/work-order-assignment',
      'balik_nama_jual_beli' => 'admin/balik-nama-jual-beli/work-order-assignment',
      'balik_nama_hibah' => 'admin/balik-nama-hibah/work-order-assignment',
      'balik_aphb' => 'admin/balik-aphb/work-order-assignment',
      'pemecah_sertifikat' => 'admin/pemecah-sertifikat/work-order-assignment',
      'balik_nama_sertifikat' => 'admin/balik-nama-sertifikat/work-order-assignment',
    ];

    if (isset($slugMap[$slug])) {
      return $slugMap[$slug];
    }
    return null;
  }
}

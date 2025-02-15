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
      case 'peningkatan_hak':
        return self::routeMapping($slug);
        break;
      case 'penurunan_hak':
        return self::routeMapping($slug);
        break;
      case 'penggabungan_sertifikat':
        return self::routeMapping($slug);
        break;
      case 'pelepasan_hak':
        return self::routeMapping($slug);
        break;
      case 'akta_permohonan_hak':
        return self::routeMapping($slug);
        break;
      case 'sertifikat_permohonan_hak':
        return self::routeMapping($slug);
        break;
      case 'pendirian_perkumpulan':
        return self::routeMapping($slug);
        break;
      case 'pendirian_cv':
        return self::routeMapping($slug);
        break;
      case 'pendirian_pt_perorangan':
        return self::routeMapping($slug);
        break;
      case 'pendirian_yayasan':
        return self::routeMapping($slug);
        break;
      case 'perjanjian_lainnya':
        return self::routeMapping($slug);
        break;
      case 'warmarking':
        return self::routeMapping($slug);
        break;
      case 'legalisasi':
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
      'peningkatan_hak' => 'admin/peningkatan-hak/work-order-assignment',
      'penurunan_hak' => 'admin/penurunan-hak/work-order-assignment',
      'penggabungan_sertifikat' => 'admin/penggabungan-sertifikat/work-order-assignment',
      'pelepasan_hak' => 'admin/pelepasan-hak/work-order-assignment',
      'akta_permohonan_hak' => 'admin/akta-permohonan-hak/work-order-assignment',
      'sertifikat_permohonan_hak' => 'admin/sertifikat-permohonan-hak/work-order-assignment',
      'pendirian_perkumpulan' => 'admin/pendirian-perkumpulan/work-order-assignment',
      'pendirian_cv' => 'admin/pendirian-cv/work-order-assignment',
      'pendirian_pt_perorangan' => 'admin/pendirian-pt-perorangan/work-order-assignment',
      'pendirian_yayasan' => 'admin/pendirian-yayasan/work-order-assignment',
      'perjanjian_lainnya' => 'admin/perjanjian-lainnya/work-order-assignment',
      'warmarking' => 'admin/warmarking/work-order-assignment',
      'legalisasi' => 'admin/legalisasi/work-order-assignment',
    ];

    if (isset($slugMap[$slug])) {
      return $slugMap[$slug];
    }
    return null;
  }
}

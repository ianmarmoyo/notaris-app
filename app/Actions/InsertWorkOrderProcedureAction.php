<?php

namespace App\Actions;

use App\Helpers\WorkOrderProcedureHelper;
use App\Models\AktaPermohonanHak;
use App\Models\BalikAPHB;
use App\Models\BalikNamaHibah;
use App\Models\BalikNamaJualBeli;
use App\Models\BalikNamaSertifikat;
use App\Models\BalikNamaWaris;
use App\Models\Legalisasi;
use App\Models\PelepasanHak;
use App\Models\PemecahSertifikat;
use App\Models\PendirianCV;
use App\Models\PendirianPerkumpulan;
use App\Models\PendirianPT;
use App\Models\PendirianPTperorangan;
use App\Models\PendirianYayasan;
use App\Models\PenggabunganSertifikat;
use App\Models\PeningkatanHak;
use App\Models\PenurunanHak;
use App\Models\PerjanjianLainnya;
use App\Models\SertifikatPermohonanHak;
use App\Models\Warmarking;

class InsertWorkOrderProcedureAction
{
  public function execute($wo_assignment)
  {
    $work_order_assignment_id = $wo_assignment->id;
    $slug_work_order = $wo_assignment->work_order_detail->master_work_order->slug;
    $procedures = WorkOrderProcedureHelper::slugWorkOrder($slug_work_order);

    switch ($slug_work_order) {
      case 'balik_nama_waris':
        $insert_procedure = self::insertBalikNamaWaris($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'pendirian_pt':
        $insert_procedure = self::insertPendirianPT($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'balik_nama_jual_beli':
        $insert_procedure = self::insertBalikNamaJualBeli($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'balik_nama_hibah':
        $insert_procedure = self::insertBalikNamaHibah($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'pemecah_sertifikat':
        $insert_procedure = self::insertPemecahSertifikat($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'balik_nama_sertifikat':
        $insert_procedure = self::insertBalikNamaSertifikat($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'balik_aphb':
        $insert_procedure = self::insertBalikAPHB($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'peningkatan_hak':
        $insert_procedure = self::insertPeningkatanHak($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'penurunan_hak':
        $insert_procedure = self::penurunanHak($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'penggabungan_sertifikat':
        $insert_procedure = self::insertPenggabunganSertifikat($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'pelepasan_hak':
        $insert_procedure = self::insertPelepasanHak($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'akta_permohonan_hak':
        $insert_procedure = self::insertAktaPermohonanHak($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'sertifikat_permohonan_hak':
        $insert_procedure = self::insertSertifikatPermohonanHak($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'pendirian_pt_perorangan':
        $insert_procedure = self::insertPendirianPTperorangan($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'pendirian_cv':
        $insert_procedure = self::insertPendirianCV($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'pendirian_perkumpulan':
        $insert_procedure = self::insertPendirianPerkumpulan($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'pendirian_yayasan':
        $insert_procedure = self::insertPendirianYayasan($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'perjanjian_lainnya':
        $insert_procedure = self::insertPerjanjianLainnya($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'warmarking':
        $insert_procedure = self::insertWarmarking($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      case 'legalisasi':
        $insert_procedure = self::insertLegalisasi($work_order_assignment_id, $procedures);
        return $insert_procedure;
        break;
      default:
        return false;
        break;
    }
  }

  public static function insertBalikNamaWaris($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = BalikNamaWaris::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertBalikNamaJualBeli($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = BalikNamaJualBeli::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertPendirianPT($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = PendirianPT::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertBalikNamaHibah($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = BalikNamaHibah::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertPemecahSertifikat($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = PemecahSertifikat::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertBalikAPHB($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = BalikAPHB::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertBalikNamaSertifikat($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = BalikNamaSertifikat::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertPeningkatanHak($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = PeningkatanHak::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function penurunanHak($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = PenurunanHak::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertPenggabunganSertifikat($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = PenggabunganSertifikat::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertPelepasanHak($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = PelepasanHak::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertAktaPermohonanHak($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = AktaPermohonanHak::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertSertifikatPermohonanHak($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = SertifikatPermohonanHak::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertPendirianPTperorangan($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = PendirianPTperorangan::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertPendirianCV($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = PendirianCV::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertPendirianPerkumpulan($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = PendirianPerkumpulan::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertPendirianYayasan($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = PendirianYayasan::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertPerjanjianLainnya($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = PerjanjianLainnya::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertWarmarking($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = Warmarking::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }

  public static function insertLegalisasi($work_order_assignment_id, $procedures)
  {
    $results = [];
    foreach ($procedures as $syarat) {
      $results[] = Legalisasi::create([
        'work_order_assignment_id' => $work_order_assignment_id,
        'proses' => $syarat
      ]);
    }

    return $results;
  }
}

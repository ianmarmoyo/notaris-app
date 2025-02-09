<?php

namespace App\Actions;

use App\Helpers\WorkOrderProcedureHelper;
use App\Models\AktaPermohonanHak;
use App\Models\BalikAPHB;
use App\Models\BalikNamaHibah;
use App\Models\BalikNamaJualBeli;
use App\Models\BalikNamaSertifikat;
use App\Models\BalikNamaWaris;
use App\Models\PelepasanHak;
use App\Models\PemecahSertifikat;
use App\Models\PendirianPT;
use App\Models\PenggabunganSertifikat;
use App\Models\PeningkatanHak;
use App\Models\PenurunanHak;
use App\Models\SertifikatPermohonanHak;

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
}

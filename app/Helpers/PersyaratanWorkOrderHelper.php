<?php

namespace App\Helpers;

class PersyaratanWorkOrderHelper
{
  public static function slugWorkOrder($slug)
  {
    switch ($slug) {
      case 'balik_nama_waris':
        return self::rulesBalikNamaWaris();
        break;
      case 'balik_nama_jual_beli':
        return self::rulesBalikNamaJualBeli();
        break;
      case 'pendirian_pt':
        return self::rulesPendirianPT();
        break;
      case 'balik_nama_hibah':
        return self::conditionBalikNamaHibah();
        break;
      case 'balik_aphb':
        // return self::procedureBalikAPHB();
        break;
      case 'pemecah_sertifikat':
        // return self::procedurePemecahSertifikat();
        break;
      case 'balik_nama_sertifikat':
        return self::rulesBalikNamaSertifikat();
        break;
      default:
        # code...
        break;
    }
  }

  public static function rulesBalikNamaWaris()
  {
    $rules = [
      'syarat' => [
        'setifikat asli',
        'SPPT Tahun Berjalan & Lunas Tunggakan PBB',
        'Share Location',
        'Foto Lokasi',
        'Surat Keterangan Ahli Waris',
        'Surat Keterangan Kematian',
        'FC & Asli KTP KK Ahli Waris',
      ]
    ];
    return $rules;
  }

  public static function rulesBalikNamaJualBeli()
  {
    $rules = [
      'syarat' => [
        'setifikat asli',
        'SPPT Tahun Berjalan & Lunas Tunggakan PBB',
        'Share Location',
        'Foto Lokasi',
        'FC & Asli KTP KK Pemberi/Penjual (Kawan Kawin)',
        'akta Nikah pemberi/penjualan',
        'FC & Asli KTP KK BPJS Penerima/Pembali',
        'NPWP jika pekerjaan : PNS, TNI, POLRI, GURU'
      ]
    ];
    return $rules;
  }

  public static function conditionBalikNamaHibah(){
    $rules = [
      'syarat' => [

      ]
    ];
    return $rules;
  }

  public static function procedureBalikAPHB(){
    $rules = [
      'syarat' => [

      ]
    ];
    return $rules;
  }

  public static function rulesPendirianPT()
  {
    $data = [
      'syarat' => [
        'FC. KTP dan KK (Direktur dan Komisaris)',
        'NPWP Direktur dan Komisaris',
        'Nama Perseroan',
        'Alamat Perseroan',
        'Modal Perseroan',
        'Pembagian Saham Pesero',
        'Bidang Usaha (KBLI)',
        'Jumlah Pekerja',
      ],
      'pelengkap' => [
        'Berita Acara',
        'Surat Pernyataan Domisili Perseroan',
        'Surat Pernyataan Modal',
        'Surat Kuasa (jika diperlukan)',
      ],
    ];
    return $data;
  }

  public static function rulesBalikNamaSertifikat(){
    $data = [
      'syarat' => [
        'setifikat asli',
        'SPPT Tahun Berjalan & Lunas Tunggakan PBB',
        'Share Location',
        'Foto Lokasi',
        'FC & Asli KTP KK Pemberi/Penjual (Kawan Kawin)',
        'akta Nikah pemberi/penjualan',
        'FC & Asli KTP KK BPJS Penerima/Pembali',
        'NPWP jika pekerjaan : PNS, TNI, POLRI, GURU'
      ]
    ];
    return $data;
  }
}

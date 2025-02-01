<?php

namespace App\Helpers;

class WorkOrderProcedureHelper
{
  public static function slugWorkOrder($slug)
  {
    switch ($slug) {
      case 'balik_nama_waris':
        return self::procedureBalikNamaWaris();
        break;
      case 'balik_nama_jual_beli':
        return self::procedureBalikNamaJualBeli();
        break;
      case 'balik_nama_hibah':
        return self::procedureBalikNamaHibah();
        break;
      case 'balik_aphb':
        return self::procedureBalikAPHB();
        break;
      case 'pemecah_sertifikat':
        return self::procedurePemecahSertifikat();
        break;
      case 'balik_nama_sertifikat':
        return self::procedureBalikNamaSertifikat();
        break;
      case 'pendirian_pt':
        return self::procedurePendirianPT();
      default:
        # code...
        break;
    }
  }

  public static function procedureBalikNamaWaris()
  {
    return [
      "Pembuatan Surat Keterangan Waris",
      "Pengajuan Pajak Waris Bapenda",
      "Pembayaran dan Validasi Pajak Waris",
      "Pendaftaran loket BPN",
      "H2P",
      "TTD Kakan",
      "Penyerahan ",
    ];
  }

  public static function procedureBalikNamaJualBeli()
  {
    return [
      "Draft Akta Jual Beli",
      "Pengajuan Pajak Bapenda",
      "Pembayaran dan Validasi Pajak Waris",
      "Pendaftaran loket BPN",
      "H2P",
      "TTD Kakan",
      "Penyerahan ",
    ];
  }

  public static function procedureBalikNamaHibah()
  {
    return [
      "Draft Akta Hibah",
      "Pengajuan Pajak Bapenda",
      "Pembayaran dan Validasi Pajak Waris",
      "Pendaftaran loket BPN",
      "H2P",
      "TTD Kakan",
      "Penyerahan ",
    ];
  }

  public static function procedureBalikAPHB()
  {
    return [
      "Draft Akta APHB",
      "Pengajuan Pajak Bapenda",
      "Pembayaran dan Validasi Pajak Waris",
      "Pendaftaran loket BPN",
      "H2P",
      "TTD Kakan",
      "Penyerahan ",
    ];
  }

  public static function procedurePemecahSertifikat()
  {
    return [
      "Pengukuran",
      "Pendaftaran loket BPN",
      "IP",
      "H2P",
      "TTD Kakan",
      "Penyerahan ",
    ];
  }

  public static function procedureBalikNamaSertifikat()
  {
    return [
      "Pendaftaran loket BPN",
      "BPN melakukan verifikasi dokumen",
      "Bayar biaya administrasi dan BPHTB",
      "Sertifikat baru dicetak",
    ];
  }

  public static function procedurePendirianPT()
  {
    return [
      'formulir pendirian',
      'pesan nama',
      'draft akta',
      'TTD akta',
      'pengesahan',
      'penyerahan',
    ];
  }
}

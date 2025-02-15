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
        break;
      case 'peningkatan_hak':
        return self::peningkatanHak();
        break;
      case 'penurunan_hak':
        return self::penurunanHak();
        break;
      case 'penggabungan_sertifikat':
        return self::penggabunganSerfikat();
        break;
      case 'pelepasan_hak':
        return self::pelepasanHak();
        break;
      case 'akta_permohonan_hak':
        return self::aktaPermohonanHak();
        break;
      case 'sertifikat_permohonan_hak':
        return self::sertifikatPermohonanHak();
        break;
      case 'pendirian_perkumpulan':
        return self::pendirianPTperorangan();
        break;
      case 'pendirian_cv':
        return self::pendirianCV();
        break;
      case 'pendirian_pt_perorangan':
        return self::pendirianPTperorangan();
        break;
      case 'pendirian_yayasan':
        return self::pendirianYayasan();
        break;
      case 'perjanjian_lainnya':
        return self::perjanjianLainnya();
        break;
      case 'warmarking':
        return self::warmarking();
        break;
      case 'legalisasi':
        return self::legalisasi();
        break;
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

  public static function peningkatanHak()
  {
    return [
      'Pendaftaran Loket BPN',
      'KKPR',
      'TTD Kakan',
      'Penyerahan',
    ];
  }

  public static function penurunanHak()
  {
    return [
      'Pendaftaran Loket BPN',
      'KKPR',
      'TTD Kakan',
      'Penyerahan',
    ];
  }

  public static function penggabunganSerfikat()
  {
    return [
      'Pengukuran',
      'Pendaftaran Loket BPN',
      'KKPR',
      'TTD Kakan',
      'Penyerahan',
    ];
  }

  public static function pelepasanHak()
  {
    return [
      'Pembuatan Akta pelepasan Hak',
      'TTD Akta pelepasan Hak',
      'Pengehasan Notaris',
      'Penyerahan',
    ];
  }

  public static function aktaPermohonanHak()
  {
    return [
      'Pengukuran',
      'Daftar PBT BPN',
      'PBT selesai',
      'Mutasi SPPT PBB',
      'Pengajuan Pajak',
      'Pembayaran dan Validasi Pajak',
    ];
  }

  public static function sertifikatPermohonanHak()
  {
    return [
      'Entri Loket',
      'IP',
      'H2P (Cek Lapang)',
      'H2P (Panitia)',
      'Pengumuman',
      'TTD Kakan',
    ];
  }

  public static function pendirianPTperorangan()
  {
    return [
      'Pesan Nama',
      'Draft Akta',
      'TTD Penghadap',
      'Pengesahan Notaris',
      'Input Data Ke AHU',
      'Penyerahan',
    ];
  }

  public static function pendirianCV()
  {
    return [
      'Pesan Nama',
      'Draft Akta',
      'TTD Penghadap',
      'Pengesahan Notaris',
      'Input Data Ke AHU',
      'Penyerahan',
    ];
  }

  public static function pendirianPerkumpulan()
  {
    return [
      'Pesan Nama',
      'Draft Akta',
      'TTD Penghadap',
      'Pengesahan Notaris',
      'Input Data Ke AHU',
      'Penyerahan',
    ];
  }

  public static function pendirianYayasan()
  {
    return [
      'Pesan Nama',
      'Draft Akta',
      'TTD Penghadap',
      'Pengesahan Notaris',
      'Input Data Ke AHU',
      'Penyerahan',
    ];
  }

  public static function perjanjianLainnya()
  {
    return [
      'Penyerahan Dokumen',
      'Draft Perjanjian',
      'TTD Penghadap',
      'Pengesahan Notaris',
      'Penyerahan',
    ];
  }

  public static function warmarking()
  {
    return [
      'Menerima Dokumen',
      'Mendaftar Buku Khusus',
      'Pengesahan Notaris',
      'Penyerahan',
    ];
  }

  public static function legalisasi()
  {
    return [
      'Menerima Dokumen',
      'TTD Penghadap',
      'Pengesahan Notaris',
      'Penyerahan',
    ];
  }
}

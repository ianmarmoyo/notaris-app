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
        return self::procedureBalikAPHB();
        break;
      case 'pemecah_sertifikat':
        return self::procedurePemecahSertifikat();
        break;
      case 'balik_nama_sertifikat':
        return self::rulesBalikNamaSertifikat();
        break;
      case 'peningkatan_hak':
        // return self::peningkatanHak();
        break;
      case 'penurunan_hak':
        // return self::penurunanHak();
        break;
      case 'penggabungan_sertifikat':
        // return self::penggabunganSerfikat();
        break;
      case 'pelepasan_hak':
        // return self::pelepasanHak();
        break;
      case 'akta_permohonan_hak':
        // return self::aktaPermohonanHak();
        break;
      case 'sertifikat_permohonan_hak':
        // return self::sertifikatPermohonanHak();
        break;
      case 'pendirian_pt_perorangan':
        return self::rulesPendirianCV();
        break;
      case 'pendirian_cv':
        return self::rulesPendirianCV();
        break;
      case 'pendirian_perkumpulan':
        return self::rulesPendirianPerkumpulan();
        break;
      case 'pendirian_yayasan':
        return self::rulesPendirianYayasan();
        break;
      case 'perjanjian_lainnya':
        return self::rulesPerjanjianLainnya();
        break;
      case 'warmarking':
        return self::rulesWarmarking();
        break;
      case 'legalisasi':
        return self::rulesLegalisasi();
        break;
      case 'pendirian_koperasi':
        return self::rulesPendirianKoperasi();
        break;
      case 'perubahan_koperasi':
        return self::rulePerubahanKoperasi();
        break;
      case 'pembubaran_koperasi':
        return self::rulesPembubaranKoperasi();
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

  public static function procedureBalikAPHB(){
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

  public static function procedurePemecahSertifikat()
  {
    $rules = [
      'syarat' => [
        'KTP & KK Penjual',
        'KTP & KK Pembeli',
        'NPWP Penjual',
        'Buku Nikah Penjual',
        'SPPT Bebas Tunggakan',
        'Foto dan Share Lokasi',
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

  public static function rulesPendirianPerkumpulan()
  {
    $data = [
      'syarat' => [
        'FC. KTP dan KK Seluruh Pengurus',
        'Nama Perkumpulan',
        'Alamat Perkumpulan',
        'Struktur Kepengurusan',
        'NPWP Pengurus'
      ],
      'pelengkap' => [
        'Berita Acara',
        'Surat Pernyataan Domisili Perkumpulan',
        'Surat Pernyataan Kekayaan Perkumpulan',
      ],
    ];
    return $data;
  }

  public static function rulesPendirianCV()
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

  public static function rulesPendirianYayasan()
  {
    $data = [
      'syarat' => [
        'FC. KTP dan KK Seluruh Pengurus',
        'Nama Perkumpulan',
        'Alamat Perkumpulan',
        'Struktur Kepengurusan',
        'NPWP Pengurus'
      ],
      'pelengkap' => [
        'Berita Acara',
        'Surat Pernyataan Domisili Perkumpulan',
        'Surat Pernyataan Kekayaan Perkumpulan',
      ],
    ];
    return $data;
  }

  public static function rulesPerjanjianLainnya()
  {
    $data = [
      'syarat' => [],
    ];
    return $data;
  }

  public static function rulesWarmarking()
  {
    $data = [
      'syarat' => [],
    ];
    return $data;
  }

  public static function rulesLegalisasi()
  {
    $data = [
      'syarat' => [],
    ];
    return $data;
  }

  public static function rulesPendirianKoperasi()
  {
    $data = [
      'syarat' => [
        'FC. KTP dan KK Seluruh Pengurus',
        'Nama Koperasi',
        'Alamat Koperasi',
        'Struktur Kepengurusan',
        'NPWP Pengurus',
        'Berita Acara',
        'Surat Pernyataan Domisili Koperasi',
        'Surat Pernyataan Kekayaan',
      ],
    ];
    return $data;
  }

  public static function rulePerubahanKoperasi()
  {
    $data = [
      'syarat' => [
        'FC. KTP dan KK Seluruh Pengurus',
        'Nama Koperasi',
        'Alamat Koperasi',
        'Struktur Kepengurusan',
        'NPWP Pengurus',
        'Berita Acara',
        'Surat Pernyataan Domisili Koperasi',
        'Surat Pernyataan Kekayaan',
      ],
    ];
    return $data;
  }

  public static function rulesPembubaranKoperasi()
  {
    $data = [
      'syarat' => [
        'FC. KTP dan KK Seluruh Pengurus',
        'Nama Koperasi',
        'Alamat Koperasi',
        'Struktur Kepengurusan',
        'NPWP Pengurus',
        'Berita Acara',
        'Surat Pernyataan Domisili Koperasi',
        'Surat Pernyataan Kekayaan',
      ],
    ];
    return $data;
  }

}

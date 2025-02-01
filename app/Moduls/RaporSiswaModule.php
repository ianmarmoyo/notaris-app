<?php

namespace App\Moduls;

use App\Models\GuruEkskulKelas;
use App\Models\KehadiranSiswa;
use App\Models\Kepribadian;
use App\Models\Mapel;
use App\Models\NilaiSiswa;
use App\Models\RiwayatKelas;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class RaporSiswaModule
{
  public static function rapor($siswa_id, $kelas_id)
  {
    $siswa = Siswa::with(
      'kelas.wali_kelas',
      'kelas.semester',
    )->find($siswa_id);

    $title = 'Rapor ' . ucfirst($siswa->nama);
    $guru_user = auth()->user()->guru;
    $wali_kelas_guruId = auth()->user()->guru ? $guru_user->id : ($siswa->kelas->wali_kelas ? $siswa->kelas->wali_kelas->id : false);
    $nilai_mapel = self::nilaiMapel($siswa_id, $kelas_id);
    $nilai_ekskul = self::nilaiEkskul($siswa_id, $kelas_id);
    $nilai_kehadiran = self::nilaiKehadiran($siswa_id, $kelas_id);
    $nilai_kepribadian = self::nilaiKepribadian($siswa_id, $kelas_id);

    return compact('nilai_mapel', 'nilai_ekskul', 'nilai_kehadiran', 'nilai_kepribadian');
  }

  public static function nilaiMapel($siswa_id, $kelas_id)
  {
    $mapels = Mapel::with('parent')
      ->select(
        'mapels.*',
        // DB::raw("(
        //   SELECT
        //     JSON_OBJECT(
        //       'guru_id', gurus.id,
        //       'nama', gurus.nama
        //   )
        //   FROM guru_mapel_kelas
        //   LEFT JOIN gurus ON gurus.id = guru_mapel_kelas.guru_id
        //   WHERE mapel_id = mapels.id
        //   AND
        //   guru_mapel_kelas.kelas_id = $kelas_id
        // ) AS detail_guru_mapel"),
        DB::raw("(
          SELECT
          JSON_OBJECT(
            'nilai_siswa_id', nilai_siswas.id,
            'nilai_harian', nilai_siswas.nilai_harian,
            'nilai_mid', nilai_siswas.nilai_mid,
            'nilai_semester', nilai_siswas.nilai_semester,
            'total_nilai', (20 / 100) * nilai_siswas.nilai_harian + (20 / 100) * nilai_siswas.nilai_mid + (60 / 100) * nilai_siswas.nilai_semester,
            'nama_guru', gurus.nama
          ) FROM nilai_siswas
          LEFT JOIN gurus ON gurus.id = guru_id
          WHERE nilai_siswas.siswa_id = $siswa_id
          AND nilai_siswas.mapel_id = mapels.id
          AND nilai_siswas.kelas_id = $kelas_id
        ) as detail_nilai")
      )
      ->whereHas('kelases', function ($q) use ($kelas_id) {
        $q->where('kelas_id', $kelas_id);
      })
      ->get()
      ->groupBy('parent.nama');

    return $mapels;
  }

  public static function nilaiEkskul($siswa_id, $kelas_id)
  {
    $kelas_ekskul = DB::table('kelas_ekskul')
      ->select(
        'kelas_ekskul.*',
        'ekstrakulikulers.nama AS nama_ekskul',
        DB::raw("(
          SELECT
          nilai
          from nilai_ekskul_siswas
          WHERE nilai_ekskul_siswas.ekskul_id = kelas_ekskul.ekskul_id
          AND nilai_ekskul_siswas.siswa_id = $siswa_id
          AND nilai_ekskul_siswas.kelas_id = $kelas_id
          limit 1
        ) AS nilai_ekskul")
      )
      ->leftJoin('ekstrakulikulers', 'ekstrakulikulers.id', '=', 'kelas_ekskul.ekskul_id')
      ->leftJoin('kelas', 'kelas.id', '=', 'kelas_ekskul.kelas_id')
      ->where('kelas_id', $kelas_id)
      ->get();

    return $kelas_ekskul;
  }

  public static function nilaiKepribadian($siswa_id, $kelas_id)
  {
    $kepribadian = Kepribadian::select(
      'kepribadians.*',
      DB::raw("(
        SELECT
        nilai_kepribadian_siswas.nilai
        FROM nilai_kepribadian_siswas
        WHERE nilai_kepribadian_siswas.kepribadian_id = kepribadians.id
        AND nilai_kepribadian_siswas.kelas_id = $kelas_id
        AND nilai_kepribadian_siswas.siswa_id = $siswa_id
      ) AS detail_nilai"),
      // DB::raw("(
      //   SELECT
      //   gurus.id
      //   FROM kelas_kepribadian
      //   LEFT JOIN gurus ON gurus.kelas_id = kelas_kepribadian.kelas_id
      //   WHERE kelas_kepribadian.kepribadian_id = kepribadians.id
      // ) AS wali_kelas_id")
    )
      ->whereHas('kelases', function ($query) use ($kelas_id) {
        $query->where('kelas_id', $kelas_id);
      })
      ->get();

    return $kepribadian;
  }

  public static function nilaiKehadiran($siswa_id, $kelas_id)
  {
    $kehadiran_siswa_izin = KehadiranSiswa::where('siswa_id', $siswa_id)
      ->where('kelas_id', $kelas_id)
      ->where('jenis_kehadiran', 'izin')
      ->first()->kehadiran ?? 0;

    $kehadiran_siswa_sakit = KehadiranSiswa::where('siswa_id', $siswa_id)
      ->where('kelas_id', $kelas_id)
      ->where('jenis_kehadiran', 'sakit')
      ->first()->kehadiran ?? 0;

    $kehadiran_siswa_alpa = KehadiranSiswa::where('siswa_id', $siswa_id)
      ->where('kelas_id', $kelas_id)
      ->where('jenis_kehadiran', 'alpa')
      ->first()->kehadiran ?? 0;

    return [
      [
        'kehadiran' => 'izin',
        'jumlah' => $kehadiran_siswa_izin,
      ],
      [
        'kehadiran' => 'sakit',
        'jumlah' => $kehadiran_siswa_sakit,
      ],
      [
        'kehadiran' => 'alpa/Tanpa keterangan',
        'jumlah' => $kehadiran_siswa_alpa,
      ]
    ];
  }

  public static function getNilaiMapelPerSiswa($kelas_id, $mapel_id)
  {
    $allSiswa = RiwayatKelas::with(
      'siswa',
      'kelas',
    )
      ->select(
        'riwayat_kelas.*'
      )
      ->where('kelas_id', $kelas_id)
      ->get();

    $raporNilaiAllSiswa = [];
    foreach ($allSiswa as $value) {
      $nilai_siswa = NilaiSiswa::select(
        'nilai_siswas.siswa_id',
        'siswas.nama AS nama_siswa',
        'nilai_siswas.kelas_id',
        'nilai_siswas.mapel_id',
        'mapels.nama AS nama_mapel',
        DB::raw("(
          (20 / 100) * nilai_siswas.nilai_harian + (20 / 100) * nilai_siswas.nilai_mid + (60 / 100) * nilai_siswas.nilai_semester
        ) AS total_nilai")
      )
        ->leftJoin('siswas', 'nilai_siswas.siswa_id', 'siswas.id')
        ->leftJoin('mapels', 'nilai_siswas.mapel_id', 'mapels.id')
        ->where('siswa_id', $value->siswa_id)
        ->where('nilai_siswas.kelas_id', $kelas_id)
        ->where('mapel_id', $mapel_id)
        ->first();

      $raporNilaiAllSiswa[] = $nilai_siswa->total_nilai ?? 0;
    }

    return $raporNilaiAllSiswa;
  }
}

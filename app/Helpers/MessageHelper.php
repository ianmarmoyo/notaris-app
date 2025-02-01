<?php

namespace App\Helpers;

class MessageHelper
{

  public static function member_isverified($name = 'Jhon Doe')
  {
    return __("
    Halo $name,

    Kami senang memberitahu bahwa akun Anda telah berhasil diverifikasi! Selamat bergabung sebagai member resmi kami. Nikmati kemudahan layanan penerbit dan jangan ragu untuk menghubungi kami jika ada yang perlu Anda tanyakan.

    Salam hangat,
    [Penerbit Azzia]
    ");
  }

  public static function otp($code = null)
  {
    return __("
      $code adalah kode verifikasi Anda.

      Salam hangat,
      [Penerbit Azzia]

      *Note* Jika anda tidak meminta untuk mereset kata sandi, mohon abaikan pesan ini.
    ");
  }

  public static function paymentConfirm($name = null, $invoice = null)
  {
    return __("
    Halo $name, pembayaran pesanan Anda #$invoice sudah terkonfirmasi. Silakan melanjutkan proses untuk menguploud naskah dan hasil plagisi / turnitin Anda di member area sebelum batas waktu yang sudah ditentukan.\n\n\nTerima Kasih,\n[Penerbit Azzia]
    ");
  }
}

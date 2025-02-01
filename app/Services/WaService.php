<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 *  WhatsApp Service
 */

class WaService
{

  /**
   *  Storing file and merge if there is already stored file with same name
   * 
   *  @param string $phone
   *  @param string $message || null;
   * 
   *  @return \Illuminate\Http\JsonResponse;
   */

  public function handle($phone, $message = null): void
  {
    $two_digist = substr($phone, 0, 2);
    if ($two_digist == '01') {
      $phone_wa = generatePhoneMy($phone); // Nomor Malay
    } elseif ($two_digist == '08') {
      $phone_wa = generatePhoneIndo($phone); // Nomor Indo
    } else {
      $phone_wa = $phone;
    }

    try {
      $client = new Client();
      $token = env('WA_SECRET');
      $data = [
        'phone' => $phone_wa,
        'message' => $message,
      ];

      $response = $client->post(env('HOST_WABLASH') . '/send-message', [
        'headers' => [
          'Authorization' => $token,
        ],
        'form_params' => $data,
        'verify' => false, // Untuk menonaktifkan verifikasi SSL
      ]);

      $result = $response->getBody()->getContents();
      Log::channel('wa_service')->info($result);
    } catch (RequestException  $e) {
      Log::channel('wa_service')->error($e->getMessage());

      if ($e->hasResponse()) {
        // Dapatkan respons jika ada
        $errorResponse = $e->getResponse()->getBody()->getContents();
        Log::channel('wa_service')->error('Respons kesalahan: ' . $errorResponse);
      }
    }
  }
}

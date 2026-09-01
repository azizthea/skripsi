<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppGatewayService
{
    private $apiToken;

    public function __construct()
    {
        // Token Fonnte Asli Anda
        $this->apiToken = 'Eb7QCv1ycJSNTKmexzb7'; 
    }

    public function sendMessage($phone, $message)
    {
        // Mengirim HTTP POST ke server Fonnte
        $response = Http::withHeaders([
            'Authorization' => $this->apiToken,
        ])->post('https://api.fonnte.com/send', [
            'target' => $phone,
            'message' => $message,
            'countryCode' => '62',
        ]);

        return $response->json();
    }
}

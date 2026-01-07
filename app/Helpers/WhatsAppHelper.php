<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WhatsAppHelper
{
    public static function send($phone, $message)
    {
        $response = Http::withOptions([
            'verify' => false // sementara
        ])->withHeaders([
            'Authorization' => env('WA_TOKEN')
        ])->post(env('WA_URL'), [
            'target'  => $phone,
            'message' => $message,
        ]);

        return $response; // JANGAN DIHAPUS
    }
}

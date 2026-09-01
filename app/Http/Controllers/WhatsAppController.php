<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WhatsAppGatewayService;

class WhatsAppController extends Controller
{
    protected $waService;

    public function __construct(WhatsAppGatewayService $waService)
    {
        $this->waService = $waService;
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'target' => 'required',
            'message' => 'required',
        ]);

        // Meneruskan pesan ke Fonnte
        $response = $this->waService->sendMessage(
            $request->target, 
            $request->message
        );

        if (isset($response['status']) && $response['status'] == true) {
            return response()->json(['status' => 'success', 'detail' => $response]);
        }

        return response()->json(['status' => 'error', 'detail' => $response], 500);
    }
}

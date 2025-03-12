<?php

namespace App\Http\Controllers;

use App\Services\XaiApiService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $xaiService;

    public function __construct(XaiApiService $xaiService)
    {
        $this->xaiService = $xaiService;
    }

    public function sendToXai(Request $request)
    {
        try {
            $message = $request->input('message');
            if (empty($message)) {
                return response()->json(['error' => 'No message provided'], 400);
            }

            $response = $this->xaiService->sendMessage($message);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
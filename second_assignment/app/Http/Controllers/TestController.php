<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function logTest()
    {
        Log::info('Log test route accessed');
        return response()->json(['message' => 'Log test route accessed'], 200);
    }
}
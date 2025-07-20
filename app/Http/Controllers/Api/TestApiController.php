<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestApiController extends Controller
{
    public function testPost(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'API route is working!',
            'data' => $request->all()
        ]);
    }
} 
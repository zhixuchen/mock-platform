<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\MockProjectMethod;
use Illuminate\Http\Request;

class MethodController extends Controller
{
    public function methodRes(Request $request)
    {
        $uri = '/' . trim($request->uri, '/');
        $methodRes = MockProjectMethod::where('uri', $uri)->first();
        return $methodRes->result ?? '';
    }
}

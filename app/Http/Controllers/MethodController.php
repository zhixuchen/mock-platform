<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\MockProjectMethod;
use Illuminate\Http\Request;

class MethodController extends Controller
{
    public function methodRes(Request $request)
    {
        $method = '/api/otherOnLineTask/addEighteenthTask';
        $methodRes = MockProjectMethod::where('uri', $method)->first();
        return $methodRes->result ?? '';
    }
}

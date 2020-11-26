<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request)
    {
    	return response()->json(['data'=>'test']);
    }

    public function save(Request $request)
    {
    	$data = ['name' => 'Sherozd'];

    	return response()->json($data);
    }
}

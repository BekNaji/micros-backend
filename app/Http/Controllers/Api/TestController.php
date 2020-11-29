<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

	// Find a randomDate between $start_date and $end_date
	function randomDate()
	{
		// Convert to timetamps
		$min = strtotime('01-01-2020');
		$max = strtotime('29-11-2020');

		// Generate random number using above bounds
		$val = rand($min, $max);

		// Convert back to desired date format
		return date('Y-m-d H:i:s', $val);
	}
}

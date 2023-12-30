<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Helpers\EncodeData;
use App\Helpers\MicroTime;
use Illuminate\Support\Facades\DB;

class KontakController extends Controller
{
    protected $header;
    protected $key;

    public function __construct(){

        $this->header = request()->header('Authorization');
        $this->key    = env('GSS_KEY');

    }
	
	public function getKontak(){

        try {
			
			$cmd = "2300";
	
			$dataarr	= array(
				"OtKey" => request()->OtKey,
			);
	
			$data_request = array(
				"key" => $this->key,
				"act" => $cmd,
				"data" => $dataarr,
			);
	
			return EncodeData::responseData($data_request);

		} catch (\Exception $e) {
			return response()->json([
				// 'message' => 'Something when wrong!',
				'message' => $e->getMessage()
			]);
		}
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\EncodeData;

class RekeningController extends Controller
{
    protected $header;
    protected $key;

    public function __construct(){

        $this->header = request()->header('Authorization');
        $this->key    = env('GSS_KEY');

    }

    public function getListTransferKirim(Request $request){


        try {
			
			$cmd = "1235";

			$AccKey = $this->header;
	
			$dataarr	= array(
				"AccKey" => $AccKey,
			);
	
			$data_request = array(
				"key" => $this->key,
				"act" => $cmd,
                "data" => $dataarr,
			);
	
			return EncodeData::responseData($data_request);

		} catch (\Exception $e) {
			return response()->json([
				'message' => $e->getMessage()
			]);
		}

    }
}

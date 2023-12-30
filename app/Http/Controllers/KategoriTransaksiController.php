<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\EncodeData;

class KategoriTransaksiController extends Controller
{
    protected $header;
    protected $key;

    public function __construct(){

        $this->header = request()->header('Authorization');
        $this->key    = env('GSS_KEY');

    }

    public function listKategoriTransaksi(Request $request){

        try {
			
			$cmd = "7012";
	
			$dataarr	= array(
				"AccKey" => $this->header,
                "query" => $request->queries
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

    public function jenisKategoriTransaksi(Request $request){

        try {
			
			$cmd = "7011";
	
			$dataarr	= array(
				"AccKey" => $this->header,
                "query" => $request->queries
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

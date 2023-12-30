<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Helpers\EncodeData;
use App\Helpers\MicroTime;
use Illuminate\Support\Facades\DB;

class PembayaranAnggotaController extends Controller
{
	protected $header;
    protected $key;

    public function __construct(){

        $this->header = request()->header('Authorization');
        $this->key    = env('GSS_KEY');

    }
	
    public function getDataInfoTagihan(Request $request){

        try {
			
			$cmd = "M2101";
	
			$dataarr	= array(
				"AccKey" => $this->header,
				
				"Rw"	=> $request->Rw,
                // "Rw2"	=> $request->Rw2,#row limit 30 mx

				// "jns"	=> $request->jns,
                // "kat"	=> $request->kat,
                "Pg"	=> $request->Pg,
                "query"	=> $request->queries, 
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
	
	public function getDataInfoTagihanKartu(Request $request){

        try {
			
			$cmd = "M2105";
	
			$dataarr	= array(
				"AccKey" => $this->header,
				"AccNoPinjam" => $request->AccNoPinjam,
				
				"Rw"	=> $request->Rw,
                // "Rw2"	=> $request->Rw2,#row limit 30 mx

				// "jns"	=> $request->jns,
                // "kat"	=> $request->kat,
                "Pg"	=> $request->Pg,
                // "query"	=> $request->queries, 
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
	
	public function getDataInfoTagihanRiwayat(Request $request){

        try {
			
			$cmd = "M2106";
	
			$dataarr	= array(
				"AccKey" => $this->header,
				"AccNoPinjam" => $request->AccNoPinjam,
				
				"Rw"	=> $request->Rw,
                // "Rw2"	=> $request->Rw2,#row limit 30 mx

				// "jns"	=> $request->jns,
                // "kat"	=> $request->kat,
                "Pg"	=> $request->Pg,
                // "query"	=> $request->queries,
                "ord"	=> $request->ord,

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

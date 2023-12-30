<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Helpers\EncodeData;
use Illuminate\Support\Facades\DB;
use App\Helpers\MicroTime;

class PinController extends Controller
{
    protected $header;
    protected $key;

    public function __construct(){

        $this->header   = request()->header('Authorization');
        $this->key      = env('GSS_KEY');

    }
	
	public function updatePinReqToken(Request $request){

        try {
			
			 $validator = Validator::make($request->all(), [
                "AccPin"		=> "required",
                "AccPinNew"	=> 'required|string|min:6',
                "AccPinNewRe"	=> 'required|string|min:6',
                	
			]);
			
			// if ($validator->fails()) {
				// return response()->json([
					// 'error' => $validator->errors()
				// ],422);
			// }
			
			if($request->AccPinNew != $request->AccPinNewRe) {
				
				$error = [
					'message' => 'PIN baru dan ketik ulang PIN tidak sama'
				];
				
				return response()->json([
					'error' => $error
				]);
			}
			
			
			$cmd = "1505";
			
			$micro_time = MicroTime::get_idmicrotime(10);
	
			$dataarr	= array(
				"AccUser"	=> $request->AccUser,
				"refid"		=> $micro_time,
				"desc"		=> "GANTI PIN REQUEST TOKEN",
			);
	
			$data_request = array(
				"key" => $this->key,
				"act" => $cmd,
				"data" => $dataarr,
			);
	
			return EncodeData::responseData($data_request, $micro_time);

		} catch (\Exception $e) {
			return response()->json([
				'message' => $e->getMessage()
			]);
		}
	}
	
	public function updatePin(Request $request){

        try {
			
			 $validator = Validator::make($request->all(), [
                "AccPin"		=> "required",
                "AccPinNew"	=> 'required|string|min:6',
                "Validid"	=> 'required',
				"Refid"	=> 'required|string',
				"AccNo"	=> 'required'
				
                	
			]);
			
			// if ($validator->fails()) {
				// return response()->json([
					// 'error' => $validator->errors()
				// ],422);
			// }
			
			
			
			$cmd = "2121";
			
			$micro_time = MicroTime::get_idmicrotime(10);
	
			$dataarr	= array(
				"AccKey"	=> $this->header,
				"AccPin"	=> $request->AccPin,
				"AccPinNew"	=> $request->AccPinNew,
				"AccNo"	    => $request->AccNo,
				"refid"		=> $request->Refid,
				"validid"	=> $request->Validid,
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

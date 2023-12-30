<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Helpers\EncodeData;
use Illuminate\Support\Facades\DB;
use App\Helpers\MicroTime;

class ProfilController extends Controller
{
    protected $header;
    protected $key;

    public function __construct(){

        $this->header   = request()->header('Authorization');
        $this->key      = env('GSS_KEY');

    }
	
	public function updatePasswordReqToken(Request $request){

        try {
			
			 $validator = Validator::make($request->all(), [
                "AccPass"		=> "required",
                "AccPassNew"	=> 'required|string|min:6',
                "AccPassNewRe"	=> 'required|string|min:6',
                	
			]);
			
			// if ($validator->fails()) {
				// return response()->json([
					// 'error' => $validator->errors()
				// ],422);
			// }
			
			if($request->AccPassNew != $request->AccPassNewRe) {
				
				$error = [
					'message' => 'Password baru dan ketik ulang Password tidak sama'
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
				"desc"		=> "GANTI PASSWORD REQUEST TOKEN",
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
	public function updatePasssword(Request $request){

        try {
			
			 $validator = Validator::make($request->all(), [
                "AccPass"		=> "required",
                "AccPassNew"	=> 'required|string|min:6',
                "Validid"	=> 'required',
                "Refid"	=> 'required|string',
                	
			]);
			
			// if ($validator->fails()) {
				// return response()->json([
					// 'error' => $validator->errors()
				// ],422);
			// }
			
			
			
			$cmd = "1839";
			
			$micro_time = MicroTime::get_idmicrotime(10);
	
			$dataarr	= array(
				"AccKey"	=> $this->header,
				"AccPass"	=> $request->AccPass,
				"AccPassNew"	=> $request->AccPassNew,
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

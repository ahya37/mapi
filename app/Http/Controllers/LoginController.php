<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\EncodeData;
use Validator;

class LoginController extends Controller
{
    protected $key;

    public function __construct(){

        $this->key    = env('GSS_KEY');

    }

    public function store(Request $request){

		try {
			
			$validator = Validator::make($request->all(), [
				'AccUser'      => 'required',
				'AccPass'     => 'required',
				
			]);
			
			
			
			$cmd = "1000";
	
			$dataarr	= array(
				"AccUser"	=> $request->AccUser,
				"AccPass"	=> $request->AccPass,
				"OtKey"		=> $request->OtKey
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
			],500);
		}

    }

}

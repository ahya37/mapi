<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\EncodeData;
use App\Helpers\MicroTime;
use App\Helpers\StrRandom;
use Validator;
use Illuminate\Support\Facades\DB;

class QrController extends Controller
{
    protected $header;
    protected $key;

    public function __construct(){

        $this->header = request()->header('Authorization');
        $this->key    = env('GSS_KEY');

    }

    public function checkBiayaPublicQr(Request $request)
    {
        try {


            $validator = Validator::make($request->all(), [
				'AccNo'      => 'required',				
			]);
			
			$cmd = "Q201";
            
	
			$dataarr	= array(
				"AccKey" => $this->header,
                "AccNo"  => $request->AccNo
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

    public function createPublicQr(Request $request)
    {
        try {


            $validator = Validator::make($request->all(), [
				'AccNo'      => 'required',				
				'AccPin'      => 'required',				
			]);
			
			$cmd = "Q202";
	
			$dataarr	= array(
				"AccKey" => $this->header,
                "AccNo"  => $request->AccNo,
                "AccPin"  => $request->AccPin
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

    public function viewPublicQr(Request $request)
    {
        try {


            $validator = Validator::make($request->all(), [
				'AccNo'      => 'required',				
				'AccPin'      => 'required',				
			]);
			
			$cmd = "Q203";
	
			$dataarr	= array(
				"AccKey" => $this->header,
                "AccNo"  => $request->AccNo,
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

	public function createQrTransaksi(Request $request)
    {
        try {


            $validator = Validator::make($request->all(), [
				'AccNo'      => 'required',				
				'AccPin'      => 'required',				
				'TrsfTrxData' => 'required',				
			]);
			
			$cmd = "Q204";

			// generate refid
			$refId     = MicroTime::get_idmicrotime(20);
	
			$dataarr	= array(
				"AccKey" => $this->header,
                "AccNo"  => $request->AccNo,
                "AccPin"  => $request->AccPin,
                "TrsfTrxData"  => $request->TrsfTrxData, // status tambahkan nominal.  data ok / nok,
                "refid"  => $refId, //  nomor ref aplikasi, generate by api listener
                "TrsfAmount"  => $request->TrsfAmount, // nilai transfer optional sesuai TrsfTrxData,
                "TrsfRefNo"  => $request->TrsfRefNo,// nomor ref transfer diisi user optional,
                "TrsfDesc"  => $request->TrsfDesc, // nomor ref transfer diisi user optional,
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

	public function qrScan(Request $request)
    {
        try {


            $validator = Validator::make($request->all(), [
				'AccQRCode'      => 'required'		
			]);
			
			$cmd = "Q205";
	
			$dataarr	= array(
				"AccKey" => $this->header,
                "AccQRCode"  => $request->AccQRCode,
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


	public function testGenerateRefid()
	{
		// generate refid
		$refId     = StrRandom::generate(30);
		return $refId;
	}

	public function checkQrStatus(Request $request)
    {
        try {


            $validator = Validator::make($request->all(), [
				'AccQRCode'      => 'required',				
			]);
			
			$cmd = "Q206";
            
	
			$dataarr	= array(
				"AccKey" => $this->header,
                "AccQRCode"  => $request->AccQRCode // Qr code
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

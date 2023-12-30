<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Helpers\EncodeData;
use App\Helpers\MicroTime;
use Illuminate\Support\Facades\DB;

class TransferAnggotaController extends Controller
{
    protected $header;
    protected $key;

    public function __construct(){

        $this->header = request()->header('Authorization');
        $this->key    = env('GSS_KEY');

    }

    public function getDataListTransfer(Request $request){

        try {
			
			$cmd = "1444";
	
			$dataarr	= array(
				"AccKey" => $this->header,

				"query"	=> $request->queries,

                "Pg"	=> $request->Pg,
		
                "Rw"	=> $request->Rw,
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

    public function pengecekanRekeningTujuan(Request $request){

        try {

            $validator = Validator::make($request->all(), [
				'AccNo'      => 'required',				
			]);
			
			// if ($validator->fails()) {
				// return response()->json([
					// 'error' =>$validator->errors()
				// ],422);
			// }
			
			$cmd = "1205";
	
			$dataarr	= array(
				"AccKey" => $this->header,
                "AccNo" => $request->AccNo
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

    public function saveAddRekeningTujuan(Request $request){

        // DB::beginTransaction();
        try {

            $validator = Validator::make($request->all(), [
				'AccNo'      => 'required',
                'AccPass'	 => 'required'		
			]);
			
			// if ($validator->fails()) {
				// return response()->json([
					// 'error' => $validator->errors()
				// ],422);
			// }
			
			$cmd = "1812";
	
			$dataarr	= array(
				"AccKey" => $this->header,
                "AccNo" => $request->AccNo,
                "AccPass" => $request->AccPass
			);
	
			$data_request = array(
				"key" => $this->key,
				"act" => $cmd,
				"data" => $dataarr,
			);
	
            // DB::commit();
			return EncodeData::responseData($data_request);

		} catch (\Exception $e) {
            // DB::rollBack();
			return response()->json([
				'message' => $e->getMessage()
			]);
		}

    }

    public function deleteListRekening(Request $request){

        // DB::beginTransaction();
        try {

            $validator = Validator::make($request->all(), [
				'AccNo'      => 'required',
                'AccPass'	 => 'required'		
			]);
			
			// if ($validator->fails()) {
				// return response()->json([
					// 'error' => $validator->errors()
				// ],422);
			// }
			
			$cmd = "1545";
	
			$dataarr	= array(
				"AccKey" => $this->header,
                "AccNo" => $request->AccNo,
                "AccPass" => $request->AccPass
			);
	
			$data_request = array(
				"key" => $this->key,
				"act" => $cmd,
				"data" => $dataarr,
			);
	
            // DB::commit();
			return EncodeData::responseData($data_request);

		} catch (\Exception $e) {
            // DB::rollBack();
			return response()->json([
				'message' => $e->getMessage()
			]);
		}

    }

    public function saveTransferAnggota(Request $request){
        
        try {

            $validator = Validator::make($request->all(), [
                "AccNo"		=> "required",
                "AccPin"	=> "required",
                "AccNoTrsf"	=> "required",
                "TrsfAmount"	=> "required",
                "TrsfDesc"		=> "nullable",	
                "refid"		    => "nullable",	
			]);
			
			// if ($validator->fails()) {
				// return response()->json([
					// 'error' => $validator->errors()
				// ],422);
			// }
			
			$cmd = "1101";

            $micro_time = MicroTime::get_idmicrotime(20);
			// kalo dari fe tidak mengirim, maka pakai microtime
	
			$dataarr	= array(
				"AccKey" => $this->header,
                "AccNo" => $request->AccNo,
                "AccPin" => $request->AccPin,
                "AccNoTrsf"	=> $request->AccNoTrsf,
                "TrsfAmount"	=> $request->TrsfAmount,
                "TrsfRefNo"		=> $micro_time,
                "TrsfDesc"		=> $request->TrsfDesc,
                "refid"			=> $request->refid == null ? $micro_time : $request->refid
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
	
	public function getDataListInboxTransfer(Request $request){

        try {
			
			
			
			$cmd = "1414";
	
			// $dataarr	= array(
				// "AccKey" => $this->header,
                // "query"	=> $request->queries,
		
                // "Rw1"	=>$request->Rw1,
                // "Rw2"	=> $request->Rw2,#row limit 30 mx
                
                // "Dts"	=> $request->Dts,#date start date("Y-m-d")
                // "Dte"	=> $request->Dte,#date limit date("Y-m-d")
			// );
			
			$dataarr	= array(
				"AccKey" => $this->header,
                "query"	=> $request->queries,
		
                // "jns"	=> $request->jns,
                // "kat"	=> $request->kat,
                "Pg"	=> $request->Pg,
		
                "Rw"	=> $request->Rw,
                // "Rw2"	=> $request->Rw2,#row limit 30 mx
                
                "Dts"	=> $request->Dts,#date start date("Y-m-d")
                "Dte"	=> $request->Dte,#date limit date("Y-m-d")
                "ord"	=> $request->ord,
				
                // "query"	=> $request->queries,
			);
			
	
			$data_request = array(
				"key" => $this->key,
				"act" => $cmd,
				"data" => $dataarr,
			);
			
			// return $data_request;
	
			return EncodeData::responseData($data_request);

		} catch (\Exception $e) {
			return response()->json([
				'message' => $e->getMessage()
			]);
		}
    }

	public function cekBiayaAdminTransfer(Request $request){

        try {

            $validator = Validator::make($request->all(), [
				'AccNo'      => 'required',				
				'AccNoTrsf'  => 'required',				
				'TrsfAmount' => 'required',				
			]);
			
			$cmd = "1100";

			// generate refid
			$refid     = MicroTime::get_idmicrotime(20);
	
			$dataarr	= array(
				"AccKey" => $this->header,
                "AccNo" => $request->AccNo, // rekekning pengirim
                "AccNoTrsf" => $request->AccNoTrsf, // rekekning tujuan
                "TrsfAmount" => $request->TrsfAmount, // nilai transfer
                "refid" => $refid,
                "TrsfRefNo" => $request->TrsfRefNo, // nomor ref yang diinput user optional,
                "TrsfDesc" => $request->TrsfDesc, // keterangan yang diinput user optional,
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

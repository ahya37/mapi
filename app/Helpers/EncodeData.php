<?php 

namespace App\Helpers;

class EncodeData
{
    public static function responseData($data_request, $refid=''){

            $keyecdc	= date('Ymd').'ultr4man9080';
			$jdata 	    = self::ecDroid(json_encode($data_request), $keyecdc);
	
			$postdata = http_build_query(
				array(
					'request' => $jdata,
				)
			);
	
			$opts = array('http' =>
				array(
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => $postdata
				)
			);
	
	
			$context  = stream_context_create($opts);
	
			$url 	  = file_get_contents(env('MAPI'), false, $context);

			// $curl = curl_init();
			// curl_setopt($curl, CURLOPT_URL, $url);
			// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			// curl_setopt($curl, CURLOPT_HEADER, false);
			// $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			// $data = curl_exec($curl);
			// curl_close($curl);
	
			$jsondata = self::dcDroid($url, $keyecdc) ;
	
			$jsondata = (array)json_decode($jsondata, true);

			if(empty($jsondata)) return response()->json(['message' => 'server is maintenance!']);
			
			$statusCode = "";
			
			// if($jsondata['rescode'] == 85){
				
			// 	$statusCode = 422;
				
			// }elseif($jsondata['rescode'] == 1){

			// 	$statusCode = 200;

			// }elseif($jsondata['rescode'] == 91){

			// 	$statusCode = 200;

			// }elseif($jsondata['rescode'] == 93){

			// 	$statusCode = 200;

			// }elseif($jsondata['rescode'] == 95){

			// 	$statusCode = 200;

			// }elseif($jsondata['rescode'] == 99){

			// 	$statusCode = 500;

			// }elseif($jsondata['rescode'] == 80){

			// 	$statusCode = 200;
  
			// }elseif($jsondata['rescode'] == 81){

			// 	$statusCode = 200;
  
			// }elseif($jsondata['rescode'] == 92){

			// 	$statusCode = 200;
  
			// }else{

			// 	$statusCode = 400;

			// }
			if ($jsondata['rescode'] != 1 && $jsondata['rescode'] != 85 && $jsondata['rescode'] != 99) {
				$statusCode = 200;
			}elseif ($jsondata['rescode'] == 99) {
				$statusCode = 500;
			}elseif ($jsondata['rescode'] == 85) {
				$statusCode = 422;
			}elseif ($jsondata['rescode'] == 1) {
				$statusCode = 200;
			}else {
				$statusCode = 400;
			}
			
			
			if($refid != ''){
				
				return response()->json([
					'data' => $jsondata,
					'refid' => $refid
				],$statusCode);
				
			}else{
					return response()->json([
					'data' => $jsondata,
				],$statusCode);
				
			}

            
    }

    public static function encrypt_decrypt($action, $string, $key="universcode"){

        $output = false;

			$encrypt_method = "AES-128-CTR";
			$secret_key = $key;
			$secret_iv  = 'R3k4PoS202i';

			$key = hash('sha256', $secret_key);

			$iv = substr(hash('sha256', $secret_iv), 0, 16);

			if ( $action == 'encrypt' ) {
			  $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			  $output = base64_encode($output);
			} else if( $action == 'decrypt' ) {
			  $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
			}

			return $output;

    }

    public static function ecDroid( $message, $key ) {
        return self::encrypt_decrypt( "encrypt", $message, $key);
    }

    public static function dcDroid( $message, $key ) {
        return self::encrypt_decrypt( "decrypt", $message, $key);
    }
}
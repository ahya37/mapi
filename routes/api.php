<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\TransferAnggotaController;
use App\Http\Controllers\PembayaranAnggotaController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\PinController;
use App\Http\Controllers\KategoriTransaksiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\QrController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/greeting', function () {
    return 'Hello World';
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function(){
	
	Route::post('login',[LoginController::class,'store']);
	
	Route::group(['middleware' => 'authtoken'], function(){
		
		Route::group(['prefix' => 'saldo'], function(){

			Route::post('/',[SaldoController::class,'getFavoriteSaldo']);
			Route::get('info',[SaldoController::class,'getInfoAllSaldo']);
		});

		Route::group(['prefix' => 'mutasisaldo'], function(){

			Route::get('/list',[SaldoController::class,'getInfoAllSaldo']);
			Route::post('/detail',[SaldoController::class,'getDetailInfoMutasiSaldo']);
		});

		Route::group(['prefix' => 'transferanggota'], function(){

			Route::post('/listtransfer',[TransferAnggotaController::class,'getDataListTransfer']);
			Route::post('/save',[TransferAnggotaController::class,'saveTransferAnggota']);
			Route::post('/cekrekeningtujuan',[TransferAnggotaController::class,'pengecekanRekeningTujuan']);
			Route::post('/addrekeningtujuan',[TransferAnggotaController::class,'saveAddRekeningTujuan']);
			Route::post('/deleterekeningtujuan',[TransferAnggotaController::class,'deleteListRekening']);
			Route::post('/inboxtransfer',[TransferAnggotaController::class,'getDataListInboxTransfer']);

			Route::post('/cekbiayaadmin',[TransferAnggotaController::class,'cekBiayaAdminTransfer']);

			Route::post('/refid/test',[TransferAnggotaController::class,'testRefid']);


		});
		
		Route::group(['prefix' => 'pembayarananggota'], function(){

			Route::post('/infotagihan',[PembayaranAnggotaController::class,'getDataInfoTagihan']);
			Route::post('/infotagihan/kartu',[PembayaranAnggotaController::class,'getDataInfoTagihanKartu']);
			Route::post('/infotagihan/riwayat',[PembayaranAnggotaController::class,'getDataInfoTagihanRiwayat']);
		   
		});
		
		Route::group(['prefix' => 'kontak'], function(){

			Route::post('/',[KontakController::class,'getKontak']); 
		   
		});
		
		Route::group(['prefix' => 'pin'], function(){

			Route::post('/update/requestoken',[PinController::class,'updatePinReqToken']); 
			Route::post('/update/store',[PinController::class,'updatePin']);
		   
		});

		Route::group(['prefix' => 'kategori'], function(){

			Route::post('/transaksi',[KategoriTransaksiController::class,'listKategoriTransaksi']); 
			Route::post('/transaksi/jenis',[KategoriTransaksiController::class,'jenisKategoriTransaksi']); 
			
		});
		
		Route::group(['prefix' => 'password'], function(){

			Route::post('/update/requestoken',[ProfilController::class,'updatePasswordReqToken']); 
			Route::post('/update/store',[ProfilController::class,'updatePasssword']); // rescode = 94, Data tidak ditemukan
		   
		});

		Route::group(['prefix' => 'rekening'], function(){

			Route::post('/listtransferkirim',[RekeningController::class,'getListTransferKirim']); 
		   
		});

		Route::group(['prefix' => 'qr'], function(){

			Route::post('/pengajuan/cekbiayapembuatan',[QrController::class,'checkBiayaPublicQr']); 
			Route::post('/create',[QrController::class,'createPublicQr']); 
			Route::post('/view',[QrController::class,'viewPublicQr']); 
			Route::post('/transaksi/create',[QrController::class,'createQrTransaksi']); 
			Route::post('/scan',[QrController::class,'qrScan']); 
			Route::post('/status/check',[QrController::class,'checkQrStatus']); 

			Route::post('/test/refid',[QrController::class,'testGenerateRefid']); 

		   
		});
	
	});

});

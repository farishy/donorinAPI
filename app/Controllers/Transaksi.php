<?php

namespace App\Controllers;
use App\Models\TransaksiModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use \Firebase\JWT\JWT;
use App\Controllers\Auth;

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


class Transaksi extends ResourceController
{
	protected $transaksi = 'App\Models\TransaksiModel';
    protected $format    = 'json';
	use ResponseTrait;

	public function __construct(){
		$this->protect = new Auth();
		$this->transaksi = new TransaksiModel();
	}


	// get all lokasi
	public function index()
	{
		return $this->respond($this->transaksi->findAll(), 200);
	}

	// get single lokasi
    public function show($id = null)
    {
        $data = $this->transaksi->getWhere(['idTransaksi' => $id])->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada transaksi yang ditemukan dengan id '.$id);
        }
    }

	public function showLastTransaction($id = null)
    {
		$data = $this->transaksi->orderBy('idTransaksi', 'desc')->getWhere(['idAkun' => $id], 1, 0)->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada kuesioner yang ditemukan dengan id Akun '.$id);
        }
        
    }

	public function showAllTransactionById($id = null)
    {
		$data = $this->transaksi->orderBy('idTransaksi', 'desc')->getWhere(['idAkun' => $id])->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada transaksi yang ditemukan dengan id Akun '.$id);
        }
        
    }

	 // create an agenda
	 public function create()
	 {
		$secretKey = $this->protect->privateKey();
		$token = null;
		$authHeader = $this->request->getServer('HTTP_AUTHORIZATION');
		$arr = explode(" ", $authHeader);
		$token = $arr[1];

		if($token){
			try{
				$decoded = JWT::decode($token, $secretKey, array('HS256'));
				if($decoded){
					$data = [
						'idAkun' => $this->request->getPost('idAkun'),
						'tglTransaksi' => $this->request->getPost('tglTransaksi'),
						'statusTransaksi' => $this->request->getPost('statusTransaksi'),
						'keterangan' => $this->request->getPost('keterangan'),
						'idKuesioner' => $this->request->getPost('idKuesioner'),
						
					];
			
					 $data = json_decode(file_get_contents("php://input"));
					 $this->transaksi->insert($data);
					 $response = [
						 'status'   => 201,
						 'error'    => null,
						 'messages' => [
							 'success' => 'Berhasil membuat transaksi'
						 ]
					 ];
					 return $this->respondCreated($data, 201);
				}
			}catch(\Exception $e){
				$output = [
					'status' => 401,
					'message' => 'Akses ditolak',
					'error' => $e->getMessage()
				];
				return $this->respond($output, 401);
			}
		}
	 }

	 // update agenda
	 public function update($id = null)
	 {
		 $json = $this->request->getJSON();
		 if($json){
			 $data = [
				'idAkun' => $json->idAkun,
				'tglTransaksi' => $json->tglTransaksi,
				'statusTransaksi' => $json->statusTransaksi,
				'keterangan' => $json->keterangan,
				'idKuesioner' => $json->idKuesioner,
			 ];
		 }else{
			 $input = $this->request->getRawInput();
			 $data = [
				'idAkun' => $input['idAkun'],
				'tglTransaksi' => $input['tglTransaksi'],
				'statusTransaksi' => $input['statusTransaksi'],
				'keterangan' => $input['keterangan'],
				'idKuesioner' => $input['idKuesioner'],
			 ];
		 }
		 // Insert to Database
		 $this->transaksi->update($id, $data);
		 $response = [
			 'status'   => 200,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil mengupdate transaksi'
			 ]
		 ];
		 return $this->respond($response);
	 }
  
	 // delete agenda
	 public function delete($id = null)
	 {
		 $data = $this->transaksi->find($id);
		 if($data){
			 $this->transaksi->delete($id);
			 $response = [
				 'status'   => 200,
				 'error'    => null,
				 'messages' => [
					 'success' => 'Transaksi berhasil dihapus'
				 ]
			 ];
			  
			 return $this->respondDeleted($response);
		 }else{
			 return $this->failNotFound('Transaksi dengan ID '.$id.' tidak ditemukan');
		 }
		  
	 }
  
}

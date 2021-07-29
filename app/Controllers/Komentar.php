<?php

namespace App\Controllers;
use App\Models\KomentarModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Komentar extends ResourceController
{
	protected $komentar = 'App\Models\KomentarModel';
    protected $format    = 'json';
	use ResponseTrait;

	public function __construct(){
		$this->komentar = new KomentarModel();
	}


	// get all agenda
	public function index()
	{
		return $this->respond($this->komentar->findAll(), 200);
	}

	// get single agenda
    public function show($id = null)
    {
        $data = $this->komentar->getWhere(['idKomentar' => $id])->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada komentar yang ditemukan dengan id '.$id);
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
						'idArtikel' => $this->request->getPost('idArtikel'),
						'tglKomentar' => $this->request->getPost('tglKomentar'),
						'komentar' => $this->request->getPost('komentar'),
						
					];
			
					//  $data = json_decode(file_get_contents("php://input"));
					 $this->komentar->insert($data);
					 $response = [
						 'status'   => 201,
						 'error'    => null,
						 'messages' => [
							 'success' => 'Berhasil membuat komentar'
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
				'idArtikel' => $json->idArtikel,
				'tglKomentar' => $json->tglKomentar,
				'komentar' => $json->komentar,
			 ];
		 }else{
			 $input = $this->request->getRawInput();
			 $data = [
				'idAkun' => $input['idAkun'],
				'idArtikel' => $input['idArtikel'],
				'tglKomentar' => $input['tglKomentar'],
				'komentar' => $input['komentar'],
			 ];
		 }
		 // Insert to Database
		 $this->komentar->update($id, $data);
		 $response = [
			 'status'   => 200,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil mengupdate komentar.'
			 ]
		 ];
		 return $this->respond($response);
	 }
  
	 // delete agenda
	 public function delete($id = null)
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
					$data = $this->komentar->find($id);
					if($data){
						$this->komentar->delete($id);
						$response = [
							'status'   => 200,
							'error'    => null,
							'messages' => [
								'success' => 'komentar berhasil dihapus'
							]
						];
						
						return $this->respondDeleted($response);
					}else{
						return $this->failNotFound('Komentar dengan ID '.$id.' tidak ditemukan');
					}
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
  
}

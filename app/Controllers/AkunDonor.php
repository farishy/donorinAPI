<?php

namespace App\Controllers;
use App\Models\AkundonorModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use \Firebase\JWT\JWT;
use App\Controllers\Auth;

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

class AkunDonor extends ResourceController
{
	protected $akundonor = 'App\Models\AkundonorModel';
    protected $format    = 'json';
	use ResponseTrait;

	public function __construct(){
		$this->protect = new Auth();
		$this->akundonor = new AkundonorModel();
	}


	// get all akun donor
	public function index()
	{
		return $this->respond($this->akundonor->findAll(), 200);
	}

	// get single akun donor
    public function show($id = null)
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
					$data = $this->akundonor->getWhere(['idAkun' => $id])->getResult();
					if($data){
						return $this->respond($data);
					}else{
						return $this->failNotFound('Akun tidak ditemukan dengan ID '.$id);
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

	public function showByEmail($email = null)
    {
		$data = $this->akundonor->getWhere(['email' => $email])->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada akun yang ditemukan dengan email '.$email);
        }
        
    }


	 // create an akun donor
	 public function create()
	 {
		 
		$data = [
			'namaLengkap' => $this->request->getPost('namaLengkap'),
			'tempatLahir' => $this->request->getPost('tempatLahir'),
			'tglLahir' => $this->request->getPost('tglLahir'),
			'jnsKelamin' => $this->request->getPost('jnsKelamin'),
			'alamat' => $this->request->getPost('alamat'),
			'noKTP' => $this->request->getPost('noKTP'),
			'noTelepon' => $this->request->getPost('noTelepon'),
			'email' => $this->request->getPost('email'),
			'password' => $this->request->getPost('password'),
			'idGoldar' => $this->request->getPost('idGoldar'),
			'profile' => $this->request->getPost('profile'),
			
		];

		//  $data = json_decode(file_get_contents("php://input"));
		 $this->akundonor->insert($data);
		 $response = [
			 'status'   => 201,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil membuat akun donor'
			 ]
		 ];
		 return $this->respondCreated($data, 201);
	 }

	 // update akun donor
	 public function update($id = null)
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
					$json = $this->request->getJSON();
					if($json){
						$data = [
							'namaLengkap' => $json->namaLengkap,
							'tempatLahir' => $json->tempatLahir,
							'tglLahir' => $json->tglLahir,
							'jnsKelamin' => $json->jnsKelamin,
							'alamat' => $json->alamat,
							'noKTP' => $json->noKTP,
							'noTelepon' => $json->noTelepon,
							'email' => $json->email,
							'password' => $json->password,
							'idGoldar' => $json->idGoldar,
							'profile' => $json->profile,
						];
					}else{
						$input = $this->request->getRawInput();
						$data = [
							'namaLengkap' => $input['namaLengkap'],
							'tempatLahir' => $input['tempatLahir'],
							'tglLahir' => $input['tglLahir'],
							'jnsKelamin' => $input['jnsKelamin'],
							'alamat' => $input['alamat'],
							'noKTP' => $input['noKTP'],
							'noTelepon' => $input['noTelepon'],
							'email' => $input['email'],
							'password' => $input['password'],
							'idGoldar' => $input['idGoldar'],
							'profile' => $input['profile']
						];
					}
					// Insert to Database
					$this->akundonor->update($id, $data);
					$response = [
						'status'   => 200,
						'error'    => null,
						'messages' => [
							'success' => 'Berhasil mengupdate akun donor'
						]
					];
					return $this->respond($response);
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
  
	 // delete akun donor
	 public function delete($id = null)
	 {
		 $data = $this->akundonor->find($id);
		 if($data){
			 $this->akundonor->delete($id);
			 $response = [
				 'status'   => 200,
				 'error'    => null,
				 'messages' => [
					 'success' => 'Akun donor berhasil dihapus'
				 ]
			 ];
			  
			 return $this->respondDeleted($response);
		 }else{
			 return $this->failNotFound('Data dengan ID '.$id.' tidak ditemukan');
		 }
		  
	 }
  
}

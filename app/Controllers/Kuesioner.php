<?php

namespace App\Controllers;
use App\Models\KuesionerModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use \Firebase\JWT\JWT;
use App\Controllers\Auth;

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


class Kuesioner extends ResourceController
{
	protected $kuesioner = 'App\Models\KuesionerModel';
    protected $format    = 'json';
	use ResponseTrait;

	public function __construct(){
		$this->protect = new Auth();
		$this->kuesioner = new KuesionerModel();
	}


	// get all lokasi
	public function index()
	{
		return $this->respond($this->kuesioner->orderBy('idKuesioner', 'asc')->findAll(), 200);
	}

	// get single lokasi
    public function show($id = null)
    {
        $data = $this->kuesioner->getWhere(['idKuesioner' => $id])->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada kuesioner yang ditemukan dengan id '.$id);
        }
    }


    public function showLastKuesioner($id = null)
    {
		$data = $this->kuesioner->orderBy('idKuesioner', 'desc')->getWhere(['idAkun' => $id], 1, 0)->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada kuesioner yang ditemukan dengan id Akun '.$id);
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
						'Q1' => $this->request->getPost('Q1'),
						'Q2' => $this->request->getPost('Q2'),
						'Q3' => $this->request->getPost('Q3'),
						'Q4' => $this->request->getPost('Q4'),
						'Q5' => $this->request->getPost('Q5'),
						'Q6' => $this->request->getPost('Q6'),
						'Q7' => $this->request->getPost('Q7'),
						'Q8' => $this->request->getPost('Q8'),
						'Q9' => $this->request->getPost('Q9'),
						'Q10' => $this->request->getPost('Q10'),
						'Q11' => $this->request->getPost('Q11'),
						'Q12' => $this->request->getPost('Q12'),
						'Q13' => $this->request->getPost('Q13'),
						'Q14' => $this->request->getPost('Q14'),
						'Q15' => $this->request->getPost('Q15'),
						'Q16' => $this->request->getPost('Q16'),
						'Q17' => $this->request->getPost('Q17'),
						'Q18' => $this->request->getPost('Q18'),
						'Q19' => $this->request->getPost('Q19'),
						'Q20' => $this->request->getPost('Q20'),
						'Q21' => $this->request->getPost('Q21'),
						'Q22' => $this->request->getPost('Q22'),
						'Q23' => $this->request->getPost('Q23'),
						'Q24' => $this->request->getPost('Q24'),
						'Q25' => $this->request->getPost('Q25'),
						'Q26' => $this->request->getPost('Q26'),
						'Q27' => $this->request->getPost('Q27'),
						'Q28' => $this->request->getPost('Q28'),
						'Q29' => $this->request->getPost('Q29'),
						'Q30' => $this->request->getPost('Q30'),
						'Q31' => $this->request->getPost('Q31'),
						'Q32' => $this->request->getPost('Q32'),
						'Q33' => $this->request->getPost('Q33'),
						'Q34' => $this->request->getPost('Q34'),
						'Q35' => $this->request->getPost('Q35'),
						'Q36' => $this->request->getPost('Q36'),
						'Q37' => $this->request->getPost('Q37'),
						'Q38' => $this->request->getPost('Q38'),
						'Q39' => $this->request->getPost('Q39'),
						
					];
			
					$data = json_decode(file_get_contents("php://input"));
					 $this->kuesioner->insert($data);
					 $response = [
						 'status'   => 201,
						 'error'    => null,
						 'messages' => [
							 'success' => 'Berhasil membuat kuesioner'
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
				'Q1' => $json->Q1,
				'Q2' => $json->Q2,
				'Q3' => $json->Q3,
                'Q4' => $json->Q4,
				'Q5' => $json->Q5,
				'Q6' => $json->Q6,
                'Q7' => $json->Q7,
				'Q8' => $json->Q8,
				'Q9' => $json->Q9,
                'Q10' => $json->Q10,
				'Q11' => $json->Q11,
				'Q12' => $json->Q12,
                'Q13' => $json->Q13,
				'Q14' => $json->Q14,
				'Q15' => $json->Q15,
                'Q16' => $json->Q16,
				'Q17' => $json->Q17,
				'Q18' => $json->Q18,
                'Q19' => $json->Q19,
				'Q20' => $json->Q20,
				'Q21' => $json->Q21,
                'Q22' => $json->Q22,
				'Q23' => $json->Q23,
				'Q24' => $json->Q24,
                'Q25' => $json->Q25,
				'Q26' => $json->Q26,
				'Q27' => $json->Q27,
                'Q28' => $json->Q28,
				'Q29' => $json->Q29,
				'Q30' => $json->Q30,
                'Q31' => $json->Q31,
				'Q32' => $json->Q32,
				'Q33' => $json->Q33,
                'Q34' => $json->Q34,
				'Q35' => $json->Q35,
				'Q36' => $json->Q36,
                'Q37' => $json->Q37,
				'Q38' => $json->Q38,
				'Q39' => $json->Q9,
			 ];
		 }else{
			 $input = $this->request->getRawInput();
			 $data = [
				'idAkun' => $input['idAkun'],
				'Q1' => $input['Q1'],
				'Q2' => $input['Q2'],
				'Q3' => $input['Q3'],
                'Q4' => $input['Q4'],
				'Q5' => $input['Q5'],
				'Q6' => $input['Q6'],
                'Q7' => $input['Q7'],
				'Q8' => $input['Q8'],
				'Q9' => $input['Q9'],
                'Q10' => $input['Q10'],
				'Q11' => $input['Q11'],
				'Q12' => $input['Q12'],
                'Q13' => $input['Q13'],
				'Q14' => $input['Q14'],
				'Q15' => $input['Q15'],
                'Q16' => $input['Q16'],
				'Q17' => $input['Q17'],
				'Q18' => $input['Q18'],
                'Q19' => $input['Q19'],
				'Q20' => $input['Q20'],
				'Q21' => $input['Q21'],
                'Q22' => $input['Q22'],
				'Q23' => $input['Q23'],
				'Q24' => $input['Q24'],
                'Q25' => $input['Q25'],
				'Q26' => $input['Q26'],
				'Q27' => $input['Q27'],
                'Q28' => $input['Q28'],
				'Q29' => $input['Q29'],
				'Q30' => $input['Q30'],
                'Q31' => $input['Q31'],
				'Q32' => $input['Q32'],
				'Q33' => $input['Q33'],
                'Q34' => $input['Q34'],
				'Q35' => $input['Q35'],
				'Q36' => $input['Q36'],
                'Q37' => $input['Q37'],
				'Q38' => $input['Q38'],
				'Q39' => $input['Q39'],
                

			 ];
		 }
		 // Insert to Database
		 $this->kuesioner->update($id, $data);
		 $response = [
			 'status'   => 200,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil mengupdate kuesioner'
			 ]
		 ];
		 return $this->respond($response);
	 }
  
	 // delete agenda
	 public function delete($id = null)
	 {
		 $data = $this->kuesioner->find($id);
		 if($data){
			 $this->kuesioner->delete($id);
			 $response = [
				 'status'   => 200,
				 'error'    => null,
				 'messages' => [
					 'success' => 'Kuesioner berhasil dihapus'
				 ]
			 ];
			  
			 return $this->respondDeleted($response);
		 }else{
			 return $this->failNotFound('Kuesioner dengan ID '.$id.' tidak ditemukan');
		 }
		  
	 }
  
}

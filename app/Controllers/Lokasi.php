<?php

namespace App\Controllers;
use App\Models\LokasiModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Lokasi extends ResourceController
{
	protected $lokasi = 'App\Models\LokasiModel';
    protected $format    = 'json';
	use ResponseTrait;

	public function __construct(){
		$this->lokasi = new LokasiModel();
	}


	// get all lokasi
	public function index()
	{
		return $this->respond($this->lokasi->findAll(), 200);
	}

	// get single lokasi
    public function show($id = null)
    {
        $data = $this->lokasi->getWhere(['idLokasi' => $id])->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada lokasi yang ditemukan dengan id '.$id);
        }
    }

	 // create an agenda
	 public function create()
	 {
		 
		$data = [
			'namaLokasi' => $this->request->getPost('namaLokasi'),
			'latKordinat' => $this->request->getPost('latKordinat'),
			'longKordinat' => $this->request->getPost('longKordinat'),
			
		];

		//  $data = json_decode(file_get_contents("php://input"));
		 $this->lokasi->insert($data);
		 $response = [
			 'status'   => 201,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil membuat lokasi'
			 ]
		 ];
		 return $this->respondCreated($data, 201);
	 }

	 // update agenda
	 public function update($id = null)
	 {
		 $json = $this->request->getJSON();
		 if($json){
			 $data = [
				'namaLokasi' => $json->namaLokasi,
				'latKordinat' => $json->latKordinat,
				'LongKordinat' => $json->LongKordinat,
			 ];
		 }else{
			 $input = $this->request->getRawInput();
			 $data = [
				'namaLokasi' => $input['namaLokasi'],
				'latKordinat' => $input['latKordinat'],
				'LongKordinat' => $input['LongKordinat'],
			 ];
		 }
		 // Insert to Database
		 $this->lokasi->update($id, $data);
		 $response = [
			 'status'   => 200,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil mengupdate lokasi.'
			 ]
		 ];
		 return $this->respond($response);
	 }
  
	 // delete agenda
	 public function delete($id = null)
	 {
		 $data = $this->lokasi->find($id);
		 if($data){
			 $this->lokasi->delete($id);
			 $response = [
				 'status'   => 200,
				 'error'    => null,
				 'messages' => [
					 'success' => 'Lokasi berhasil dihapus'
				 ]
			 ];
			  
			 return $this->respondDeleted($response);
		 }else{
			 return $this->failNotFound('Lokasi dengan ID '.$id.' tidak ditemukan');
		 }
		  
	 }
  
}

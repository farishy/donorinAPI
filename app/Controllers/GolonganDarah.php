<?php

namespace App\Controllers;
use App\Models\GolongandarahModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class GolonganDarah extends ResourceController
{
	protected $stokdarah = 'App\Models\GolongandarahModel';
    protected $format    = 'json';
	use ResponseTrait;

	public function __construct(){
		$this->golongandarah = new GolongandarahModel();
	}


	// get all lokasi
	public function index()
	{
		return $this->respond($this->golongandarah->findAll(), 200);
	}

	// get single lokasi
    public function show($id = null)
    {
        $data = $this->golongandarah->getWhere(['idGoldar' => $id])->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada golongan darah yang ditemukan dengan id '.$id);
        }
    }

	 // create an agenda
	 public function create()
	 {
		 
		$data = [
			'golonganDarah' => $this->request->getPost('golonganDarah'),
			'rhesusGoldar' => $this->request->getPost('rhesusGoldar'),
			
		];

		//  $data = json_decode(file_get_contents("php://input"));
		 $this->golongandarah->insert($data);
		 $response = [
			 'status'   => 201,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil membuat golongan darah'
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
				'golonganDarah' => $json->golonganDarah,
				'rhesusGoldar' => $json->rhesusGoldar,
			 ];
		 }else{
			 $input = $this->request->getRawInput();
			 $data = [
				'golonganDarah' => $input['golonganDarah'],
				'rhesusGoldar' => $input['rhesusGoldar'],
			 ];
		 }
		 // Insert to Database
		 $this->golongandarah->update($id, $data);
		 $response = [
			 'status'   => 200,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil mengupdate golongan darah'
			 ]
		 ];
		 return $this->respond($response);
	 }
  
	 // delete agenda
	 public function delete($id = null)
	 {
		 $data = $this->golongandarah->find($id);
		 if($data){
			 $this->golongandarah->delete($id);
			 $response = [
				 'status'   => 200,
				 'error'    => null,
				 'messages' => [
					 'success' => 'Golongan darah berhasil dihapus'
				 ]
			 ];
			  
			 return $this->respondDeleted($response);
		 }else{
			 return $this->failNotFound('Golongan darah dengan ID '.$id.' tidak ditemukan');
		 }
		  
	 }
  
}

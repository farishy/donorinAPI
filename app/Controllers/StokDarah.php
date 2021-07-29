<?php

namespace App\Controllers;
use App\Models\StokdarahModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class StokDarah extends ResourceController
{
	protected $stokdarah = 'App\Models\StokdarahModel';
    protected $format    = 'json';
	use ResponseTrait;

	public function __construct(){
		$this->stokdarah = new StokdarahModel();
	}


	// get all lokasi
	public function index()
	{
		return $this->respond($this->stokdarah->joinWithGoldarTable());
		
	}

	// get single lokasi
    public function show($id = null)
    {
        $data = $this->stokdarah->getWhere(['idStok' => $id])->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada stok darah yang ditemukan dengan id '.$id);
        }
    }

	 // create an agenda
	 public function create()
	 {
		 
		$data = [
			'idGoldar' => $this->request->getPost('idGoldar'),
			'stokDarah' => $this->request->getPost('stokDarah'),
			
		];

		//  $data = json_decode(file_get_contents("php://input"));
		 $this->stokdarah->insert($data);
		 $response = [
			 'status'   => 201,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil membuat stok darah'
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
				'idGoldar' => $json->idGoldar,
				'stokDarah' => $json->stokDarah,
			 ];
		 }else{
			 $input = $this->request->getRawInput();
			 $data = [
				'idGoldar' => $input['idGoldar'],
				'stokDarah' => $input['stokDarah'],
			 ];
		 }
		 // Insert to Database
		 $this->stokdarah->update($id, $data);
		 $response = [
			 'status'   => 200,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil mengupdate stok darah'
			 ]
		 ];
		 return $this->respond($response);
	 }
  
	 // delete agenda
	 public function delete($id = null)
	 {
		 $data = $this->stokdarah->find($id);
		 if($data){
			 $this->stokdarah->delete($id);
			 $response = [
				 'status'   => 200,
				 'error'    => null,
				 'messages' => [
					 'success' => 'Stok darah berhasil dihapus'
				 ]
			 ];
			  
			 return $this->respondDeleted($response);
		 }else{
			 return $this->failNotFound('Stok darah dengan ID '.$id.' tidak ditemukan');
		 }
		  
	 }
  
}

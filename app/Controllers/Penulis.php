<?php

namespace App\Controllers;
use App\Models\PenulisModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Penulis extends ResourceController
{
	protected $penulis = 'App\Models\PenulisModel';
    protected $format    = 'json';
	use ResponseTrait;

	public function __construct(){
		$this->penulis = new PenulisModel();
	}


	// get all penulis
	public function index()
	{
		return $this->respond($this->penulis->findAll(), 200);
	}

	// get single penulis
    public function show($id = null)
    {
        $data = $this->penulis->getWhere(['idPenulis' => $id])->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada penulis yang ditemukan dengan id '.$id);
        }
    }

	 // create an agenda
	 public function create()
	 {
		 
		$data = [
			'namaPenulis' => $this->request->getPost('namaPenulis'),
			'gambarPenulis' => $this->request->getPost('gambarPenulis'),
			'deskripsiPenulis' => $this->request->getPost('deskripsiPenulis'),
			'statusPenulis' => $this->request->getPost('statusPenulis'),
			
		];

		//  $data = json_decode(file_get_contents("php://input"));
		 $this->penulis->insert($data);
		 $response = [
			 'status'   => 201,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil membuat penulis.'
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
				'namaPenulis' => $json->namaPenulis,
				'gambarPenulis' => $json->gambarPenulis,
				'deskripsiPenulis' => $json->deskripsiPenulis,
				'statusPenulis' => $json->statusPenulis,
			 ];
		 }else{
			 $input = $this->request->getRawInput();
			 $data = [
				'namaPenulis' => $input['namaPenulis'],
				'gambarPenulis' => $input['gambarPenulis'],
				'deskripsiPenulis' => $input['deskripsiPenulis'],
				'statusPenulis' => $input['statusPenulis'],
			 ];
		 }
		 // Insert to Database
		 $this->penulis->update($id, $data);
		 $response = [
			 'status'   => 200,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil mengupdate penulis.'
			 ]
		 ];
		 return $this->respond($response);
	 }
  
	 // delete agenda
	 public function delete($id = null)
	 {
		 $data = $this->penulis->find($id);
		 if($data){
			 $this->penulis->delete($id);
			 $response = [
				 'status'   => 200,
				 'error'    => null,
				 'messages' => [
					 'success' => 'Penulis berhasil dihapus'
				 ]
			 ];
			  
			 return $this->respondDeleted($response);
		 }else{
			 return $this->failNotFound('Penulis dengan ID '.$id.' tidak ditemukan');
		 }
		  
	 }
  
}

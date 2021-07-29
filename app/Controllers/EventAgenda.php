<?php

namespace App\Controllers;
use App\Models\EventagendaModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class EventAgenda extends ResourceController
{
	protected $artikel = 'App\Models\EventagendaModel';
    protected $format    = 'json';
	use ResponseTrait;

	public function __construct(){
		$this->eventagenda = new EventagendaModel();
	}


	// get all agenda
	public function index()
	{
		return $this->respond($this->eventagenda->findAll(), 200);
	}

	// get single agenda
    public function show($id = null)
    {
        $data = $this->eventagenda->getWhere(['idAgenda' => $id])->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada agenda yang ditemukan dengan id '.$id);
        }
    }

	 // create an agenda
	 public function create()
	 {
		 
		$data = [
			'tglAgenda' => $this->request->getPost('tglAgenda'),
			'judulAgenda' => $this->request->getPost('judulAgenda'),
			'sinopsisAgenda' => $this->request->getPost('sinopsisAgenda'),
			'kontenAgenda' => $this->request->getPost('kontenAgenda'),
			'gambarAgenda' => $this->request->getPost('gambarAgenda'),
			'statusAgenda' => $this->request->getPost('statusAgenda'),
			'idLokasi' => $this->request->getPost('idLokasi'),
			
		];

		//  $data = json_decode(file_get_contents("php://input"));
		 $this->eventagenda->insert($data);
		 $response = [
			 'status'   => 201,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil membuat agenda'
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
				'tglAgenda' => $json->tglAgenda,
				'judulAgenda' => $json->judulAgenda,
				'sinopsisAgenda' => $json->sinopsisAgenda,
				'kontenAgenda' => $json->kontenAgenda,
				'gambarAgenda' => $json->gambarAgenda,
				'statusAgenda' => $json->statusAgenda,
				'idLokasi' => $json->idLokasi,
			 ];
		 }else{
			 $input = $this->request->getRawInput();
			 $data = [
				'tglAgenda' => $input['tglAgenda'],
				'judulAgenda' => $input['judulAgenda'],
				'sinopsisAgenda' => $input['sinopsisAgenda'],
				'kontenAgenda' => $input['kontenAgenda'],
				'gambarAgenda' => $input['gambarAgenda'],
				'statusAgenda' => $input['statusAgenda'],
				'idLokasi' => $input['idLokasi'],
			 ];
		 }
		 // Insert to Database
		 $this->eventagenda->update($id, $data);
		 $response = [
			 'status'   => 200,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil mengupdate agenda.'
			 ]
		 ];
		 return $this->respond($response);
	 }
  
	 // delete agenda
	 public function delete($id = null)
	 {
		 $data = $this->eventagenda->find($id);
		 if($data){
			 $this->eventagenda->delete($id);
			 $response = [
				 'status'   => 200,
				 'error'    => null,
				 'messages' => [
					 'success' => 'Agenda berhasil dihapus'
				 ]
			 ];
			  
			 return $this->respondDeleted($response);
		 }else{
			 return $this->failNotFound('Agenda dengan ID '.$id.' tidak ditemukan');
		 }
		  
	 }
  
}

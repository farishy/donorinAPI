<?php

namespace App\Controllers;
use App\Models\ArtikelModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Artikel extends ResourceController
{
	protected $artikel = 'App\Models\ArtikelModel';
    protected $format    = 'json';
	use ResponseTrait;

	public function __construct(){
		$this->artikel = new ArtikelModel();
	}


	// get all artikel
	public function index()
	{
		return $this->respond($this->artikel->findAll(), 200);
	}

	// get single artikel
    public function show($id = null)
    {
        $data = $this->artikel->getWhere(['idArtikel' => $id])->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada artikel yang ditemukan dengan id '.$id);
        }
    }

	 // create an artikel
	 public function create()
	 {
		 
		$data = [
			'tglRilis' => $this->request->getPost('tglRilis'),
			'tipeArtikel' => $this->request->getPost('tipeArtikel'),
			'viewCount' => $this->request->getPost('viewCount'),
			'likeCount' => $this->request->getPost('likeCount'),
			'commentCount' => $this->request->getPost('commentCount'),
			'judulArtikel' => $this->request->getPost('judulArtikel'),
			'gambarArtikel' => $this->request->getPost('gambarArtikel'),
			'sinopsisArtikel' => $this->request->getPost('sinopsisArtikel'),
			'kontenArtikel' => $this->request->getPost('kontenArtikel'),
			'idPenulis' => $this->request->getPost('idPenulis'),
			'statusArtikel' => $this->request->getPost('statusArtikel')
			
		];

		//  $data = json_decode(file_get_contents("php://input"));
		 $this->artikel->insert($data);
		 $response = [
			 'status'   => 201,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil membuat artikel'
			 ]
		 ];
		 return $this->respondCreated($data, 201);
	 }

	 // update artikel
	 public function update($id = null)
	 {
		 $json = $this->request->getJSON();
		 if($json){
			 $data = [
				'tglRilis' => $json->tglRilis,
				'tipeArtikel' => $json->tipeArtikel,
				'viewCount' => $json->viewCount,
				'likeCount' => $json->likeCount,
				'commentCount' => $json->commentCount,
				'judulArtikel' => $json->judulArtikel,
				'gambarArtikel' => $json->gambarArtikel,
				'sinopsisArtikel' => $json->sinopsisArtikel,
				'kontenArtikel' => $json->kontenArtikel,
				'idPenulis' => $json->idPenulis,
				'statusArtikel' => $json->statusArtikel
			 ];
		 }else{
			 $input = $this->request->getRawInput();
			 $data = [
				'tglRilis' => $input['tglRilis'],
				'tipeArtikel' => $input['tipeArtikel'],
				'viewCount' => $input['viewCount'],
				'likeCount' => $input['likeCount'],
				'commentCount' => $input['commentCount'],
				'judulArtikel' => $input['judulArtikel'],
				'gambarArtikel' => $input['gambarArtikel'],
				'sinopsisArtikel' => $input['sinopsisArtikel'],
				'kontenArtikel' => $input['kontenArtikel'],
				'idPenulis' => $input['idPenulis'],
				'statusArtikel' => $input['statusArtikel']
			 ];
		 }
		 // Insert to Database
		 $this->artikel->update($id, $data);
		 $response = [
			 'status'   => 200,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil mengupdate artikel'
			 ]
		 ];
		 return $this->respond($response);
	 }
  
	 // delete artikel
	 public function delete($id = null)
	 {
		 $data = $this->artikel->find($id);
		 if($data){
			 $this->artikel->delete($id);
			 $response = [
				 'status'   => 200,
				 'error'    => null,
				 'messages' => [
					 'success' => 'Artikel berhasil dihapus'
				 ]
			 ];
			  
			 return $this->respondDeleted($response);
		 }else{
			 return $this->failNotFound('Artikel dengan ID '.$id.' tidak ditemukan');
		 }
		  
	 }
  
}

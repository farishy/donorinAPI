<?php

namespace App\Controllers;
use App\Models\FaqModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Faq extends ResourceController
{
	protected $artikel = 'App\Models\FaqModel';
    protected $format    = 'json';
	use ResponseTrait;

	public function __construct(){
		$this->faq = new FaqModel();
	}


	// get all agenda
	public function index()
	{
		return $this->respond($this->faq->findAll(), 200);
	}

	// get single agenda
    public function show($id = null)
    {
        $data = $this->faq->getWhere(['idFaq' => $id])->getResult();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('Tidak ada FAQ yang ditemukan dengan id '.$id);
        }
    }

	 // create an agenda
	 public function create()
	 {
		 
		$data = [
			'icon' => $this->request->getPost('icon'),
			'judulFaq' => $this->request->getPost('judulFaq'),
			'sinopsisFaq' => $this->request->getPost('sinopsisFaq'),
			'kontenFaq' => $this->request->getPost('kontenFaq'),
			
		];

		//  $data = json_decode(file_get_contents("php://input"));
		 $this->faq->insert($data);
		 $response = [
			 'status'   => 201,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil membuat FAQ'
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
				'icon' => $json->icon,
				'judulFaq' => $json->judulFaq,
				'sinopsisFaq' => $json->sinopsisFaq,
				'kontenFaq' => $json->kontenFaq,
			 ];
		 }else{
			 $input = $this->request->getRawInput();
			 $data = [
				'icon' => $input['icon'],
				'judulFaq' => $input['judulFaq'],
				'sinopsisFaq' => $input['sinopsisFaq'],
				'kontenFaq' => $input['kontenFaq'],
			 ];
		 }
		 // Insert to Database
		 $this->faq->update($id, $data);
		 $response = [
			 'status'   => 200,
			 'error'    => null,
			 'messages' => [
				 'success' => 'Berhasil mengupdate FAQ.'
			 ]
		 ];
		 return $this->respond($response);
	 }
  
	 // delete agenda
	 public function delete($id = null)
	 {
		 $data = $this->faq->find($id);
		 if($data){
			 $this->faq->delete($id);
			 $response = [
				 'status'   => 200,
				 'error'    => null,
				 'messages' => [
					 'success' => 'FAQ berhasil dihapus'
				 ]
			 ];
			  
			 return $this->respondDeleted($response);
		 }else{
			 return $this->failNotFound('FAQ dengan ID '.$id.' tidak ditemukan');
		 }
		  
	 }
  
}

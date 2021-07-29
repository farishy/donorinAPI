<?php

namespace App\Controllers;
use App\Models\AkundonorModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use \Firebase\JWT\JWT;

class Auth extends ResourceController
{
	protected $akundonor = 'App\Models\AkundonorModel';
    protected $format    = 'json';
	use ResponseTrait;

	public function __construct(){
		$this->akundonor = new AkundonorModel();
	}

	public function privateKey()
    {
        $privateKey = <<<EOD
			-----BEGIN RSA PRIVATE KEY-----
			MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
			vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
			5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
			AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
			bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
			Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
			cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
			5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
			ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
			k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
			qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
			eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
			B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
			-----END RSA PRIVATE KEY-----
			EOD;
		return $privateKey;
    }


	//login

	public function login()
    {
		$data = json_decode(file_get_contents("php://input"), true);
		$email = $data['email'];
		$password = $data['password'];
		$data = $this->akundonor->getWhere(['email' => $email])->getRowArray();
        if (!empty($data)) {
			if ($password == $data['password']){
				$secret_key = $this->privateKey();
				$issuer_claim = "THE_CLAIM"; // this can be the servername. Example: https://domain.com
				$audience_claim = "THE_AUDIENCE";
				$issuedat_claim = time(); // issued at
				$notbefore_claim = $issuedat_claim + 10; //not before in seconds
				$expire_claim = $issuedat_claim + 3600; // expire time in seconds
				$token = array(
					"iss" => $issuer_claim,
					"aud" => $audience_claim,
					"iat" => $issuedat_claim,
					"nbf" => $notbefore_claim,
					"exp" => $expire_claim,
					"data" => array(
						"idAkun" => $data['idAkun'],
						"email" => $data['email']
					)
				);
                
				$token = JWT::encode($token, $secret_key);
				$output = [
					'status' => 200,
					'message' => 'Berhasil login',
					"token" => $token,
					"email" => $email,
					"idAkun" => $data['idAkun'],
					"expireAt" => $expire_claim
				];
				return $this->respond($output, 200);
			} else {
				$output = [
					'status' => 401,
					'message' => 'Tidak berhasil login'
				];
				return $this->respond($output, 401);
			}
		}
    }

	public function register()
	{
		$dataRegister = [
			'namaLengkap' => $this->request->getPost('namaLengkap'),
			'tempatLahir' => $this->request->getPost('tempatLahir'),
			'tglLahir' => $this->request->getPost('tglLahir'),
			'jnsKelamin' => $this->request->getPost('jnsKelamin'),
			'alamat' => $this->request->getPost('alamat'),
			'noKTP' => $this->request->getPost('noKTP'),
			'noTelepon' => $this->request->getPost('noTelepon'),
			'email' => $this->request->getPost('email'),
			'password' => $this->request->getPost('password'),
			'idGoldar' => $this->request->getPost('idGoldar')
		];

		$data = json_decode(file_get_contents("php://input"), true);
		$register = $this->akundonor->insert($data);

		if($register == true){
			$output = [
				'status' => 200,
				'message' => 'Berhasil mendaftarkan akun'
			];
    		return $this->respond($output, 200);
		} else {
			$output = [
				'status' => 400,
				'message' => 'Gagal mendaftarkan akun'
			];
    		return $this->respond($output, 400);
		}
	}

	 
  
}

<?php
namespace ParasutAPI;
use Exception;

class Connect
{
	public $BASE_URL = 'https://api.heroku-staging.parasut.com'; //https://api.heroku-staging.parasut.com //https://api.parasut.com
	public $version = 'v4';
	public $config;
	public $access_token;
	public $company_id;
	public $authorizationFileName = 'authorization.ini';
	public $file;

	//$config

	/**
	 * @throws Exception
	 */
	public function __construct($config)
	{
		//Check the configuration data
		$this->checkConfigData($config);

		$this->config = $config;
		$this->company_id = $this->config['company_id'];

		$authorizationFile = __DIR__."/".$this->authorizationFileName;

		//if not exists authorization.ini
		if (!file_exists($authorizationFile))
			file_put_contents($authorizationFile, "");

		$this->file = $authorizationFile;
		$this->checkAuthorization();
	}

	/**
	 * Check the configuration data
	 * @throws Exception
	 */
	private function checkConfigData($config)
	{
		if (!isset($config["client_id"]))
			throw new Exception("`client_id` parameter missing");

		if (!isset($config["client_secret"]))
			throw new Exception("`client_secret` parameter missing");

		if (!isset($config["grant_type"]))
			throw new Exception("`grant_type` parameter missing");

		if (!isset($config["redirect_uri"]))
			throw new Exception("`redirect_uri` parameter missing");

		if (!isset($config["company_id"]))
			throw new Exception("`company_id` parameter missing");

		if ($config["grant_type"] === "password")
		{
			if (!isset($config["username"]))
				throw new Exception("`username` parameter missing");

			if (!isset($config["password"]))
				throw new Exception("`password` parameter missing");
		}
	}

	/**
	 * @return array|false
	 * @throws Exception
	 */
	public function checkAuthorization()
	{
		$tokens = parse_ini_file($this->file);

		if (empty($tokens))
			return $this->authorize();

		if (!isset($tokens['access_token']) || !isset($tokens['created_at'])) {
			return $this->authorize();
		}
		if (time() - (int) $tokens['created_at'] > 7200) {
			return $this->authorize();
		}
		$this->access_token = $tokens['access_token'];

		return $tokens;
	}

	/**
	 * @return false
	 * @throws Exception
	 */
	public function authorize()
	{
		if ($this->config['grant_type'] == 'password') {
			$resp = $this->authWithPassword();
		}
		else
			$resp = $this->authWithPassword();

		if (isset($resp['access_token'])) {
			$token = '';
			foreach ($resp as $key => $value) {
				$token .= $key.'='.$value."\n";
			}
			file_put_contents($this->file, $token);

			$this->access_token = $resp['access_token'];
		}

		return false;
	}

	/**
	 * @param $path
	 * @param null $params
	 * @param string $method
	 * @param false $fullPath
	 * @return mixed
	 * @throws Exception
	 */
	public function request($path, $params = null, $method = 'POST', $fullPath = false)
	{
		$headers = [];
		$headers[] = 'Accept: application/json';
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: Bearer '.$this->access_token;

		$ch = curl_init();
		if (is_array($params) && $method == 'GET' && count($params) > 0) {
			$path = rtrim($path,'/');
			$path .= '?'.http_build_query($params);
		}

		if ($fullPath) {
			curl_setopt($ch, CURLOPT_URL, $path);
		} else {
			curl_setopt($ch, CURLOPT_URL, $this->BASE_URL.'/'.$this->version.'/'.$this->company_id.'/'.$path);
		}

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt($ch, CURLOPT_TIMEOUT, 90);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		switch ($method) {
			case 'PUT':
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
				break;
			case 'POST':
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
				break;
			case 'DELETE':
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;
		}
		$jsonData = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$response = json_decode($jsonData, true);
		curl_close($ch);

		switch ($httpCode) {
			case '400':
				$msg = strlen($jsonData) < 3 ? $msg = 'Bad Request' : $jsonData;
				throw new Exception($msg, 400);
				break;
			case '401':
				$msg = strlen($jsonData) < 3 ? $msg = 'Authentication Error' : $jsonData;
				throw new Exception($msg, 401);
				break;
			case '404':
				$msg = strlen($jsonData) < 3 ? $msg = 'Not Found Error' : $jsonData;
				throw new Exception($msg, 404);
				break;
			case '422':
				$msg = strlen($jsonData) < 3 ? $msg = 'Unprocessable Entity Error' : $jsonData;
				throw new Exception($msg, 422);
				break;
			case '500':
				$msg = strlen($jsonData) < 3 ? $msg = 'Internal Server Error' : $jsonData;
				throw new Exception($msg, 500);
				break;
			default:
				return $response;
				break;
		}
	}

	/**
	 * @return mixed
	 * @throws Exception
	 */
	private function authWithPassword()
	{
		$path = $this->BASE_URL.'/oauth/token';

		return $this->request(
			$path,
			$this->config,
			'POST',
			true
		);
	}

	/**
	 * @return mixed
	 * @throws Exception
	 */
	private function authWithAuthorization()
	{
		$path = $this->BASE_URL.'/oauth/token';

		return $this->request(
			$path,
			$this->config,
			'POST',
			true
		);
	}
}
<?php
namespace Parasut\API;
use Parasut\API\Exception;

class Authorization extends Request
{
	public $LIVE_URL = "https://api.parasut.com";
	public $DEMO_URL = "https://api.heroku-staging.parasut.com";
	public $version = "v4";
	public $authorization_file_name = 'authorization.ini';
	public $grant_type = "password";

	public $api_url;
	public $config;
	public $access_token;
	public $company_id;
	public $ini_file;

	/**
	 * Authorization constructor.
	 * @param $config
	 * @throws \Parasut\API\Exception
	 */
	public function __construct($config)
	{
		//check the configuration data
		$this->checkConfigData($config);

		$authorizationFile = __DIR__."/".$this->authorization_file_name;

		//if not exists authorization.ini
		if (!file_exists($authorizationFile))
			file_put_contents($authorizationFile, "");

		//configuration variables
		$this->config = $config;
		$this->api_url = (isset($config["development"]) && $config["development"]) ? $this->DEMO_URL : $this->LIVE_URL; //demo or live
		$this->company_id = $this->config["company_id"];
		$this->config["grant_type"] = $this->grant_type;
		$this->ini_file = $authorizationFile;

		//check authorize
		$this->checkAuthorization();
	}

	/**
	 * Check the configuration data
	 * @throws Exception
	 */
	private function checkConfigData($config)
	{
		if (!isset($config["client_id"]))
			throw new \Parasut\API\Exception("`client_id` parameter missing", 400);

		if (!isset($config["redirect_uri"]))
			throw new \Parasut\API\Exception("`redirect_uri` parameter missing", 400);

		if (!isset($config["company_id"]))
			throw new \Parasut\API\Exception("`company_id` parameter missing", 400);

		if (!isset($config["username"]))
			throw new \Parasut\API\Exception("`username` parameter missing",400);

		if (!isset($config["password"]))
			throw new \Parasut\API\Exception("`password` parameter missing", 400);
	}

	/**
	 * Check Authorization
	 * @return void
	 * @throws \Parasut\API\Exception
	 */
	private function checkAuthorization()
	{
		$tokens = parse_ini_file($this->ini_file);

		if (empty($tokens)) {
			$this->accessAuthorization();
			return;
		}

		if (isset($tokens['company_id']) && md5($tokens['company_id']) !== md5($this->company_id))
		{
			$this->accessAuthorization();
			return;
		}

		if (!isset($tokens['access_token'])) {
			$this->accessAuthorization();
			return;
		}

		if (!isset($tokens['created_at']) || time() - intval($tokens['created_at']) > 7200) {
			$this->accessAuthorization();
			return;
		}

		$this->access_token = $tokens['access_token'];
	}

	/**
	 * Access Authorization
	 * @throws \Parasut\API\Exception
	 */
	private function accessAuthorization()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->api_url.'/oauth/token');
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt($ch, CURLOPT_TIMEOUT, 90);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->config);
		$jsonData = curl_exec($ch);
		$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$responseData = json_decode($jsonData, true);
		curl_close($ch);

		if ($responseCode === 200)
		{
			$authorizationText = null;
			foreach ($responseData as $key => $value)
				$authorizationText .= $key.'='.$value."\n";

			$authorizationText .= "company_id=".md5($this->company_id)."\n";
			file_put_contents($this->ini_file, $authorizationText);

			$this->access_token = $responseData['access_token'];
		}
		else
		{
			throw new \Parasut\API\Exception($responseData["error_description"], $responseCode);
		}
	}

	/**
	 * @param $path
	 * @param null $params
	 * @param $method
	 * @return array|\stdClass
	 */
	public function request($path, $params = null, $method)
	{
		$curlURI = $this->api_url.'/'.$this->version.'/'.$this->company_id.'/'.$path;

		$response = [];
		if ($method === "GET")
			$response = $this->__getRequest($curlURI, $params, $this->access_token);

		if ($method === "POST")
			$response = $this->__postRequest($curlURI, $params, $this->access_token);

		if ($method === "PUT")
			$response = $this->__putRequest($curlURI, $params, $this->access_token);

		if ($method === "DELETE")
			$response = $this->__deleteRequest($curlURI, $params, $this->access_token);

		return $response;
	}
}

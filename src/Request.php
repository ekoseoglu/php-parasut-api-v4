<?php
namespace Parasut\API;

class Request
{
	protected function __getRequest($URL, $params, $accessToken)
	{
		if (is_array($params) && count($params) > 0) {
			$URL .= '?'.http_build_query($params);
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->__curlHeader($accessToken));
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt($ch, CURLOPT_TIMEOUT, 90);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

		$jsonData = curl_exec($ch);
		$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$responseData = json_decode($jsonData);
		curl_close($ch);

		return $this->_responseFormat($responseCode, $responseData);
	}

	protected function __postRequest($URL, $params, $accessToken)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->__curlHeader($accessToken));
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt($ch, CURLOPT_TIMEOUT, 90);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

		$jsonData = curl_exec($ch);
		$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$responseData = json_decode($jsonData);
		curl_close($ch);

		return $this->_responseFormat($responseCode, $responseData);
	}

	protected function __putRequest($URL, $params, $accessToken)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->__curlHeader($accessToken));
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt($ch, CURLOPT_TIMEOUT, 90);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

		$jsonData = curl_exec($ch);
		$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$responseData = json_decode($jsonData);
		curl_close($ch);

		return $this->_responseFormat($responseCode, $responseData);
	}

	protected function __deleteRequest($URL, $params, $accessToken)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->__curlHeader($accessToken));
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt($ch, CURLOPT_TIMEOUT, 90);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

		$jsonData = curl_exec($ch);
		$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$responseData = json_decode($jsonData);
		curl_close($ch);

		return $this->_responseFormat($responseCode, $responseData);
	}

	private function __curlHeader($accessToken)
	{
		return [
			'Accept: application/json',
			'Content-Type: application/json',
			'Authorization: Bearer '.$accessToken
		];
	}

	private function _responseFormat($responseCode, $responseData)
	{
		if ($responseCode >= 200 && $responseCode < 400)
		{
			$return = new \stdClass();
			$return->code = $responseCode;
			$return->result = isset($responseData) ? $responseData : null;
			return $return;
		}
		else
		{
			$return = new \stdClass();

			$return->code = $responseCode;
			switch ($responseCode) {
				case '400':
					if (isset($responseData->error))
					{
						$return->error_title = null;
						$return->error_message = "Bad Request: ". $responseData->error;
					}
					elseif (isset($responseData->errors))
					{
						$return->error_title = isset($responseData->errors[0]->title) ? $responseData->errors[0]->title : null;
						$errorDetail = isset($responseData->errors[0]->detail) ? $responseData->errors[0]->detail : null;
						$return->error_message = "Bad Request: ". $errorDetail;
					}
					break;
				case '401':
					if (isset($responseData->error))
					{
						$return->error_title = null;
						$return->error_message = "Unauthorized: ". $responseData->error;
					}
					elseif (isset($responseData->errors))
					{
						$return->error_title = isset($responseData->errors[0]->title) ? $responseData->errors[0]->title : null;
						$errorDetail = isset($responseData->errors[0]->detail) ? $responseData->errors[0]->detail : null;
						$return->error_message = "Unauthorized: ". $errorDetail;
					}
					break;
				case '403':
					if (isset($responseData->error))
					{
						$return->error_title = null;
						$return->error_message = "Forbidden: ". $responseData->error;
					}
					elseif (isset($responseData->errors))
					{
						$return->error_title = isset($responseData->errors[0]->title) ? $responseData->errors[0]->title : null;
						$errorDetail = isset($responseData->errors[0]->detail) ? $responseData->errors[0]->detail : null;
						$return->error_message = "Forbidden: ". $errorDetail;
					}
					break;
				case '404':
					if (isset($responseData->error))
					{
						$return->error_title = null;
						$return->error_message = "Not Found: ". $responseData->error;
					}
					elseif (isset($responseData->errors))
					{
						$return->error_title = isset($responseData->errors[0]->title) ? $responseData->errors[0]->title : null;
						$errorDetail = isset($responseData->errors[0]->detail) ? $responseData->errors[0]->detail : null;
						$return->error_message = "Not Found: ". $errorDetail;
					}
					break;
				case '422':
					if (isset($responseData->error))
					{
						$return->error_title = null;
						$return->error_message = "Unprocessable Entity: ". $responseData->error;
					}
					elseif (isset($responseData->errors))
					{
						$return->error_title = isset($responseData->errors[0]->title) ? $responseData->errors[0]->title : null;
						$errorDetail = isset($responseData->errors[0]->detail) ? $responseData->errors[0]->detail : null;
						$return->error_message = "Unprocessable Entity: ". $errorDetail;
					}
					break;
				case '429':
					if (isset($responseData->error))
					{
						$return->error_title = null;
						$return->error_message = "Too many requests: ". $responseData->error;
					}
					elseif (isset($responseData->errors))
					{
						$return->error_title = isset($responseData->errors[0]->title) ? $responseData->errors[0]->title : null;
						$errorDetail = isset($responseData->errors[0]->detail) ? $responseData->errors[0]->detail : null;
						$return->error_message = "Too many requests: ". $errorDetail;
					}
					break;
				default:
					break;
			}

			return $return;
		}
	}
}

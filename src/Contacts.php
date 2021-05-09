<?php
namespace Parasut\API;

class Contacts
{
	public $connector;

	public function __construct(Authorization $connector)
	{
		$this->connector = $connector;
	}

	public function index()
	{
		return $this->connector->request(
			'contacts/',
			[],
			'GET'
		);
	}

	public function create($data)
	{
		return $this->connector->request(
			'contacts',
			$data,
			'POST'
		);
	}

	public function show($id , $data = [])
	{
		return $this->connector->request(
			'contacts/' . $id,
			$data,
			'GET'
		);
	}

	public function search($data = [])
	{
		$filter = null;
		foreach ($data as $key => $value)
		{
			if (end($data) == $value)
				$filter .= "filter[$key]=$value";
			else
				$filter .= "filter[$key]=$value&";
		}

		return $this->connector->request(
			'contacts?'.$filter,
			[],
			'GET'
		);
	}

	public function edit($id , $data = [])
	{
		return $this->connector->request(
			'contacts/' . $id,
			$data,
			'PUT'
		);
	}

	public function delete($id)
	{
		return $this->connector->request(
			'contacts/' . $id,
			[],
			'DELETE'
		);
	}
}
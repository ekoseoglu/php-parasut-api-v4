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
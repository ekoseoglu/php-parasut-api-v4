<?php
namespace Parasut\API;

class Invoices
{
	public $connector;

	public function __construct(Authorization $connector)
	{
		$this->connector = $connector;
	}

	/**
	 * @return array|\stdClass
	 */
	public function list_invoice()
	{
		return $this->connector->request(
			'sales_invoices/',
			[],
			'GET'
		);
	}

	/**
	 * @param array $data
	 * @return array|\stdClass
	 */
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
			'sales_invoices?'.$filter,
			[],
			'GET'
		);
	}

	/**
	 * @param $id
	 * @return array|\stdClass
	 */
	public function show($id)
	{
		return $this->connector->request(
			'sales_invoices/'.$id.'?include=active_e_document,contact',
			[],
			'GET'
		);
	}

	/**
	 * @param $data
	 * @return array|\stdClass
	 */
	public function create($data)
	{
		return $this->connector->request(
			'sales_invoices?include=active_e_document',
			$data,
			'POST'
		);
	}

	/**
	 * @param $id
	 * @param $data
	 * @return array|\stdClass
	 */
	public function edit($id, $data)
	{
		return $this->connector->request(
			'sales_invoices/'.$id,
			$data,
			'POST'
		);
	}

	/**
	 * @param $id
	 * @return array|\stdClass
	 */
	public function delete($id)
	{
		return $this->connector->request(
			'sales_invoices/'.$id,
			[],
			'DELETE'
		);
	}

	/**
	 * @param $id
	 * @return array|\stdClass
	 */
	public function cancel($id)
	{
		return $this->connector->request(
			'sales_invoices/'.$id.'/cancel',
			[],
			'DELETE'
		);
	}

	/**
	 * @param $id
	 * @param $data
	 * @return array|\stdClass
	 */
	public function pay($id, $data)
	{
		return $this->connector->request(
			'sales_invoices/'.$id.'/payments',
			$data,
			'POST'
		);
	}

	/**
	 * @param $vkn
	 * @return array|\stdClass
	 */
	public function check_vkn_type($vkn)
	{
		return $this->connector->request(
			'e_invoice_inboxes?filter[vkn]='.$vkn,
			[],
			'GET'
		);
	}

	/**
	 * @param $id
	 * @return array|\stdClass
	 */
	public function create_e_archive($id)
	{
		$data = [
			"data" => [
				"type" => "e_archives",
				"relationships" => [
					"sales_invoice" => [
						"data" => [
							"id" => $id,
							"type" => "sales_invoices"
						]
					]
				]
			]
		];

		return $this->connector->request(
			'e_archives',
			$data,
			'POST'
		);
	}

	/**
	 * @param $id
	 * @return array|\stdClass
	 */
	public function show_e_archive($id)
	{
		return $this->connector->request(
			'e_archives/'.$id,
			[],
			'GET'
		);

	}

	/**
	 * @param $id
	 * @return array|\stdClass
	 */
	public function pdf_e_archive($id)
	{
		return $this->connector->request(
			"e_archives/$id/pdf",
			[],
			'GET'
		);
	}

	/**
	 * @param $data
	 * @return array|\stdClass
	 */
	public function create_e_invoice($data)
	{
		return $this->connector->request(
			'e_invoices',
			$data,
			"POST"
		);
	}

	/**
	 * @param $id
	 * @return array|\stdClass
	 */
	public function show_e_invoice($id)
	{
		return $this->connector->request(
			'e_invoices/'.$id,
			[],
			"GET"
		);
	}

	/**
	 * @param $id
	 * @return array|\stdClass
	 */
	public function pdf_e_invoice($id)
	{
		return $this->connector->request(
			"e_invoices/$id/pdf",
			[],
			"GET"
		);
	}
}
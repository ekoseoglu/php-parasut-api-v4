<?php
namespace Parasut\API;

class Products
{
	public $connector;

	public function __construct(Authorization $connector)
	{
		$this->connector = $connector;
	}

	/**
	 * @return array|\stdClass
	 */
	public function list_products()
	{
		return $this->connector->request(
			'products',
			[],
			"GET"
		);
	}

	/**
	 * @param array $data
	 * @return array|\stdClass
	 */
	public function search($data)
	{
		$filter = null;
		foreach ($data as $key => $value)
		{
			if (end($data) == $value)
				$filter .= "filter[$key]=".urlencode($value);
			else
				$filter .= "filter[$key]=".urlencode($value)."&";
		}

		return $this->connector->request(
			'products?'.$filter,
			[],
			"GET"
		);
	}

	/**
	 * @param $data
	 * @return array|\stdClass
	 */
	public function create($data)
	{
		return $this->connector->request(
			'products',
			$data,
			"POST"
		);
	}

	/**
	 * @param $id
	 * @return array|\stdClass
	 */
	public function show($id)
	{
		return $this->connector->request(
			'products/' . $id . '?include=inventory_levels,category',
			[],
			"GET"
		);
	}

	/**
	 * @param $id
	 * @param array $data
	 * @return array|\stdClass
	 */
	public function edit($id, $data = [])
	{
		return $this->connector->request(
			'products/' . $id,
			$data,
			"PUT"
		);
	}

	/**
	 * @param $id
	 * @return array|\stdClass
	 */
	public function delete($id)
	{
		return $this->connector->request(
			'products/' . $id,
			[],
			"DELETE"
		);
	}
}
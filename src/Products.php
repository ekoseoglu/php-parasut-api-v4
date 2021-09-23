<?php
namespace Parasut\API;

class Products
{
	public $connector;

	/**
	 * Products constructor.
	 * @param Authorization $connector
	 */
	public function __construct(Authorization $connector)
	{
		$this->connector = $connector;
	}

	/**
	 * @param int $page
	 * @param int $size
	 * @return array|\stdClass
	 */
	public function list_products($page = 1, $size = 25)
	{
		return $this->connector->request(
			"products?page[number]=$page&page[size]=$size",
			[],
			"GET"
		);
	}

	/**
	 * @return mixed
	 */
	public function count_products()
	{
		return $this->connector->request(
			"products?page[number]=1&page[size]=1",
			[],
			"GET"
		)->result->meta->total_count;
	}

	/**
	 * @param $product_id
	 * @return array|\stdClass
	 */
	public function show($product_id)
	{
		return $this->connector->request(
			"products/$product_id?include=inventory_levels,category",
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
			"products?$filter",
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
			"products",
			$data,
			"POST"
		);
	}

	/**
	 * @param $product_id
	 * @param array $data
	 * @return array|\stdClass
	 */
	public function edit($product_id, $data = [])
	{
		return $this->connector->request(
			"products/$product_id",
			$data,
			"PUT"
		);
	}

	/**
	 * @param $product_id
	 * @return array|\stdClass
	 */
	public function delete($product_id)
	{
		return $this->connector->request(
			"products/$product_id",
			[],
			"DELETE"
		);
	}
}

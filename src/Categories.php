<?php
namespace Parasut\API;

class Categories
{
	public $connector;

	/**
	 * Categories constructor.
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
	public function list_categories($page = 1, $size = 25)
	{
		return $this->connector->request(
			"item_categories?page[number]=$page&page[size]=$size",
			[],
			"GET"
		);
	}

	/**
	 * @return mixed
	 */
	public function count_categories()
	{
		return $this->connector->request(
			"item_categories?page[number]=1&page[size]=2",
			[],
			"GET"
		)->result->meta->total_count;
	}

	/**
	 * @param $category_id
	 * @return array|\stdClass
	 */
	public function show($category_id)
	{
		return $this->connector->request(
			"item_categories/$category_id?include=parent_category,subcategories",
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
			"item_categories?$filter",
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
			"item_categories",
			$data,
			"POST"
		);
	}

	/**
	 * @param $category_id
	 * @param array $data
	 * @return array|\stdClass
	 */
	public function edit($category_id, $data = [])
	{
		return $this->connector->request(
			"item_categories/$category_id",
			$data,
			"PUT"
		);
	}

	/**
	 * @param $category_id
	 * @return array|\stdClass
	 */
	public function delete($category_id)
	{
		return $this->connector->request(
			"item_item_categories/$category_id",
			[],
			"DELETE"
		);
	}
}

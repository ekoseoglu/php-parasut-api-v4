<?php
namespace Parasut\API;

class Contacts
{
	public $connector;

	/**
	 * Contacts constructor.
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
	public function list_contacts($page = 1, $size = 25)
	{
		return $this->connector->request(
			"contacts?page[number]=$page&page[size]=$size",
			[],
			"GET"
		);
	}

	/**
	 * Contact total count
	 * @return integer
	 */
	public function count_contacts()
	{
		return $this->connector->request(
			"contacts?page[number]=1&page[size]=1",
			[],
			"GET"
		)->result->meta->total_count;
	}

	/**
	 * Show contact
	 * @param $contact_id
	 * @return array|\stdClass
	 */
	public function show($contact_id)
	{
		return $this->connector->request(
			"contacts/$contact_id",
			[],
			"GET"
		);
	}

	/**
	 * Search contact with params
	 * @param array $data
	 * @return array|\stdClass
	 */
	public function search($data = [])
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
			"contacts?$filter",
			[],
			"GET"
		);
	}

	/**
	 * Create contact
	 * @param $data
	 * @return array|\stdClass
	 */
	public function create($data)
	{
		return $this->connector->request(
			"contacts",
			$data,
			"POST"
		);
	}

	/**
	 * Edit contact
	 * @param $contact_id
	 * @param array $data
	 * @return array|\stdClass
	 */
	public function edit($contact_id , $data = [])
	{
		return $this->connector->request(
			"contacts/$contact_id",
			$data,
			"PUT"
		);
	}

	/**
	 * Delete contact
	 * @param $contact_id
	 * @return array|\stdClass
	 */
	public function delete($contact_id)
	{
		return $this->connector->request(
			"contacts/$contact_id",
			[],
			"DELETE"
		);
	}
}

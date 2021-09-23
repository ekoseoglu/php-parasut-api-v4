<?php
namespace Parasut\API;

class Accounts
{
	public $connector;

	/**
	 * Accounts constructor.
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
	public function list_accounts($page = 1, $size = 25)
	{
		return $this->connector->request(
			"accounts?page[number]=$page&page[size]=$size",
			[],
			"GET"
		);
	}

	/**
	 * @param $account_id
	 * @return array|\stdClass
	 */
	public function show($account_id)
	{
		return $this->connector->request(
			'accounts/' . $account_id,
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
			'accounts?'.$filter,
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
			'accounts',
			$data,
			"POST"
		);
	}

	/**
	 * @param $account_id
	 * @param array $data
	 * @return array|\stdClass
	 */
	public function edit($account_id, $data = [])
	{
		return $this->connector->request(
			'accounts/' . $account_id,
			$data,
			"PUT"
		);
	}

	/**
	 * @param $account_id
	 * @return array|\stdClass
	 */
	public function delete($account_id)
	{
		return $this->connector->request(
			'accounts/' . $account_id,
			[],
			"DELETE"
		);
	}

	/**
	 * @param $account_id
	 * @return array|\stdClass
	 */
	public function list_transactions($account_id)
	{
		return $this->connector->request(
			'accounts/' . $account_id . '/transactions?include=debit_account,credit_account',
			[],
			"GET"
		);
	}

	/**
	 * @param $account_id
	 * @param $data
	 * @return array|\stdClass
	 */
	public function import_transactions($account_id, $data)
	{
		return $this->connector->request(
			'accounts/' . $account_id . '/debit_transactions',
			$data,
			"POST"
		);
	}

	/**
	 * @param $account_id
	 * @param $data
	 * @return array|\stdClass
	 */
	public function export_transactions($account_id, $data)
	{
		return $this->connector->request(
			'accounts/' . $account_id . '/credit_transactions',
			$data,
			"POST"
		);
	}

	/**
	 * @param $transaction_id
	 * @return array|\stdClass
	 */
	public function show_transactions($transaction_id)
	{
		return $this->connector->request(
			'transactions/' . $transaction_id,
			[],
			"GET"
		);
	}

	/**
	 * @param $transaction_id
	 * @return array|\stdClass
	 */
	public function delete_transactions($transaction_id)
	{
		return $this->connector->request(
			'transactions/' . $transaction_id,
			[],
			"DELETE"
		);
	}
}

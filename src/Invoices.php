<?php
namespace Parasut\API;

class Invoices
{
	public $connector;

	/**
	 * Invoices constructor.
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
	public function list_invoices($page = 1, $size = 25)
	{
		return $this->connector->request(
			"sales_invoices/?page[number]=$page&page[size]=$size",
			[],
			'GET'
		);
	}

	/**
	 * @return mixed
	 */
	public function count_sales_invoices()
	{
		return $this->connector->request(
			"sales_invoices/?page[size]=1",
			[],
			'GET'
		)->result->meta->total_count;
	}

	/**
	 * @param int $page
	 * @param int $size
	 * @return array|\stdClass
	 */
	public function list_e_invoices($page = 1, $size = 25)
	{
		return $this->connector->request(
			"e_invoices/?page[number]=$page&page[size]=$size",
			[],
			'GET'
		);
	}

	/**
	 * @return mixed
	 */
	public function count_e_invoices()
    {
        return $this->connector->request(
            "e_invoices/?page[number]=1&page[size]=1",
            [],
            'GET'
        )->result->meta->total_count;
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
				$filter .= "filter[$key]=".urlencode($value);
			else
				$filter .= "filter[$key]=".urlencode($value)."&";
		}

		return $this->connector->request(
			"sales_invoices?$filter",
			[],
			'GET'
		);
	}

	/**
	 * @param $invoice_id
	 * @return array|\stdClass
	 */
	public function show($invoice_id)
	{
		return $this->connector->request(
			"sales_invoices/$invoice_id?include=active_e_document,contact,details.product",
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
			"sales_invoices?include=active_e_document",
			$data,
			'POST'
		);
	}

	/**
	 * @param $invoice_id
	 * @param $data
	 * @return array|\stdClass
	 */
	public function edit($invoice_id, $data)
	{
		return $this->connector->request(
			"sales_invoices/$invoice_id",
			$data,
			'POST'
		);
	}

	/**
	 * @param $invoice_id
	 * @return array|\stdClass
	 */
	public function delete($invoice_id)
	{
		return $this->connector->request(
			"sales_invoices/$invoice_id",
			[],
			'DELETE'
		);
	}

	/**
	 * @param $invoice_id
	 * @return array|\stdClass
	 */
	public function cancel($invoice_id)
	{
		return $this->connector->request(
			"sales_invoices/$invoice_id/cancel",
			[],
			'DELETE'
		);
	}

	/**
	 * @param $invoice_id
	 * @param $data
	 * @return array|\stdClass
	 */
	public function pay($invoice_id, $data)
	{
		return $this->connector->request(
			"sales_invoices/$invoice_id/payments",
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
			"e_invoice_inboxes?filter[vkn]=$vkn",
			[],
			'GET'
		);
	}

	/**
	 * @param $data
	 * @return array|\stdClass
	 */
	public function create_e_archive($data)
	{
		return $this->connector->request(
			'e_archives',
			$data,
			'POST'
		);
	}

	/**
	 * @param $e_archive_id
	 * @return array|\stdClass
	 */
	public function show_e_archive($e_archive_id)
	{
		return $this->connector->request(
			'e_archives/'.$e_archive_id,
			[],
			'GET'
		);

	}

	/**
	 * @param $e_archive_id
	 * @return array|\stdClass
	 */
	public function pdf_e_archive($e_archive_id)
	{
		return $this->connector->request(
			"e_archives/$e_archive_id/pdf",
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
	 * @param $e_invoice_id
	 * @return array|\stdClass
	 */
	public function show_e_invoice($e_invoice_id)
	{
		return $this->connector->request(
			'e_invoices/'.$e_invoice_id,
			[],
			"GET"
		);
	}

	/**
	 * @param $e_invoice_id
	 * @return array|\stdClass
	 */
	public function pdf_e_invoice($e_invoice_id)
	{
		return $this->connector->request(
			"e_invoices/$e_invoice_id/pdf",
			[],
			"GET"
		);
	}

	/**
	 * @param $url
	 * @param $path
	 * @return bool
	 */
	public function upload_pdf($url, $path)
	{
		if (!function_exists("file_put_contents"))
			return false;

		if (!function_exists("file_get_contents"))
			return false;

		$getPDF = @file_get_contents($url);

		if (!$getPDF)
			return false;

		$upload = @file_put_contents($path, $getPDF);

		if (!$upload)
			return false;

		return true;
	}

	/**
	 * @param $trackable_id
	 * @return array|\stdClass
	 */
	public function trackable_jobs($trackable_id)
	{
		return $this->connector->request(
			"trackable_jobs/$trackable_id",
			[],
			"GET"
		);
	}
}

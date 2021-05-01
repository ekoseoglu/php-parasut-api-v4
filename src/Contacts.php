<?php
namespace ParasutAPI;

class Contacts extends Base
{
	/**
	 * @throws \Exception
	 */
	public function show($id , $data = [])
	{
		return $this->connect->request(
			'contacts/' . $id,
			$data,
			'GET'
		);
	}
}
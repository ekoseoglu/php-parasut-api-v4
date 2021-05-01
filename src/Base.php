<?php
namespace ParasutAPI;

class Base
{
	public $connect;

	public function __construct(Connect $connect)
	{
		$this->connect = $connect;
	}
}
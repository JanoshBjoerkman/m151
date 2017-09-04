<?php
namespace M151;

class Application
{
	private $request;

	public function start()
	{
		
	}

	public function setRequest(Request $r)
	{
		$this->request = $r;
	}
}
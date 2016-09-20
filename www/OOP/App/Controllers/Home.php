<?php

namespace App\Controllers;

class Home extends \Core\Controller
{

	public function indexAction()
	{
		echo "Hello from the index action in the Home controller!";
	}

	protected function before()
	{
		echo "(before)";
	}

	protected function after()
	{
		echo "(after)";
	}

}

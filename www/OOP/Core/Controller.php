<?php

namespace Core;

include_once('../App/config.php');

use \Core\View;

abstract class Controller
{

	protected $modelObj = [];
	protected $renderParams = [];

	public function __call($name, $args)
	{

		//echo "<pre>", var_dump($args), "</pre>";	//temporary line...
		$this->modelObj = $args['0'];

        array_shift($args);

		$method = $name . 'Action';

		if (method_exists($this, $method)){
			if ($this->before($method) !== false){
				call_user_func_array([$this, $method], $args);
				$this->after();
			}
		}else{
			echo "Method $method not found in controller " . get_class($this);
		}
		
	}

	protected function redirect($path)
	{
		header("location: " . SITE . $path);
		exit;
	}

	protected function getLastUrl()
	{
		return $_SERVER['HTTP_REFERER'];
	}

}






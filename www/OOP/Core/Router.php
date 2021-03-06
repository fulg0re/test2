<?php

namespace Core;

use \App\Views;

class Router
{

	protected $routes = [];

	public $params = [];

	function __construct()
	{
		$this->add('', ['controller' => 'Users', 'action' => 'index']);
		$this->add('{controller}', ['action' => 'index']);
		$this->add('{controller}/{action}');
		$this->add('{controller}/{action}/{id:\d+}');
		$this->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
	}

	public function getRoutes()
	{
		return $this->routes;
	}

	public function getParams()
	{
		return $this->params;
	}

	public function add($route, $params = [])
	{
		$route = preg_replace('/\//', '\\/', $route);
		
		$route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
		
		$route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
		
		$route = '/^' . $route . '$/i';
		
		$this->routes[$route] = $params;
	}

	public function match($url)
	{
		foreach ($this->routes as $route => $params){
			if (preg_match($route, $url, $matches)){
				foreach ($matches as $key => $match){
					if (is_string($key)){
						$params[$key] = $match;
					}
				}

				$this->params = $params;
				return true;
			}
		}

		return false;
	}

	private function newModelObj($modelName)
	{
		$modelClass = "\\App\\Models\\";
		$modelClass .= substr(ucfirst($modelName), 0, -1);
		$model = new $modelClass($modelName);
		return $model;
	}

	public function dispatch($url)
	{
		$url = $this->removeQueryStringVariables($url);

		if ($this->match($url)){
			$controller = $this->params['controller'];
			$controller = $this->convertToStudlyCaps($controller);
			$controller = $this->getNamespace() . $controller;

			if (class_exists($controller)){
				$controller_object = new $controller($this->params);

				$action = $this->params['action'];
				$action = $this->convertToCamelCase($action);

				if (is_callable([$controller_object, $action])){

					// creating new object of model...
					$model = $this->newModelObj($this->params['controller']);

					$route = $this->params['controller'] . '/' . $action;

					if (isset($this->params['id'])){
						$controller_object->$action($model, $route, $this->params['id']);
					}else{
						$controller_object->$action($model, $route);
					}
				}else{
					echo "Method $action (in controller $controller) not found";
				}
			}else{
				echo "Controller class $controller not found";
			}
		}else{
			echo "No route matched.";
		}
	}

	protected function convertToStudlyCaps($string)
	{
		return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
	}

	protected function convertToCamelCase($string)
	{
		return lcfirst($this->convertToStudlyCaps($string));
	}

	protected function removeQueryStringVariables($url)
	{
		if ($url != ''){
			$parts = explode('&', $url, 2);

			if (strpos($parts[0], '=') === false){
				$url = $parts[0];
			}else{
				$url = '';
			}
		}

		return $url;
	}

	protected function getNamespace()
	{
		$namespace = 'App\Controllers\\';

		if (array_key_exists('namespace', $this->params)){
			$namespace .= $this->params['namespace'] . '\\';
		}

		return $namespace;
	}

}



















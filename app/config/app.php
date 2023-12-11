<?php

Class Application
{
	/** 
	 * Note: 'PagesController' will be a controller class inside  /controllers/ diretory
	 * This file set to handle all auth directories views
	 * Example: if you want to create a page files in a subfolder in /views/, to render this page you need to create the method of that page inside 'PagesController'
	 * i.e /views/auth/login.php or /views/auth/registe.php, to render this on the web page, you need to create the controller method in '/controllers/PagesController.php'
	 * 
	*/
	private $controller = "PagesController";
	private $method = "index";
	private $params = [];

	public function __construct()
	{

		$url = $this->splitURL();

 		if(file_exists("../app/controllers/". strtolower($url[0]) .".php"))
 		{
 			$this->controller = strtolower($url[0]);
 			unset($url[0]);
 		}

 		require "../app/controllers/". $this->controller .".php";
 		$this->controller = new $this->controller;
 
 		if(isset($url[1]))
 		{
 			if(method_exists($this->controller, $url[1]))
 			{
 				$this->method = $url[1];
 				unset($url[1]);
 			}
 		}

 		//run the class and method
 		$this->params = array_values($url);
 		call_user_func_array([$this->controller,$this->method], $this->params);
	}

	private function splitURL()
	{
		$url = isset($_GET['url']) ? $_GET['url'] : "index";
		return explode("/", filter_var(trim($url,"/"),FILTER_SANITIZE_URL));
	}
}

<?php

class RouterModel{
    //variable to hold URI request
	private $request;
    // private $localpath = 'dwpSocialWeb';

	//construct to set local request var
	public function __construct($request){
		$this->request = $request;
	}

	//function to trim / from end, set an array of arguments and require php file
	public function get($route, $file){

        // $uri = str_replace($this->request, $this->localpath, '');

		// $uri = trim( $this->request, "/" );

		$uri = explode("/", $this->request);

		// require $file . '.php';

		//if the input route and array index 0 (minus the /) match
		if($uri[0] == trim($route, "/")){

		    //remove index 0 and reset the array index
			// array_shift($uri);
			$args = $uri;

			require $file . '.php';

		} else if ($route == '404') {
			require $file . '.php';
		}

	}
}
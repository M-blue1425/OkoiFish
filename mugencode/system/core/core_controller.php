<?php

namespace system\core;

/**
 * IamRoot
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2018 - 2022, Iamroot Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	IamRoot
 * @author	Shigansina
 * @link	https://iam-root.tech
 * @since	Version 1.0.0
 * @filesource
 */

use application\config\routes;
use system\core\method;
use system\library\user_agent;
use system\library\link_relation;
use system\library\SimpleImage;

/**
 * controller Class
 *
 * this class controlling all bout site and any function
 * to load on your project
 *
 * @package		system
 * @subpackage	core
 * @category	site controller
 * @author		IamRoot Team
 */

class controller{

	// --------------------------------------------------------------------

    /**
     * Read paramater from method
     *
     * @return string
     * @return array
     * @return mixed
     */
	private function filter_paramater($type){
		
		switch($type){
			
			// fillter GET method
			case "GET" :

					foreach((new method)->get() as $key => $val){

						$feedback[$key] = $val;
						$response = true;
						
					}
			
				if(isset($response)){
			
					return $feedback;
			
				}else{
			
					return array();
			
				}
		break;


		// filter SERVER method
		case "SERVER" :
			
					foreach($_SERVER as $key => $val){
						$feedback[$key] = $val;
						$response = true;
					}
			
				if(isset($response)){
			
					return $feedback;
			
				}else{
			
					return array();
			
				}
		break;


		// filter POST method
		case "POST" :
			
					foreach($_POST as $key => $val){
						$feedback[$key] = $val;
						$response = true;
					}
			
				if(isset($response)){
			
					return $feedback;
			
				}else{
			
					return array();
			
				}
		break;
		}
	}


	// --------------------------------------------------------------------

    /**
     * Rewrite Permalink
     *
     * @return void
     * @return mixed
     */

	public function declarate_space($data,$config = null){
		
		// rebuilt especially parameter from GET method
		foreach (self::filter_paramater("GET") as $key => $value) {

			$_GET[$key] = $value;

		}

		// rebuilt especially parameter from post method
		foreach (self::filter_paramater("POST") as $key => $value) {

			$_POST[$key] = $value;

		}

		(new link_relation);



			$path = SERVER."/application/controller/".(new routes)->load_controller()['internal_proccess'].".php";

			if(is_file($path)){

				set_error_handler("handleError");
    			
    			register_shutdown_function('ShutDown');
				
				require_once($path);

			}

		if(!isset($data_value)){

			$data_value = array("" => "");

		}else{

			foreach ($data_value as $key => $value) {
				
				$create_list["{".$key."}"] = $value;
			}

			$data_value = $create_list;

		}

		

		if(!empty(splice(1))){
			
			// checking and sellection
			
			if(in_array(splice(1),array_keys($data))){

				// amp mode detection

				foreach($data as $key => $val){

					if(splice(1) == $key){

						// url found
						$path = SERVER."/application/views/".self::amp_mode($data,$val).".php";

						if(is_file(DirSeparator($path))){

							set_error_handler("handleError");
    			
    						register_shutdown_function('ShutDown');
							
						    ob_start();

				            require_once(DirSeparator($path));

				            $ob = ob_get_clean();

				            echo str_replace(array_keys($data_value),$data_value, $ob);
				           
							exit;

						}else{

							//url found but target not found
							set_error_handler("handleError");
    			
    						register_shutdown_function('ShutDown');

							require_once(SERVER."/404.php");
							exit;
						}
					}
				}

			}else{

				// url not found
				if(splice(1) == "image"){

				$source_img = decrypt(splice(2));

					if($source_img !== false){

						$source_img = $source_img;

					}else{

						$source_img = HomeUrl()."/content/404-img.png";

					}

					resize_image($source_img,null,splice(3),splice(4));

					exit;
				
				
				}elseif(splice(1) == "show-error"){

					$_SESSION['debug'] = 1;
					redirect(homeUrl());

				}elseif(splice(1) == "hide-error"){

					$_SESSION['debug'] = 0;
					redirect(homeUrl());

				}else{

					if(isset($data['cusTom'])){

						$path = SERVER."/application/views/".self::amp_mode($data,$data['cusTom']).".php";

						if(is_file(DirSeparator($path))){

							set_error_handler("handleError");
    			
    						register_shutdown_function('ShutDown');

							ob_start();

							require_once($path);

							$ob = ob_get_clean();

				            echo str_replace(array_keys($data_value),$data_value, $ob);

							exit;

						}

					}

					set_error_handler("handleError");
    			
    				register_shutdown_function('ShutDown');
    				
					require_once(SERVER."/404.php");	
					
				}

				exit;

			}

		}else{
			
			// set default target
			if(isset($data['cusTom'])){

				$path = SERVER."/application/views/".self::amp_mode($data,$data['cusTom']).".php";

				if(is_file(DirSeparator($path))){

					set_error_handler("handleError");
    			
    				register_shutdown_function('ShutDown');

					ob_start();

					require_once(DirSeparator($path));
					
					$ob = ob_get_clean();

				    echo str_replace(array_keys($data_value),$data_value, $ob);

					exit;

				}

			}


			$path = SERVER."/application/views/".self::amp_mode($data,$config)."index.php";

			if(is_file(DirSeparator($path))){		
    			
    			set_error_handler("handleError");
    			
    			register_shutdown_function('ShutDown');

    			ob_start();

	            require_once(DirSeparator($path));
	        	
	        	$ob = ob_get_clean();

				echo str_replace(array_keys($data_value),$data_value, $ob);

	    		exit;

			}else{

				echo "WELCOME TO OUR FRAME WORK";	

				exit;
				
				}
			
			}
	}

	// --------------------------------------------------------------------

    /**
     * Accelerate Moible Page
     *
     * @return void
     * @throws \user_agen on device checker
     */

	private function amp_mode($data,$url){

		if(isset($data[splice(1)])){

			if(is_array($data[splice(1)])){

				if((new user_agent)->is_mobile()){

					$_SESSION['amp'] = "/mobile";

					$amp_mode = "/mobile/".$url['amp'];

				}else{

					$_SESSION['amp'] = "/desktop";

					$amp_mode = "/desktop/".$url['amp'];
				}

			}else{

				$_SESSION['amp'] = null;

				$amp_mode = $url;

			}

		}else{

			if(is_array($url)){

				if((new user_agent)->is_mobile()){

					$_SESSION['amp'] = "/mobile";

					$amp_mode = "/mobile/".$url['amp'];

				}else{

					$_SESSION['amp'] = "/desktop";

					$amp_mode = "/desktop/".$url['amp'];
				}

			}else{

				$_SESSION['amp'] = null;

				$amp_mode = $url;

			}

		}

		return $amp_mode;

	}

}
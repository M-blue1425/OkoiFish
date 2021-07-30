<?php

/**

  * saving file system
  * Return Text/html

*/

userspace();

if(isset($_POST['script']) and isset($_POST['path'])){

	// saving file

	write_file(

		htmlspecialchars_decode($_POST['script']),
		DirSeparator(project_disk()->realpath.$_POST['path']),
		"w+"
	);

}
	
	if(isset($_POST['url'])){

	// get url preview
	$url = str_replace(
		project_disk()->domainname,
		null,
		$_POST['url']
	);

	$info = file_modulator(project_disk()->realpath.$url);

	// if json preview
	if($info->extention == "json"){

    $json = base64_encode(read_file(project_disk()->realpath.$url));
	echo '
	<div style="padding:10px;height:100%;overflow-y:scroll;">

	<span id="result-json"></span><script>pretty_json("'.$json.'");</script>
	
	</div>
	';



	}else{

	// show iframe for result and not json preiews
	$get_method = explode("?",$url);

	if(count($get_method) > 1){

		if(trim($get_method[1]) !== null){

			$url = $url;

		}else{

			$url = $url;	

		}

	}else{

		$url = $url;
		
	}

	// load iframe result
	echo "<iframe id='iframe' src='".DirSeparator(project_disk()->domain.$url)."' style='width:100%;height:100%;border:transparent'></iframe>";
	}
}

if(isset($_POST['spec_id']) and isset($_SESSION[$_POST['spec_id']])){
	
	unset($_SESSION[$_POST['spec_id']]);

}

BlockFunction();

?>
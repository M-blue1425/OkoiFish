<?php 

if(isset($_POST['option'])){

	if($_POST['option'] == "generate"){
		$file_url = DirSeparator(project_disk()->realpath."/".($_POST['path']));
		readfile($file_url);
		echo "<iframe src='force_download?path=".encrypt($_POST['path'])."&name=".encrypt($_POST['newname'])."&download=true&log=".time()."' style='display:none'></iframe>";

	}

}

if(isset($_GET['download'])){

	$file_name = decrypt($_GET['name']);
	$file_url = DirSeparator(project_disk()->realpath."/".decrypt($_GET['path']));
	readfile($file_url);
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=".$file_name);
	header("Content-Transfer-Encoding: binary ");

}

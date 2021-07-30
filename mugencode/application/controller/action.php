<?php

/**
MUGENCODE CORE SYSTEM

@AUTHOR IAMROOT

  * base cntroller

*/

// load config

	function userinfo($user_id = null){


		if(empty($user_id)){

			if(!isset($_SESSION['user'])) return false;
			
			$value = $_SESSION['user'];

		}else 
		
			$value = $user_id;

		
		$query = database()->query("SELECT * FROM db_users WHERE username='".$value."' ");
		$show = $query->fetch();
		$show['user_id'] = $show['id'];


		if($query->rowCount() !== 0){

			return json_decode(json_encode($show));

		}

		return false;

	}
	
	function config($type = 1){

		if(isset($_POST['username'])){

			if(file_exists(SERVER."/application/views/userconfig/".$_POST['username'].".json")){

				$load_config = "userconfig/".$_POST['username'].".json";			

				$_SESSION['config'] = true;

			} else {
				
				$load_config = "userconfig/config.json";

				$_SESSION['config'] = false;

			}

		}else $load_config = "userconfig/config.json";

		if(isset($_SESSION['user_login']) and isset($_SESSION['config'])){

			if($_SESSION['config'] == true ){
	
				$load_config = "userconfig/".$_SESSION['user_login'].".json";

			}else{

				$load_config = "userconfig/config.json";
			}

		}

		
		if($type == 1){

			return fetch_json(SERVER."/application/views/".$load_config);

		}else if($type == 2){

			return read_file(SERVER."/application/views/".$load_config);

		}elseif($type == 3){

			return SERVER."/application/views/".$load_config;

		}

	}

// clean Url
	function clean_url($text = null){

		return preg_replace("([:/. _()*&^%$#@!])","-",$text);

	}

// allowed dextention
	function disallow_extention(){
		return config()->disallow_extention;
	}

// user space
	function userspace(){

		if((userinfo() == false)) header("location:".homeUrl()."/login");
		if((userinfo() !== false) and (userinfo()->level < 3)) header("location:".homeUrl()."/login");
	
		

		$_SESSION['user_login'] = userinfo()->username;

		space_creator();
		
		if(config()->status == 0 and splice(1) !== "login"){
			echo "<logout/>";
			session_destroy();
			exit;
		}
		// if(config()->multi_user_mode == "on"){
			
		// }
		
	}

// detecting is_dir true from config.json
function space_creator(){

	if(file_exists(project_disk()->realpath) == true and is_dir(project_disk()->realpath) == false){
			mkdir(DirSeparator(project_disk()->realpath));
		}

}

// get file information
	function file_modulator($value){

		// path data
		$value = DirSeparator($value);

		$get_name = get_file_name($value);
		$format = strtolower(get_extention($value));

		if(is_file($value)){

		// show file information

			$type = true;

			foreach(config()->file_extention_config as $key => $val){

				if($format == $key){

				
						$show = json_decode(json_encode($val));
						$icon = $show->icon;
						$color = $show->color;
						$ext = $show->content_type;

						$response = 1;
						break;
					
				
					}else{
			
						$response = 0;
			
					}
			}

			if($response == 0){

						$icon = "fab fa-connectdevelop";
						$color = "#666";
						$ext = "application/x-httpd-php";

			}
			

			}else{
				
				$type = false;
				$icon = 'fas fa-folder';
				$color = "#f0e79b";
				$ext = 0;

			}

			// return json
			return json_decode(json_encode([
				"name" => $get_name,
				"type" => $type,
				"icon" => $icon,
				"color"=> $color,
				"content_type" => $ext,
				"extention" => $format,
				]));
	}


// set base path 
	function project_disk(){

		// dir sessiion
		if(isset($_SESSION['ROOT_DIR'])){
			
			if(!empty($_SESSION['ROOT_DIR'])){

				$session = $_SESSION['ROOT_DIR']."/";

			}else{

				$session = null;

			}
		}else{

			$session = null;

		}

		// fetch dir information

		$get_static_path = explode("/",SERVER);

		foreach ($get_static_path as $key => $value) {
			if($key < (count($get_static_path) - config()->back_dir)) {
				$path[] = $value;
			}
		}

		// $path = implode("/",$path);
		$path = "/";

		$domain_name = config()->preview_url;
		$location = DirSeparator("/".config()->preview_path."/".$session);
		$domain = DirSeparator($domain_name.$session);
		$path = DirSeparator($path.$location);

		$root_dir = $get_static_path[count($get_static_path) - (config()->back_dir + 1) ];

		$root_dir = explode($root_dir,$path);
		


		// return json
		return json_decode(json_encode([
			"curentpath" => $root_dir[1],
			"realpath" => $path,
			"domain" => $domain,
			"domainname" => $domain_name,
		]));

	}

// directory scanner
	function BlockFunction($act = null){

		if(config()->ini_scan == 1){

			$lit = project_disk()->realpath;

			// directory literator data			

			foreach (LiteratorScan($lit) as $file) {

				$extention = get_extention($file);

				foreach(config()->wipe_illegal_extention as $key => $val){

					if($extention == $val){
						
						unlink(DirSeparator($file));				

					}	

				}
			}
		}
	}

// get listing file
	function listingFile($dirs = null){

		if(empty($dirs) or (trim($dirs) == "/")){
			$dir_target = DirSeparator(project_disk()->realpath."/{,.}*");
		}else{
			$dir_target = DirSeparator(project_disk()->realpath.$dirs."/{,.}*");
		}

		$scan = scan_dir($dir_target);

		if(is_array($scan)){
			foreach ($scan as $key => $value) {

				$get_name = get_file_name($value);
				$extention = get_extention($value);

				if(trim($get_name) !== "temporary_data" and trim($get_name) !== BASE_DIR_NAME ) {

				$get_info = file_modulator($value);

				$name[] = [

					"name" => $get_name,
					"path" => $value,
					"type" => $get_info->type,
					"icon" => $get_info->icon,
					"color" => $get_info->color,

				];


			}
		}

	}

	if(!isset($name)){

		$name = array();

	}
	// return json
	return json_decode(json_encode(@$name));

	}

// show file from listingfile
	function showFileName($dirs = null){

		if(empty($dirs) or ($dirs == "/")){
			$dir_target = null;
		}else{
			$dir_target = $dirs;
		}

		// directory listing
		$listing = listingFile($dir_target);

		if($listing == true){
		foreach($listing as $key => $value){

			if($value->type == false){			

			$base = str_replace(project_disk()->realpath,"/",$value->path);

			$browse = DirSeparator(project_disk()->domainname.$base);

			$special_id = clean_url(DirSeparator($value->path."/"));

			$name[] = listing_template($browse,$special_id,$value,$base,"","dir");

				}
			}

		$dissalow = disallow_extention();

		// file listing
		foreach($listing as $key => $value){

			$ext = explode(".", $value->name);

			if(!in_array($ext[count($ext)-1],$dissalow)){

			if($value->type == true){

			$file = get_file_name($value->path);

			$base = str_replace(project_disk()->realpath,"/",$value->path);

			$browse = DirSeparator(project_disk()->domainname.$base);

			$special_id = clean_url(DirSeparator($value->path."/"));

			$name[] = listing_template($browse,$special_id,$value,$base,$file,"file");

			}
		}
	}
	}

	if(!isset($name)){

		$name = array();

	}
		$name = array_unique($name);
		// return txt/html
		return @implode(null,$name);
	}


// Fie listing template
	function listing_template($browse,$special_id,$value,$base,$file,$act){

		// listing directory

		if(strlen($value->name) > 20){
				
			$substring = substr($value->name,(strlen($value->name)-7),strlen($value->name));
			$file_name = StringLimit($value->name,8,"...".$substring);

		}else{

			$file_name = $value->name;

		}

		$tmp_base = $base."-time";
		$destpath = explode("/",$tmp_base);
		$destpath = $destpath[(count($destpath) - 1)];
		$destpath = str_replace($destpath,null,$tmp_base);

		if($act == "dir"){
		return '<li type="child" title="Directory : '.$value->name.'" browse="'.$browse.'" curentpath="'.DirSeparator(config()->preview_path.'/'.$base).'" doctype="doc" status="hide" class="child-content select-area upload-area dir-name file-name file-name-'.$special_id.'" onClick="showDir(\''.$special_id.'\')" id="dir-'.$special_id.'" name="'.$value->name.'" place="'.$special_id.'" destpath="'.DirSeparator($base."/").'" realpath="'.$base.'">
			<input class="form-control form-control-custom" value="'.$base.'" id="val-dir-'.$special_id.'" style="display:none;">
			<span id="active-name-'.$special_id.'">
			
			<span style="margin-left:0px;" class="fno" id="name-dir-'.$special_id.'">
			<i class="fa fa-caret-right" style="margin-right:5px;" id="icn-'.$special_id.'"></i>
			<i class="'.$value->icon.' icon-'.$special_id.'" style="position:relative;margin-top:2px;font-size:15px;color:'.$value->color.';margin-right:8px;"></i>'.$file_name.'</span>
			</span>
			<table class="fnm" id="go-change-name-'.$special_id.'" style="width:100%;display:none;z-index:1">
			<tr>
			<td style="width:14px;">
			<i class="fa fa-caret-right" style="margin-right:5px;" id="icn-'.$special_id.'"></i>
			</td>
			<td style="width:20px;">
			<i class="fas fa-folder" style="margin-right:5px;color:'.$value->color.';font-size:15px;" id="icn-'.$special_id.'"></i>
			</td>
			<td>
			<input class="form-control form-control-custom" type="text" id="change-file-name-'.$special_id.'" style="border:1px #ccc solid;border-radius:4px;width:100%;padding-left:5px;" >
			</td>
			<td style="width:50px;text-align:right">
			<i class="fa fa-check" style="cursor:pointer;" onClick="save_rename_file(\''.$special_id.'\',\'doc\',\'4\',\'change-file-name\',\'rename\')"></i>
			<i class="fa fa-times" style="cursor:pointer;" onClick="close_rename_file(\''.$special_id.'\')"></i>
			</td>
			</tr>
			</table>
			<img src="'.projectUrl().'/assets/img/ovalo.svg" width="15" style="float:right;margin-top:3px;display:none;position:relative;" id="loading-'.$special_id.'">
			<i style="float:right;position:relative;margin-top:3px;color:#666;display:none;" class="fa fa-upload uploads-'.$special_id.'"></i>
			</li>


			<table class="newf" id="add-'.$special_id.'" style="width:100%;display:none;z-index:1">
			<tr>
			<td style="width:20px;"></td>
			<td>
			<input class="form-control form-control-custom" type="text" id="input-'.$special_id.'" style="border:1px #ccc solid;border-radius:4px;width:100%;padding-left:5px;font-size:12px;" Placeholder="New Folder" >
			</td>
			<td style="width:50px;text-align:right">
			<i class="fa fa-check" style="cursor:pointer;" onClick="save_rename_file(\''.$special_id.'\',\'doc\',\'3\',\'input\',\'newdir\')"></i>
			<i class="fa fa-times" style="cursor:pointer;" onClick="cancel_add(\''.$special_id.'\',\'doc\')"></i>
			</td>
			</tr>
			</table>

			<table class="newf" id="add1-'.$special_id.'" style="width:100%;display:none;z-index:1">
			<tr>
			<td style="width:20px;"></td>
			<td>
			<input class="form-control form-control-custom" type="text" id="input1-'.$special_id.'" style="border:1px #ccc solid;border-radius:4px;width:100%;padding-left:5px;font-size:12px;" Placeholder="New File">
			</td>
			<td style="width:50px;text-align:right">
			<i class="fa fa-check" style="cursor:pointer;" onClick="save_rename_file(\''.$special_id.'\',\'doc\',\'2\',\'input1\',\'newfile\')"></i>
			<i class="fa fa-times" style="cursor:pointer;" onClick="cancel_add(\''.$special_id.'\',\'doc\')"></i>
			</td>
			</tr>
			</table>


			<ul class="pevent-res" id="'.$special_id.'"></ul>';
	
		}else{

			// non directory listing

			if(strlen($value->name) > 20){
				
				$substring = substr($value->name,(strlen($value->name)-7),strlen($value->name));
				$file_name = StringLimit($value->name,8,"...".$substring);

			}else{

				$file_name = $value->name;

			}

			$tmp_base = $base."-time";
			$destpath = explode("/",$tmp_base);
			$destpath = $destpath[(count($destpath) - 1)];
			$destpath = str_replace($destpath,null,$tmp_base);

			return '<li title="file : '.$value->name.'" browse="'.$browse.'" color="'.$value->color.'" icon="'.$value->icon.'" doctype="file" class="child-content name-file file-name just-file file-name-'.$special_id.'" onClick="showFile(\''.$special_id.'\',\''.$file.'\')" id="file-'.$special_id.'" name="'.$value->name.'" place="'.$special_id.'" destpath="'.$destpath.'" realpath="'.$base.'" style="margin-left:13px;">
			<input class="form-control form-control-custom" value="'.$base.'" id="val-file-'.$special_id.'" style="display:none;">
			<span id="active-name-'.$special_id.'">
			<span style="margin-left:0px;" class="fno" id="active-name-file-'.$special_id.'">
			<i class="'.$value->icon.'" style="width:14px;position:relative;margin-top:2px;font-size:15px;color:'.$value->color.';position:relative;"></i>
			<span style="margin-left:5px;">'.$file_name.'</span></span>
			</span>
			<table class="fnm" id="go-change-name-'.$special_id.'" style="width:100%;display:none;z-index:1">
			<tr>
			<td style="width:20px;">
			<i class="'.$value->icon.'" style="position:relative;margin-top:2px;font-size:15px;color:'.$value->color.'"></i>
			</td>
			<td>
			<input class="form-control form-control-custom" type="text" id="change-file-name-'.$special_id.'" style="border:1px #ccc solid;border-radius:4px;width:100%;padding-left:5px;" >
			</td>
			<td style="width:50px;text-align:right">
			<i class="fa fa-check" style="cursor:pointer;" onClick="save_rename_file(\''.$special_id.'\',\'file\',\'5\',\'change-file-name\',\'rename\')"></i>
			<i class="fa fa-times" style="cursor:pointer;" onClick="close_rename_file(\''.$special_id.'\',\'file\')"></i>
			</td>
			</tr>
			</table>
			<img src="'.projectUrl().'/assets/img/ovalo.svg" width="15" style="float:right;margin-top:3px;display:none;position:relative;" id="loading-'.$special_id.'">
			</li>

			
			<ul class="pevent-res" id="'.$special_id.'"></ul>';
		}
	}



	// load css file
	$data_value['load css'] = CallCSS([
		
			"assets/css/bootstrap.min.css",
			"assets/js/jquery-ui/jquery-ui.min.css",
			"assets/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css",
			"assets/css/style.css",
			"assets/css/codemirror.css",
			"assets/css/codemirror-colorpicker.css",
			"assets/css/lint.css",
			"assets/css/show-hint.css",
			"assets/css/dialog.css",
			"assets/css/simplescrollbars.css",
			"assets/css/dropzone.css",
			"assets/css/jquery.contextMenu.css",
			"assets/css/pretty-json.css",

		],true);

	
	if(config()->level >= 1) $style_js = "assets/js/style.js";
	
	else $style_js = "assets/js/style-v1.js";
	
	// load javascript file
	$data_value['load js'] = CallJs([

			"assets/js/jquery.js",
			"assets/js/jquery.hotkey.js",
			"assets/js/jquery-ui/jquery-ui.min.js",
			"assets/js/bootstrap.js",
			"assets/js/codemirror.js",
			"assets/js/codemirror-colorpicker.js",
			"assets/js/lint.js",
			"assets/js/htmlmixed.js",
			"assets/js/show-hint.js",
			"assets/js/anywordhint.js",
			"assets/js/html-hint.js",
			"assets/js/css-hint.js",
			"assets/js/javascript-hint.js",
			"assets/js/xml-hint.js",
			"assets/js/sql-hint.js",
			"assets/js/xml.js",
			"assets/js/javascript.js",
			"assets/js/css.js",
			"assets/js/clike.js",
			"assets/js/php.js",
			"assets/js/dialog.js",
			"assets/js/jump-to-line.js",
			"assets/js/search.js",
			"assets/js/searchcursor.js",
			"assets/js/simplescrollbars.js",
			"assets/js/jquery.contextMenu.js",
			"assets/js/jquery.ui.position.js",
			"assets/js/dropzone.js",
			"assets/js/underscore-min.js",
			"assets/js/backbone-min.js",
			"assets/js/pretty-json-min.js",
			$style_js,
			"assets/js/php-parser.js",
			"assets/js/php-lint.js",
			"assets/js/js-lint.js",
			"assets/js/json-lint.js",
			"assets/js/css-bas-lint.js",
			"assets/js/javascript-lint.js",
			"assets/js/json2-lint.js",
			"assets/js/css-lint.js",
			"assets/js/xml-fold.js",
			"assets/js/matchtags.js",
		
		],true);


	// meta config
	$data_value['title'] 		= 'MugenCode - write your code and livetime execute without limit';
	$data_value['favicon'] 		= projectUrl()."/assets/img/iamroot.png";
	$data_value['name']			= "MugenCode";
	$data_value['preview url']	= config()->preview_url;
	$data_value['preview path']	= config()->preview_path;

	if(config()->login_mode == 1){
		$data_value['login-set'] = '<span class="mugen-on" id="login-mod">On</span>';
	}else{
		$data_value['login-set'] = '<span class="mugen-off" id="login-mod">Off</span>';
	}

	if(config()->realtime_mode == 1){
		$data_value['real-set'] = '<i class="fas fa-check" id="autosave" style="color: #18BF5C"></i>';
	}else{
		$data_value['real-set'] = '<i class="fas fa-times" id="autosave" style="color: #BF1414"></i>';
	}

	// manage user

function listUser(){

	$list_user[] = "<table width='100%'>
					<tr class='manage' style='background:#f5f5f5'>
						
						<th>Username</th>
						<th>Path</th>
						<th style='width:110px'></th>
					</tr>";

	$scan = scan_dir(projectDir()."/userconfig/*.json");
	
	if(count($scan)>1){
		
		foreach(scan_dir(projectDir()."/userconfig/*.json") as $key => $value){

			$user_data = fetch_json($value);

			if(isset($user_data->username) and isset($_SESSION['user_login'])) {
			
			 if(($user_data->username !== $_SESSION['user_login']) and (get_file_name($value) !== "config.json")) {
			

				if($user_data->status == 1){

					$bg_button = "btn-default";
					$icon = "fa-lock-open";

				}else{

					$bg_button = "btn-danger";
					$icon = "fa-lock";

				}

				if(config()->level == 2) 
					$buttons = "<td>
							   	<button class='btn ".$bg_button." lock-".$user_data->username."' onClick='user_suspend(\"".$user_data->username."\")'>
							   			<i class='fas ".$icon."'></i>
							   		</button>
							   		<button class='btn btn-default' onClick='edit_user(\"".$user_data->username."\")'><i class='fas fa-cog'></i></button>
							   	</td>";
				else $buttons = null;

				$list_user[] = "<tr class='manage list-".$user_data->username."' data='".$user_data->username."'>
								<td>".$user_data->username."</td>
							   	<td>".$user_data->preview_path."</td>
							   	".$buttons."
							   	</tr>
							   	";
				}
			}

		}

	}else{

		$list_user[] = "<tr class='manage'>
						   	<td colspan='4' style='text-align:center'>User Not Found</td>
						</tr>";

	}

	$list_user[] = "</table>";

	// manage user content
	return implode(null,$list_user);
}

// $data_value = [
	
// 	"load js" 	=> $load_js,
// 	"load css"	=> $load_css,

// ];
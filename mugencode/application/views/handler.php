<?php

/**
  * main program to do whole procces
  * with severral index that have become privions
  * $_POST['nemname'] : this index to state the most recent file name
  * $_POST['path'] 	: find out the location of the file you want to edit
  * $_POST['act'] 	: distinguish the type of proccess that will be carried out
  * $_POST['type'] 	: find out the type of coming that will be edited, file or folder
*/

userspace();

// if you accept the type of proccess that will be carried out
if(isset($_POST['act'])){

	// save new name into $namedata variable
	if(isset($_POST['newname']))
	$namedata = htmlspecialchars($_POST['newname']);

	// universal path dir
	if(isset($_POST['path'])){
	$dir = DirSeparator("/".$_POST['path']."/");
	$newname = explode("/",$dir);
	}else{
	$newname = array();
	}

	// universal path file
	if(isset($_POST['path']))
	$path_for_file = DirSeparator("/".$_POST['path']);

	// get file name
	if(isset($newname[count($newname)-2]))
	$oriname = $newname[count($newname)-2];

	// get placement url
	foreach($newname as $key => $val){

		if($key !== count($newname)-2){
			$names[] = $val;
		}

	}

	// redefined newname of file
	if(isset($names))
	$newname = DirSeparator("/".implode("/", $names)."/");


	// directory secsion
	if($_POST['type'] == "doc"){
	
	/**
	* POST name act
	* to make changes to opration sistem
	* the value used for the change is an integer
	*/

	switch($_POST['act']){

		/**
		* this secsion for export your data project
		* before the data that is export can be downloaded
		* the data will be stored in a temporary folder
		*/
		case 0 :

		// if youu export from home project
		if(trim(str_replace("/",null,$namedata)) == null){

			// name for home project export file
			$namedata = "project";

		}else{

			// name for sub folder or file project export file
			$namedata = $namedata;	

		}

		// identification about last paramater
		$dir = explode("/",$dir);

		if(empty(trim($dir[count($dir)-1]))){

			// set indicator for replace lat paramater 
			$dir[count($dir)-1] = "separ-place";

		}

		// replace last paramater to null value
		$dir = str_replace("/separ-place","",implode("/",$dir));

		// create file or dir as Zip 
		CreateZip(
			$namedata.".zip",
			DirSeparator(project_disk()->realpath.$dir)
		);

		/**
		* to detect whether a file or folder
		* if a file, will be made a folder named 
		* temporary_data at the location where he is
		* Ex : c:/mydata/file.txt
		* result : :/mydata/temporary_data
		*/
		if(is_file(DirSeparator(project_disk()->realpath.$dir))){
			

			// creating temporary_data folder
			if(is_dir(DirSeparator(project_disk()->realpath.$newname."/temporary_data")) == false){
				
				@mkdir(DirSeparator(project_disk()->realpath.$newname."/temporary_data"));

			}

			// the copying proccess
			copy(
			
				DirSeparator(project_disk()->realpath.$newname."/".$namedata.".zip"), 
				DirSeparator(project_disk()->realpath.$newname."/temporary_data/".$namedata.".zip")

			);

			// delete files that have been copied
			if(file_exists(DirSeparator(project_disk()->realpath.$newname."/".$namedata.".zip")) == true)
			unlink(DirSeparator(project_disk()->realpath.$newname."/".$namedata.".zip"));

			// displays the url to download the exported file
			echo DirSeparator(project_disk()->domain.$newname."/temporary_data/".$namedata.".zip");


		}else{
			
			// creating temporary_data folder
			if(is_dir(DirSeparator(project_disk()->realpath.$dir."/temporary_data")) == false){
			
				@mkdir(DirSeparator(project_disk()->realpath.$dir."/temporary_data"));
				
			}

			// the copying proccess
			if(file_exists(DirSeparator(project_disk()->realpath.$dir."/".$namedata.".zip")) == true)
			
			copy(
			
				DirSeparator(project_disk()->realpath.$dir."/".$namedata.".zip"), 
				DirSeparator(project_disk()->realpath.$dir."/temporary_data/".$namedata.".zip")

			);

			// delete files that have been copied
			if(file_exists(DirSeparator(project_disk()->realpath.$dir."/".$namedata.".zip")) == true)
			unlink(DirSeparator(project_disk()->realpath.$dir."/".$namedata.".zip"));

			// displays the url to download the exported file
			echo DirSeparator(project_disk()->domain.$dir."/temporary_data/".$namedata.".zip");

		}

		
		    
		break;


		/**
		* this section is for the upload system
		* if the file uploaded is in the form of a zip file
		* the file will automatically extracted
		* and if the uploaded file is no a zip file and also not a folder
		* the file will be uploaded immediately with the same name
		*/
		case 1 : 

			if(isset($_FILES['file'])){

				// get extention
				$file = $_FILES['file'];
				$ext = get_extention($file['name']);

				// action if not zip upload
				move_uploaded_file(
					$file['tmp_name'],
					DirSeparator(project_disk()->realpath.$dir.$file['name'])
				);
			}

		break;


		// create file
		case 2 : 


			// if the value of file namenot null
			if(!empty(trim($namedata))){

				// path the file who will be made
				$create = DirSeparator(project_disk()->realpath.$dir."/".$namedata);

					// check whether the file is availabe or not
					if(is_file($create) == false){

						// create file
						if(@fopen($create,"w")){

							// displayed special id
							$special_id = clean_url(DirSeparator(project_disk()->realpath.$dir));

							// success response
							echo "<success/>||".$special_id."||";

						}

					}else{

						// failed creating file response
						echo "<failed/>";
						exit;

					}

			}

		break;


		// create directory
		case 3 : 

			// if the value of directory name not null
			if(!empty(trim($namedata))){

				// path the file who will be made
				$create = DirSeparator(project_disk()->realpath.$dir."/".$namedata);

					// createing dir
					if(@mkdir($create)){

						// displayed special id
					    $special_id = clean_url(DirSeparator(project_disk()->realpath.$dir));

					    // succes response
					    echo "<success/>||".$special_id."||";	

					}else{

						// failed creating directory response
						echo "<failed/>";
						exit;

					}

			}

		break;


		// rename directory
		case 4 : 

			// source path of previous file
			$name1 = DirSeparator(project_disk()->realpath.$newname.$oriname);

			// the latest address of the file to be created
			$name2 = DirSeparator(project_disk()->realpath.$newname.$namedata);


			// Knowing the file to be renamed is available or not
			if(is_dir($name2)){

				// already exist
				echo "<failed/>";
				exit;

			}else{			

				// available anda start rename
				rename($name1,$name2);

			}
			
			// varibel to store the latest file location
			$base = DirSeparator(str_replace(project_disk()->realpath,"/",$name2));

			// to access files in the browser that you will edit later
			$browse = DirSeparator(project_disk()->domainname.$base);

			// defines certain ID to be used in javascript event
			$special_id = clean_url(DirSeparator($name2."/"));

			// display the latest data ist after changed
			$value = file_modulator($name2);

			// display all data changes that have been made
			echo listing_template($browse,$special_id,$value,$base,"","dir")
			.'||'.clean_url(DirSeparator($name1."/"))
			.'||'.$namedata.'||';

				
			
		break;


		// delete directory
		case 5 :

			deleteDirectory(DirSeparator(project_disk()->realpath.$dir));

		break;
	}

	}else{

	// file section

		/**
		* POST name act
		* to make changes to opration sistem
		* the value used for the change is an integer
		*/
		switch($_POST['act']){

		// cswitch project

		// setting login mode
		case 0 :

			if(config()->login_mode == 1){

				// change values in the login_mode index
				$json = update_json(["login_mode" => 0],config());
				echo "<off/><load/>";

			}else{

				// change values in the login_mode index
				$json = update_json(["login_mode" => 1],config());
				echo "<on/><load/>";

			}
			
			// write data changes in the config file
			write_file($json,config(3),"w+");
			
		break;

		// setting real time or not realtime mode
		case 1 :

			if(config()->realtime_mode == 1){

				// change values in the realtime_mode index
				$json = update_json(["realtime_mode" => 0],config());
				echo "<off/>";

			}else{

				// change values in the realtime_mode index
				$json = update_json(["realtime_mode" => 1],config());
				echo "<on/>";

			}
			
			// write data changes in the config file
			write_file($json,config(3),"w+");

		break;

		// to change the project addres that you working on
		case 2 :

			// change values in the prewview-path index
			$json = update_json(["preview_path" => htmlspecialchars($_POST['path'])],config());

			// change values in the prewview-url index
			$json = update_json(["preview_url" => htmlspecialchars($_POST['newname'])],fetch_json($json));

			// write data changes in the config file
			write_file($json,config(3),"w+");
			space_creator();

		break;


		// is available file
		case 3 :

			if(is_file(DirSeparator(project_disk()->realpath.$path_for_file)) == false){

				echo "<remove/>";

			}

		break;

		// delete file
		case 4 : 

			unlink(DirSeparator(project_disk()->realpath.$path_for_file));

		break;


		// make file name changes
		case 5 : 

			// location and origanl name
			$name1 = DirSeparator(project_disk()->realpath.$newname.$oriname);

			// the latest data transfer location
			$name2 = DirSeparator(project_disk()->realpath.$newname.$namedata);

			// detecting is the file you are changing its name to a file or folder
			if(is_file($name2)){

				// failed response
				echo "<failed/>";
				exit;

			}else{		

				// success response
				rename($name1,$name2);
				
			}
		
			// varibel to store the latest file location
			$base = DirSeparator(str_replace(project_disk()->realpath,"/",$name2));

			// to access files in the browser that you will edit later
			$browse = DirSeparator(project_disk()->domainname.$base);

			// defines certain ID to be used in javascript event
			$special_id = clean_url(DirSeparator($name2."/"));

			// display the latest data ist after changed
			$value = file_modulator($name2);

			// display file name
			$file = $namedata;

			// display all data changes that have been made
			echo listing_template($browse,$special_id,$value,$base,$file,"file")
			.'||'.clean_url(DirSeparator($name1."/"))
			.'||'.$namedata."||";

		break;

		// temporary store the source code that you have edited
		case 6 :
		
			$_SESSION[$_POST['path']] = $_POST['scripts'];

		break;

		// to delete a session of temporary data as long as you do the editing proccess
		case 7 :
		
			unset($_SESSION[$_POST['path']]);

		break;

		/**
		* this secsion is useful for reseting the password of the system you're using
		* such as changes in username and password
		* with confirmation of your old password, the changes can be made
		*/
		case 8 :

		


			// if you receive changes to the data from the previous password
			if(isset($_POST['old']) and !empty($_POST['old'])){

				// if the previous password you entered is different, it will dispay <noold/> response
				if(encrypt($_POST['old']) !== config()->password) { echo "<noold/>"; exit; }

				// if the newest password you input is different, it will display <nopass/> response
				if(encrypt($_POST['new']) !== encrypt($_POST['renew'])) { echo "<nopass/>"; exit; }

				// change the contents of index password on json file				
				if(isset($auth)){

					$auth = update_json(["password" => encrypt($_POST['new'])],fetch_json($auth));

				}else{

					$auth = update_json(["password" => encrypt($_POST['new'])],config());

				}

			}

			write_file($auth,config(3),"w+");

		break;

		/**
		* This sub sistem is useful for getting information 
		  about files or folders that you want know
		* such as file location, file size, file type and others
		*/
		case 9 :

		// defined path source of file
		$path = DirSeparator(project_disk()->realpath.$path_for_file);

		// get file extention
		$exte = get_extention($path);


		// if the file type is folder
		if(is_dir($path)){

			// information config folder
			$exte = "folder";
			$filetype = "Folder ( Dir )";
			$filesize = convertToReadableSize(CalcDirectorySize($path));
			$comm = 1;

		}else{

		// if the file type is file

			// information config file

			// if the extentionnot found in extention list
			if(!isset(config()->file_extention_config->$exte)) $exte = "other";

			$filetype = "File ( .".get_extention($path)." )";
			$filesize = convertToReadableSize(filesize($path));
			$comm = 0;

		}

		/**
		* to detect the length of characters in a file
		* with maximum characters allowed, namely 20
		* if the character length exceeds 20 then the file 
		  name will chane to a point holder
		* ex: original : mugencode-program.zip
		  result   : mugencode....ram.zip
		 */

		if(strlen(get_file_name($path)) > 20){
				
			$substring = substr(
				get_file_name($path), // get filename
				(strlen(get_file_name($path))-7), // get first midle position
				strlen(get_file_name($path)) // get last midle position
			);

			$file_name = StringLimit(get_file_name($path),8,"...".$substring);

		}else{

			$file_name = get_file_name($path);

		}

		// data grouping into array

		// file name
		$file_create[] = get_file_name($path);

		// file extention
		$file_create[] = $filetype;

		// file location
		$file_create[] = $path_for_file;

		// file size
		$file_create[] = $filesize;

		// date creating file
		$file_create[] = date("F d Y H:i:s.", filectime ($path))." (".timeHistory(filectime ($path)).")";

		// date last modified file
		$file_create[] = date("F d Y H:i:s.", filemtime($path))." (".timeHistory(filemtime($path)).")";

		// date last access file
		$file_create[] = date ("F d Y H:i:s.", fileatime($path))." (".timeHistory(fileatime($path)).")";

		// the appropiate icon for the type of file obtined
		$file_create[] = "<i class='".config()->file_extention_config->$exte->icon."
						 ' style='color:".config()->file_extention_config->$exte->color."'></i> ";

		// holder name result
		$file_create[] = $file_name;

		
		if($comm == 1) {
			
			// response to find out if it is currecntly and ordinary folder or file
			$file_create[] = CountFile($path,"file")." Files";
			$file_create[] = CountFile($path,"dir")." Folders";

		}else{
			$file_create[] = null;
			$file_create[] = null;
		}

		$perm_code = get_file_perm_code($path);
		$perm_asci = get_file_perm_asci_code($perm_code,$path);

		$file_create[] = $perm_code." ( ".$perm_asci." )";

		// a response that produces an integer value
		$file_create[] = $comm;


		
		// return all data that has been obtained and by using a certain delimiter
		echo implode("<|>",$file_create);

		break;



		/**
		* Copy and move data system
		* Copy/Move and paste with new name
		* Copy/Move and paste with old name
		**/

		case 10 :

			// path source copy/move data
			$path = DirSeparator(project_disk()->realpath."/".$path_for_file);

			// path Destination copy/move data
			$dest = DirSeparator(project_disk()->realpath."/".$_POST['dest']);

			// variable success response
			$alert = "<success/>";

			// get real file name
			$source_name = get_file_name($path);

			// detecting last value as slice (/) delimiter from path
			$get_last_val = explode("/",$dest);
			$get_last_val = $get_last_val[count($get_last_val)-1];

			// copy opration file
			if(trim($_POST['opfile']) == "copy"){

				// if the copy target is file
				if(is_file($path)){

					// responsive path
					if(empty($get_last_val) and !strpos($dest,$source_name)){ 

						$dest_c = DirSeparator($dest."/".$source_name);
					
					}else{

						$dest_c = DirSeparator($dest);

					}

					// copying action
					if(copy(
						$path,
						$dest_c
					) !== true) $alert = "<failed/>";


				// if the copy target is file
				}else{

					// responsive path
					if(empty($get_last_val)){ 

						$dest_c = DirSeparator($dest."/".$source_name);
					
					}else{

						$dest_c = DirSeparator($dest);
						
					}

					// Copyin action
					if(CopyDirectory($path,$dest_c) !== true) $alert = "<failed/>";

				}

				$moveresponse =  "";

			// Move opration file
			}elseif(trim($_POST['opfile']) == "move"){

				// if the Move target is file
				if(is_file($path)){
					
					// responsive path
					if(empty($get_last_val) and !strpos($dest,$source_name)){ 

						$dest_c = DirSeparator($dest."/".$source_name);
					
					}else{

						$dest_c = DirSeparator($dest);

					}

					// move action
					if(rename(
						$path,
						$dest_c
					) !== true) $alert = "<failed/>";

				// if the Move target is Dir
				}else{

					// responsive path
					if(empty($get_last_val)){ 

						$dest_c = DirSeparator($dest."/".$source_name);
					
					}else{

						$dest_c = DirSeparator($dest);
						
					}

					// Move action
					if(CopyDirectory($path,$dest_c) !== true){

					$alert = "<failed/>";

					}else deleteDirectory($path);

				}

				// move response
				$moveresponse =  "<remove/>";

			}

			// fetch destination path
			$dir = DirSeparator("/".$_POST['dest']."/");
			$newname1 = explode("/",$dir);

			// get file name
			$oriname = $newname1[count($newname1)-2];

			// get placement url
			foreach($newname1 as $key => $val){

				if($key !== count($newname1)-2){
					$names[] = $val;
				}

			}

			// destinaton name config of destination ID
			$newname1 = DirSeparator("/".implode("/", $names)."/");

			$dest_id = explode("/",DirSeparator($_POST['dest']));
			$dest_id[count($dest_id) - 1] = null;
			$dest_id = DirSeparator(implode("/",$dest_id));

			/**
			* detecting if move to home dir for refresh or reload
			* and will display the true or wrong response
			* if the result is <true/>, the listing box will fully reload
			* and if the result is <false/>, only one folder you have chosen 
			*/

			$home_response = explode("/",$dest_id);

			if((count($home_response) <= 2 ) and empty($home_response[1])) {

				$home = "<true/>";

			}else{

				$home = "<false/>";

			}

			/** 
			* result callback
			* part 1 showing path sorce id
			* part 2 showing path destination id
			* part 3 showing move response if the system doing move opration
			* part 4 detecting if the opration in home dir or navigate to home dir
			* part 5 response if the opration is success
			* using delimiter is ||
			*/

			echo clean_url(DirSeparator(project_disk()->realpath.$newname1))."||".clean_url(DirSeparator(project_disk()->realpath.$dest_id))."||".$moveresponse."||".$home."||".$alert.$dest_c;

		break;


		case 11 :

			if(config()->level == 2 and isset($_POST['user'])){
				
				$path = DirSeparator(projectDir()."/userconfig/".$_POST['user'].".json");

				if(file_exists($path)) {
				
					$user_data = fetch_json($path);

					if($user_data->status == 1){

						$auth = update_json(["status" => 0],$user_data);
						echo "<off/>";

					}else{

						$auth = update_json(["status" => 1],$user_data);
						echo "<on/>";

					}

					write_file($auth,$path,"w+");
				}
			}

		break;

		case 12:

			if(isset($_POST['user']) and config()->level == 2){

				$path = DirSeparator(projectDir()."/userconfig/".$_POST['user'].".json");

				$user_data = fetch_json($path);

				if(file_exists($path)){

					deleteDirectory(project_disk()->realpath.$user_data->preview_path);

					unlink($path);	

					echo "<remove/>";

				}

			}

		break;

		case 13:

			if(isset($_POST['user']) and config()->level == 2){

				$path = DirSeparator(projectDir()."/userconfig/".$_POST['user'].".json");

				if(file_exists($path)) {
				
					$user_data = fetch_json($path);

					$auth = update_json(
						["preview_path" => DirSeparator($_POST['p_path'])],
						$user_data);

					if(file_exists(DirSeparator(project_disk()->realpath.$_POST['p_path'])) == false){

						mkdir(DirSeparator(project_disk()->realpath.$_POST['p_path']));

					}

					$auth = update_json(
						["preview_url" => DirSeparator($_POST['p_url'])],
						fetch_json($auth)
					);

					$deny = explode(",",$_POST['dany_ext']);

					$auth = update_json(
						["wipe_illegal_extention" =>  implode(",",$deny)],
						fetch_json($auth),
						","
					);

					if(!empty(trim($_POST['dany_ext']))){

						$auth = update_json(
							["ini_scan" => 1],
							fetch_json($auth)
						);

					}else{

						$auth = update_json(
							["ini_scan" => 0],
							fetch_json($auth)
						);
					}

					write_file($auth,$path,"w+");
					echo listUser();
				}

			}

		break;

		case 14:

		if(isset($_POST['user']) and !empty($_POST['user'])){

			$path = DirSeparator(projectDir()."/userconfig/".$_POST['user'].".json");

			$copy = copy(DirSeparator(projectDir()."/db-sample.json"),$path);

			if(file_exists($path)) {

				$user_data = fetch_json($path);

					$auth = update_json(
						["preview_path" => DirSeparator($_POST['project_path'])],
						$user_data);

					if(file_exists(DirSeparator(project_disk()->realpath.$_POST['project_path'])) == false){

						mkdir(DirSeparator(project_disk()->realpath.$_POST['project_path']));

					}

					$auth = update_json(
						["preview_url" => DirSeparator($_POST['preview_project_path'])],
						fetch_json($auth)
					);

					$auth = update_json(
						["username" => DirSeparator($_POST['user'])],
						fetch_json($auth)
					);

					$auth = update_json(
						["password" => encrypt($_POST['pass'])],
						fetch_json($auth)
					);

					$deny = explode(",",$_POST['disallow']);

					$auth = update_json(
						["wipe_illegal_extention" =>  implode(",",$deny)],
						fetch_json($auth),
						","
					);

					if(!empty(trim($_POST['disallow']))){

						$auth = update_json(
							["ini_scan" => 1],
							fetch_json($auth)
						);

					}else{

						$auth = update_json(
							["ini_scan" => 0],
							fetch_json($auth)
						);
					}

					write_file($auth,$path,"w+");

					echo listUser();

			}

		}

		break;


		// extract file
		case 15 :

			$path = DirSeparator(project_disk()->realpath."/".$_POST['path']);
			$tmp_path = $path."-tmp";
			$dest = explode("/",$tmp_path);
			$dest = $dest[(count($dest)-1)];
			$dest = str_replace($dest, null,$tmp_path);

			if(ExtractZip($path, $dest)){
        
		       // displayed special id
				$special_id = clean_url(DirSeparator($dest));

				// success response
				echo "<success/>||".$special_id."||";
		        
		    }else{
		        
		        echo "<failed/>";
		        
		    }
		break;

		case 16:

			if(isset($_POST['who'])){
				$path = substr_replace(DirSeparator(project_disk()->realpath),"",-1) ;
			}else{
				$path = DirSeparator(project_disk()->realpath."/".$_POST['path']);
			}

			$real_path = $path;

			$tmp_path = $path."-tmp";
			$dest = explode("/",$tmp_path);
			$dest = $dest[(count($dest)-1)];
			$name = explode("/",$path);
			$name = $name[(count($name)-1)].".zip";
			$real_name = $name;
			$dest = str_replace($dest, null,$tmp_path);
			$name = DirSeparator($dest."/".$name);

			$tmp_name = time();

			if(isset($_POST['who'])){

				$tmp_source_dir =  DirSeparator(project_disk()->realpath);

				$spl = explode("/",$tmp_source_dir);

				foreach($spl as $key => $val){

					if($key < (count($spl) - 2)) {

						$build_path[] = $val;

					}

				}

				$tmp_source_dir = implode("/",$build_path)."/".$tmp_name;

				$tmp_dest_dir = substr_replace(DirSeparator($tmp_source_dir),"",-1);

				$tmp_source_dir = $tmp_dest_dir;

				

			}else{
				
				$tmp_source_dir =  DirSeparator(project_disk()->realpath."/".$tmp_name);
				$tmp_dest_dir = DirSeparator($tmp_source_dir."/".$_POST['path']);

			}

			

			if(is_dir($path)){

				mkdir($tmp_source_dir);

				CopyDirectory(
					$path,
					$tmp_dest_dir
				);


				$path = $tmp_source_dir;
			}

			if(CreateZip($name, $path)){
      			 // displayed special id
				$special_id = clean_url(DirSeparator($dest));

				if(is_dir($path)) deleteDirectory($tmp_source_dir);

				if(isset($_POST['who'])) rename($name,DirSeparator($real_path."/".$real_name));

				// success response
				echo "<success/>||".$special_id."||";
		        
		    }else{
		        
		        echo "<failed/>";
		        
		    }

		break;

		case 17:

			$path = DirSeparator(project_disk()->realpath.$path_for_file);
			$perm_code = get_file_perm_code($path);
			$code = substr($perm_code,1,4);

			$prob["1"] = "1-0-0";
			$prob["2"] = "0-2-0";
			$prob["3"] = "1-2-0";
			$prob["4"] = "0-0-4";
			$prob["5"] = "1-0-4";
			$prob["6"] = "0-2-4";
			$prob["7"] = "1-2-4";

			$split = str_split($code);

			$sum = 0;

			foreach($split as $ke1 => $val1){

				foreach($prob as $key2 => $val2){
					
					if($val1 == $key2){
					
						$perm = explode("-",$val2);
						
						$key = ["a","b","c"];

						$key_num = ["1","2","4"];

						foreach($perm as $key3 => $val3){

							if($val3 !== "0")
							$result[] = $val3.$key[$sum];
							else $result[] = "unceck=".$key_num[$key3].$key[$sum];

						}

						$sum++;

					}

					
				}

			}

			echo implode("-",$result)."/".implode("-",$split)."/".get_file_name($path);
			


		break;

		case 18:
			$path = DirSeparator(project_disk()->realpath.$path_for_file);

			$input = $_POST["attr"];
			$convert = (int) $input;
			$length = strlen($convert);
			$convert = str_pad($convert, 4, '0', STR_PAD_LEFT);
			$command = "chmod(\"".$path."\",".$convert.");";
			eval($command);

		break;

		}
	}
}


// scanning system
BlockFunction();
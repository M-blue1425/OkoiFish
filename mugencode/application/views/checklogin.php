<?php

// Lgin Proccess

if(!isset($_GET['captcha_reload']) and empty($_GET['captcha_reload'])){

	// defined login information
	$user['username'] = config()->username;
	$user['password'] = config()->password;

	if(config()->status == 0) { echo "<failuser/>"; exit; }
	// check user login 
	if($_POST['username'] !== $user['username']) { echo "<failuser/>"; exit; }

	// recover password
	if(is_md5($user['password']) == false){

		$json = update_json(["password" => encrypt($user['password'])],config());
		write_file($json,config(3),"w+");
		$user['password'] = encrypt($user['password']);

	}

	if(encrypt($_POST['password']) !== $user['password']) { echo "<failpass/>"; exit; }

	if($_POST['captcha'] !== $_SESSION['captcha_code']) { echo "<failcapt/>"; exit;}

	$_SESSION['user_login'] = $user['username'];

	echo "<success/>";

}else{

	// Chaptcha Reload
	?>

	<img src="<?php echo create_captcha()->captcha_image_url ?>" width="100%" height="60" style="border-radius: 5px;margin-top: 5px;margin-bottom: 5px;">

<?php } ?>
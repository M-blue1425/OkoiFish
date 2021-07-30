<?php 
	
	// DESTROY AL SESSION
	session_destroy();
	header("location:".HomeUrl()."/login");
	exit;
<?php

/*
 *---------------------------------------------------------------
 * PERMALINK CONFIGURASION
 *---------------------------------------------------------------
 *
 * Handles to set the page access pattern like it does htaccess
 * with configuration like the following
 * ex : "A" => "B"
 * "A" for url used to access
 * "B" for the file address that will be rewritten
 * So if you access it via a web browser, then 
 * the url that is accessed is http://domain.com/"A"
 * so the "B" file will be accessed and open
 */

// page permalink setting
(new system\core\controller)->declarate_space(array(
	
	"rewrite-url" => "path_file_to_rewrite.php",
	// "cusTom" => ["amp" => "index"],

));
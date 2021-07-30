<?php userspace() ?>
<!DOCTYPE html>
<html>
	<head>
		<title>{title}</title>

		<link rel="shortcut icon" href="{favicon}">	
		<meta http-equiv="Pragma" content="no-cache">

		<!-- STYLESHEET -->
		{load css}


		<!-- JAVASCRIPT -->
		{load js}
		

	<style>

		.CodeMirror-linenumber{min-width: 25px}
		.fa.icon-pop{font-size: 13px;font-family: sans-serif;color:#666;}
		.CodeMirror{float:left;width: 100%;height: 1000px;}
		input{color:#434343;}
		.form-control-custom{height:23px;}
		.manage td{padding: 8px;}	
		.manage:hover{background: #f6f6f6}	
		.manage th{	padding: 8px;}
		.manage { border-bottom:1px #ddd solid;}
		.dropzone .dz-preview .dz-details{
			border:1px #ddd solid;
			border-radius: 10px;
			padding:5px;
			background: #f7f7f7;
			width: 120px;
			height:120px;
		}
		.dz-filename{
			margin-top :60px;
		}
		.dz-upload{
			color:#fff;
		}
		.dropzone .dz-preview .dz-details .dz-size{
			width: 100%;
			font-size:11px;
			margin-top: 10px;
			font-weight:600;
		}

		.percentage-progress{
			position: relative;
			margin-top:-60px;
			z-index:999;
			font-size:13px;
			text-align: center;
		}
	</style>

	</head>
<body>


<div id="preload" class="preload-bg"></div>

<!-- container -->
<div class="code-container">

	<!-- navbar menu tool -->
	<?php require_once(projectDir()."/content/navigation-bar.php") ?>	
	<!-- / navbar menu tool -->



	<!-- show lsting file -->
	<span id="listing-space"></span>
	<!-- /show lsting file -->

	<!-- editor area -->
	<div class="editor-area" style="top:50px">

	<!-- panel tabs -->
	<div class="editor-area-heading">
		<ul class="active-container">
			<span id="file-active"></span>
		</ul>
	</div>
	<!-- / panel tabs -->


	<!-- textarea -->
	<span class="textarea">
		<span id="script-loader">
			<div class="texteditor">
				<textarea id="code" name="code" style="display: none;"></textarea>
			</div>

		<script>

		/**
		* CODEMIRROR PLUGIN
		* Type     : Plugin
		* Base 	   : Code Mirror Plugin & Jquery
		* function : TextArea EDitor
		*/

		 var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
	        lineNumbers: true,
	        matchBrackets: true,
	        mode: "text/javascript",
	        indentUnit: 4,
	        indentWithTabs: true,
	        lint: true,
	        scrollbarStyle: "simple",
	      });

		</script>

		</span>

	<!-- result realtime -->
	<?php require_once(projectDir()."/content/mini-browser.php") ?>	
	<!-- / result realtime -->

	</span>

	<!-- / textarea -->

	</div>
	<!-- / editor area -->

</div>
<!-- / container -->


<!-- Modal -->
<div id="modal-bg" onClick="close_modal()" class="modal-bg"></div>
<div id="modal-bg1" onClick="close_modal()" class="modal-bg1"></div>

<div class="panel panel-default modal-upload">

	<?php require_once(projectDir()."/content/modal-data.php") ?>
	
</div>
<!-- / Modal -->


<input type="file" name="file" id="filedrop" style="display: none;">
<div id="dir-data" style="display: none;"></div>
<div id="response-data" style="display: none;"></div>
<div id="realtime" style="display: none;"><?=config()->realtime_mode?></div>
<div id="active-data" style="display: none;"></div>
<div id="raw-data" style="display: none;"></div>
<div id="raw-data-id" style="display: none;"></div>
<input id="log-copy" style="display: none;">
<input id="log-move" style="display: none;">
<input id="log-active" style="display: none;">
<input id="log-dest" style="display: none;">
<input id="active-select" style="display:none;">
<input id="toolbox-log" value="0" style="display:none;">
<span class="force-download"></span>
<script>

$(document).ready(function(){

	pageready();

	setInterval(function(){
		
		$.ajax({

			url:"handler",
			
			success:function(event){
				
				if(event.indexOf("<logout/>") !== -1){

					window.location = "login";

				}
			}
		});

	},20000);

});

$(function(){


	$(document).bind('keydown', 'ctrl+s', function assets() {
		save_project();

		console.log("ctrl + s pressed");
		return false;

	});

	$(document).bind('keydown', 'ctrl+f', function assets() {
		editor.execCommand("find");

		return false;

	});

	$(document).bind('keydown', 'ctrl+r', function assets() {
		$("#listing-space").load("listing?session="+rands());
		load_page_result(1);

		return false;

	});

	$(document).bind('keydown', 'ctrl+h', function assets() {
		editor.execCommand("replace");

		return false;

	});


	$(document).bind('keydown', 'ctrl+q', function assets() {

		var ext_name = $("#active-data").html();
		var get_class = ext_name+"-tabs";
		var get_path = $("."+get_class).attr("place");

		$("#flags-"+ext_name).click();

		console.log("ctrl + q pressed");

		return false;
	});

});

function toolbar(a){
		switch(a){
			case "newfile":
				var object_data = $(".left-box");
		    	var special_id = object_data.attr("place");

		    	$(".newf").hide();
		    	$("#add1-"+object_data.attr("place")).show();
		    	$("#input1-"+object_data.attr("place")).val("");
		    	$("#input1-"+object_data.attr("place")).focus();
		    	close_rename_file(special_id,"dir");
		    	close_rename_file(special_id,"file");
		    	$(".fnm").hide();
		    	$(".fno").show();

			break;

			case "newdir":
				var object_data = $(".left-box");
            	var special_id = object_data.attr("place");
            	$('.listing-box-body').animate({scrollTop : 0});
            	$(".newf").hide();
            	$("#add-"+object_data.attr("place")).show();
            	$("#input-"+object_data.attr("place")).val("");
            	$("#input-"+object_data.attr("place")).focus();
            	close_rename_file(special_id,"dir");
            	close_rename_file(special_id,"file");
            	$(".fnm").hide();
            	$(".fno").show();
			break;

			case "save":

				save_project();

			break;

			case "close":

				var ext_name = $("#active-data").html();
				var get_class = ext_name+"-tabs";
				var get_path = $("."+get_class).attr("place");

				$("#flags-"+ext_name).click();

			break;

			case "close-all":

				var data = $("#dir-data").html();
					data = data.split("/");

				for(var i = 0; i < (data.length - 2); i++){
					var ex = data[i].split("-");
					$("#flags-"+ex[0]).click();
				}

				var ex = data[(data.length - 2)];
				    ex = ex.split("-");
				setTimeout(function(){$("#flags-"+ex[0]).click();},300);
				

			break;

			case "import":
				var object_data = $(".left-box");
            	var special_id = object_data.attr("place");
            	
            	import_project(object_data,special_id,2);
			break;

			case "export":
				var object_data = $(".left-box");

            	var special_id = object_data.attr("place");
            	$.ajax({
            		type : "POST",
            		url  : "handler?session="+rands(),
            		data : {
            			path : object_data.attr("realpath"),
            			act  : 16,
            			type : "file",
            			newname : object_data.attr("name"),
            			who : "main"
            		},
            		success : function(event){

            			$("#listing-space").load("listing?session="+rands());

            		},
            		error : function(){
            			alert("error : file isn't valid");
            		}
            	});
			break;

			case "search":

				editor.execCommand("find");

			break;

			case "replace":

				editor.execCommand("replace");

			break;

			case "browser":
				panel_result('window');

			break;

			case "preview":
				load_page_result(1);
			break;

			case "refresh":
				$("#listing-space").load("listing?session="+rands());
				load_page_result(1);
			break;

			case "change-pass":
				import_project('','',4);
			break;
			case "logout":
				window.location='<?php echo HomeUrl()?>/logout';
			break;

			case "manage-user":
				import_project('','',7);
			break;

			case "switch":
				import_project('','',1);
			break;

			case "about":
				import_project('','',10);
			break;
			case "log":
				import_project('','',11);
			break;

		}

		$("#modal-bg1").hide();
		$(".toolbar-box").hide();
		$("#toolbox-log").val("0");
		$(".toolbar-title").removeClass("go_click");
	}


</script>

</body>
</html>
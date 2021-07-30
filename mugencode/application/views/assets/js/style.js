/**
* PAGE CONTROLLER SYSTEM
* Type     : PRIMARY
* Base 	   : Jquery
* function : CONTROL MANAGEMENT SYSTEM
*/



/** RAND **/
function rands(){
	return Math.random();
}
/** END RANDS **/

function window_open(){

	window.open($("#iframe").attr("src"), '_blank');

}


/** INTERVAL DELAY **/
var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();
/** END INTERVAL DELAY **/

/** PAGE READY **/
function pageready(){

	$("#preload").fadeOut();
	$("#listing-space").load("listing?session="+rands());
	onready();
	load_page_result(1);

	$(".up-click").click(function(){
		$(".dropzone").click();
	});

}
/** END PAGE READY **/

/** ONLOAD ACTION **/
function onready(){

	/** SET LISTING DATA SIZE **/
	$(".left-box").css({
		"width" : "20%",
		"height" : $(window).height()-40+"px",
		"top"   : "40px",
	});
	/** END SET LISTING DATA SIZE **/

	/** SET CODEMIRROR BOX SIZE **/
	$(".CodeMirror").css({
		"width" : "100%",
		"height" : $(window).height()-85+"px",
	});

	/** SET PANEL BOX RESUT SIZE **/
	$("#result-box").animate({
		"height" : $(window).height()+"px",
	});

	$("#result-box1").animate({
		"height" : $(window).height()+"px",
	});
	/** END SET PANEL BOX RESUT SIZE **/

	/** SET INNER BOX RESUT SIZE **/
	$("#box-area-result").animate({
		"height" : $(window).height()-160+"px",
	});
	/** END SET INNER BOX RESUT SIZE **/

	/**
	* CODEMIRROR PLUGIN
	* Type     : Plugin
	* Base 	   : Code Mirror Plugin & Jquery
	* function : OnKeyup
	*/

	editor.on('change', function () {

		var dom_stats = $("#realtime").html();
		
		var ext_data = $("#active-data").html();

		if(dom_stats.indexOf("1") !== -1){

			$("#flags-"+ext_data).removeClass("fa-circle");
			$("#flags-"+ext_data).addClass("fa-times");

	        html = editor.getValue();
	         delay(function(){   
	        	save_script(html);
	        	$("#flags-"+ext_data).attr("modify","false");
	        	}, 500 );   
	    }else{
	    	
	    	$("#flags-"+ext_data).addClass("fa-circle");
			$("#flags-"+ext_data).removeClass("fa-times");
			$("#flags-"+ext_data).attr("modify","true");
			$(".tabs-"+$("body").attr("active-id")).removeClass("active-file-write");
			$(".tabs-"+$("body").attr("active-id")).addClass("active-file-write-not-saved");
			$.ajax({
			type : "POST",
			url  : "handler?session="+rands(),
			data : {
				path : $("body").attr("active-id"),
				act  : 6,
				newname : "",
				type : "file",
				scripts : editor.getValue()
			},
			success : function (event){}
		});

	    }
    });

    $(".CodeMirror-scrollbar-filler").hide();
}

/** END ONLOAD ACTION **/

function save_project(){
	save_script();
	var ext_data = $("#active-data").html();
	$("#flags-"+ext_data).removeClass("fa-circle");
	$("#flags-"+ext_data).addClass("fa-times");
	$("#flags-"+ext_data).attr("modify","false");
	$(".tabs-"+$("body").attr("active-id")).removeClass("active-file-write-not-saved");
	$(".tabs-"+$("body").attr("active-id")).addClass("active-file-write");
}

function show_set_menu(){
	$(".mugen-set").show();
	$("#modal-bg").fadeIn();
}

function set_setting(option,id){
	$.ajax({
		type : "POST",
		url  : "handler?session="+rands(),
		data : {
			path : "",
			act  : option,
			newname : "",
			type : "file",
		},
		success : function (event){

			if(event.indexOf("<on/>") !== -1){

				$("#autosave").css({"color":"#18BF5C"});
				$("#autosave").addClass("fa-check");
				$("#autosave").removeClass("fa-times");

				$("#"+id+"-1").show();
				
				if(option == 1){
					$("#realtime").html("1");
					$("#save-project").hide();
				}

				if(event.indexOf("<load/>") !== -1) window.location = "";
				
			}else{

				$("#autosave").css({"color":"#BF1414"});
				$("#autosave").addClass("fa-times");
				$("#autosave").removeClass("fa-check");

				$("#"+id+"-1").hide();

				if(option == 1){
					$("#realtime").html("0");
					$("#save-project").show();
				}
			}
	
		}
	});
}

function save_script(html = editor.getValue()){

	$.ajax({
		 type : "POST",
		 url  : "save_change?session="+rands(),
		 data : {
		 	script 	: html,
		 	path	: $("body").attr("path"), // path of file or dir
		 	url		: $("#url-load").val(),
		 	spec_id : $("body").attr("active-id"),
		 },
		 beforeSend : function(){
		 	$("#load1").show();
		 	$("#load2").hide();
		 },
		 success : function(event){
		        			
		 	$("#load1").hide();
		 	$("#load2").show();

		 	$("#box-area-result").html(event);
		 }
	});     
}

/** PRETTY JSON **/
function pretty_json(json){

	 var source = atob(json);

        var el = {
            input:source,
            result: $('#result-json')
        };      
        
            var json = el.input;
            var o;
            try{ o = JSON.parse(json); }
            catch(e){ 
                return;
            }

            var node = new PrettyJSON.view.Node({ 
                el:el.result, 
                data:o
            });
}
/** END PRETTY JSON **/

/** PANEL BOX RESULT PREVIEW **/
function panel_result($data){
	switch($data){

		/** WINDOW MODE **/
		case "window":
			
			$("#result-box1").css({
				"width" : "40%",
				"left" : "60%",
			});

			$("#result-box").animate({
				"left" : "60%",
			});

			$("#result-box").css({
				"width" : "40%",
			});


			$(".panel-result").css({
				"width" : "30.3%",
			});

			$(".panel-result").animate({
				"left"	: "69%",
			});

			$(".CodeMirror").css({
				"width" : "60%",
				"height" : $(window).height()-85+"px",
			});

			

		break;
		/** END WINDOW MODE **/

		/** WINDOW MODE **/
		case "window-onload":
			
			$("#result-box1").css({
				"width" : "40%",
				"left" : "60%",
			});

			$("#result-box").css({
				"left" : "60%",
			});

			$("#result-box").css({
				"width" : "40%",
			});


			$(".panel-result").css({
				"width" : "30.3%",
			});

			$(".panel-result").css({
				"left"	: "69%",
			});

			$(".CodeMirror").css({
				"width" : "60%",
				"height" : $(window).height()-85+"px",
			});

			

		break;
		/** END WINDOW MODE **/

		/** FULL MODE **/
		case "full":
			$("#result-box").css({
				"width" : "100%",
				"left" : "0%",
			});

			$(".panel-result").css({
				"width" : "78%",
				"left"	: "21%",
			});

			$(".CodeMirror").css({
				"width" : "100%",
				"height" : $(window).height()-85+"px",
			});
		break;
		/** END FULL MODE **/

		/** MINIMIZE MODE **/
		case "hide":

			$("#result-box1").css({
				"left" : "100%",
			});
			$("#result-box").css({
				"left" : "100%",
			});

			$(".panel-result").css({
				"width" : "100%",
			});

			$(".panel-result").animate({
				"left"	: "110%",
			});

			$(".CodeMirror").css({
				"width" : "100%",
				"height" : $(window).height()-85+"px",
			});
		break;
		/** END MINIMIZE MODE **/
	}
}
/** END PANEL BOX RESULT PREVIEW **/


/**
* File Reader To Text Editor
* Type     : Normal Function
* Base 	   : Jquery
* function : DIrectory Control
*/

function showDir(a,b=""){
	
	/** CHECK DIRECTORY IS OPEN  **/
	if(($(".file-name-"+a).attr("status") == "hide") || (b !== "")) {

	var special_id = a;

	// True Statement
	$.ajax({
		type : "POST",
		url  : "listing?session="+rands(),
		data : {
			path:$("#val-dir-"+a).val(),
		},
        beforeSend : function(){
        	$("#loading-"+special_id).show();
        },
        success : function(event){
        	$("#loading-"+special_id).hide();

			// if in root dir
			if($("#dir-"+a).attr("root") == "true") $("#listing-space").load("listing?session="+rands());;

			// action
			$("#icn-"+a).removeClass("fa-caret-right");
			$("#icn-"+a).addClass("fa-caret-down");
			$("#"+a).html(event);
			$(".file-name-"+a).attr("status","show");
			$(".icon-"+a).removeClass("fa-folder");
			$(".icon-"+a).addClass("fa-folder-open");
			
		}
	});
	
	}else{
	// False Statement

			$("#icn-"+a).removeClass("fa-caret-down");
			$("#icn-"+a).addClass("fa-caret-right");
			$("#"+a).html("");
			$(".file-name-"+a).attr("status","hide");
			$(".icon-"+a).removeClass("fa-folder-open");
			$(".icon-"+a).addClass("fa-folder");
	}
	/** END CHECK DIRECTORY IS OPEN  **/
}


/**
* File Reader To Text Editor
* Type     : Normal Function
* Base 	   : Jquery
* function : File Control
*/

function showFile(path,nama = null){

		/** GET EXTENTION FILE **/
		var extension = $("#file-"+path).attr("name");
		var split_ext = extension.split(".");
		var ext_data  = split_ext[split_ext.length - 1];
		/** END GET EXTENTION FILE **/
		
		var special_id = path;

		$.ajax({
			type : "POST",
			url  : "open_file?session="+rands(),
			data : {
				path 	 : $("#file-"+path).attr("realpath"), // path of file or dir
				url		 : $("#url-load").val(),
				spec_id  : $("#file-"+path).attr("place"),
			},
            beforeSend : function(){
            	$("#loading-"+special_id).show();
            },
            success : function(event){
            	$("#loading-"+special_id).hide();

			/** TABS STYLE **/
			var color = $("#file-"+path).attr("color");
			var icon  = $("#file-"+path).attr("icon");
			var file  = $("#file-"+path).attr("name");
			var browse = $("#file-"+path).attr("browse");
			var color = $("#file-"+path).attr("color");
			var icon = $("#file-"+path).attr("icon");
			var name = $("#file-"+path).attr("name");
			var realpath = $("#file-"+path).attr("realpath");

			if(event.indexOf("<nosave/>") !== -1){

				var stats_icon = "fa-circle";
				var modify = "true";
				var write_status = "active-file-write-not-saved";

			}else{

				var stats_icon = "fa-times";
				var modify = "false";
				var write_status = "active-file-write";

			}

			if(file !== "undefined"){

			if(file.length > 20){

				var file_compress = file.substring(0,8)+"..."+file.substring((file.length - 7),file.length);

			}else{

				var file_compress = file;

			}

			

			var html = '<li title="file : '+file+'" browse="'+browse+'" color="'+color+'" icon="'+icon+'" id="file-'+path+'" name="'+name+'" place="'+path+'" realpath="'+realpath+'" style="cursor:pointer;" keyid="'+path+'" data="true" class="'+ext_data+'-tabs active-file-write optional-tab tabs-'+path+'">';
				html += '<i  onClick="return showFile(\''+path+'\',\''+file+'\')" class="'+icon+'" style="color:'+color+';font-size: 15px;"></i>';
				html += '<span class="tab-data" onClick="return showFile(\''+path+'\',\''+file+'\')" style="font-size: 11.5px;margin-left:5px">'+file_compress+'</span>';
				html += '<i class="fas '+stats_icon+'" modify="'+modify+'" id="flags-'+ext_data+'" onClick="close_tabs(\''+path+'\',\''+ext_data+'\')" style="float:right;margin-left: 20px;font-size:11px;top:3px;position:relative"></i>';
				html += '</li>';

			$("#active-data").html(ext_data);
			$("body").attr("path",$("#file-"+path).attr("realpath"));
			$("body").attr("active-id",$("#file-"+path).attr("place"));

			if($("."+ext_data+"-tabs").attr("data") == "true"){
				$("."+ext_data+"-tabs").replaceWith(html);
			}else{
				$("#file-active").append(html);
			}

			$(".active-file-write").addClass("active-file");
			
			$(".active-file-write-not-saved").removeClass("active-file-write-not-saved");
			$(".active-file-write-not-saved").removeClass("active-file-write");

			$(".active-file-write").removeClass("active-file-write-not-saved");
			$(".active-file-write").removeClass("active-file-write");


			$(".tabs-"+$("body").attr("active-id")).addClass(write_status);

			$("#script-loader").html(event);
			onready();

			var base_data = $("#dir-data").html();
			if(base_data.indexOf(ext_data+'-tabs') == -1){
				$("#dir-data").append(ext_data+'-tabs/');
			}

			var ext = [".jpg",".jpeg",".png",".gif","mp4","mp3","zip"];			

			$(".CodeMirror-scrollbar-filler").remove();

			/** END TABS STYLE **/
			}
			}
		});
}

/** CHEKING ACTIVE TABS **/
function is_only($data,$id){
	$.ajax({
		type : "POST",
		url  : "handler?session="+rands(),
		async : true,
		data : {
			path : $data,
			act  : 3,
			newname : "",
			type : "file",
		},
		success : function (event){
			
			if(event.indexOf("<remove/>") !== -1){
				
				var base_data = $("#dir-data").html();

					if(base_data.indexOf($id) !== -1){
						$("#dir-data").html(base_data.replace($id+'/',''));
						$("."+$id).remove();
					}
					
				var base_data = $("#dir-data").html();
				
				if(base_data == ""){
					$("#script-loader").load("open_file?session="+rands());
				}
			}

		$(".undefined-tabs").remove();

		}
	});
}
/** END CHEKING ACTIVE TABS **/


/** ACTION HANDLER **/
function save_rename_file(id,type_handler,action,active_class,type_action){

	/** GET EXTENTION FILE **/
	if(type_handler == "file"){
	var extension = $("#file-"+id).attr("name");
	var split_ext = extension.split(".");
	var ext_data  = split_ext[split_ext.length - 1];
	var paths = $("#file-"+id).attr("realpath");
	}else{
	var paths = $("#dir-"+id).attr("realpath");
	}
	/** END GET EXTENTION FILE **/

	var special_id = id;

	$.ajax({
		type : "POST",
		url  : "handler?session="+rands(),
		data : {
			path    : paths,
			act     : action,
			newname : $("#"+active_class+"-"+id).val(),
			type    : type_handler,
		},
		beforeSend : function(){
			$("#change-file-name-"+special_id).attr("disabled","true");
			$("#input-"+special_id).attr("disabled","true");
			$("#input1-"+special_id).attr("disabled","true");
		},
        success : function(event){

        	$("#change-file-name-"+special_id).removeAttr("disabled");
			$("#input-"+special_id).removeAttr("disabled");
			$("#input1-"+special_id).removeAttr("disabled");

			var conts = event.split("||");

			// rename action
			if(type_action == "rename"){
			var conts = event.split("||");

			if(type_handler == "file"){
				if(event.indexOf("<failed/>") !== -1){
					alert("already exist");
					close_rename_file(id,"doc");
					cancel_add(id,"doc");
		    	}else{
				$("#file-"+id).replaceWith(conts[0]);
		    	showFile(conts[1],conts[2]);
		    	var data_list = $("#dir-data").html();
				var split_list = data_list.split("/");
				for(var i = 0 ; i < split_list.length - 1; i++){
					is_only($("."+split_list[i]).attr("realpath"),split_list[i]);
				}
		    	}

		    }else{

		    	
		    	var data_list = $("#dir-data").html();
				var split_list = data_list.split("/");
				for(var i = 0 ; i < split_list.length - 1; i++){
					is_only($("."+split_list[i]).attr("realpath"),split_list[i]);
				}

				if(event.indexOf("<failed/>") !== -1){
					alert("already exist");
					close_rename_file(id,"doc");
					cancel_add(id,"doc");
		    	}else{
		    	$("#"+id).remove();
		    	$("#dir-"+id).replaceWith(conts[0]);
		    	showDir(conts[1]);
		    	}
		    }

			$("."+ext_data+"-tabs").remove();
			}

			// new dir action
			if(type_action == "newdir" || type_action == "newfile"){
				if(event.indexOf("<failed/>") !== -1){
					alert("already exist");
					close_rename_file(id,"doc");
					cancel_add(id,"doc");
		    	}else{
					showDir(conts[1],"true");
					cancel_add(conts[1],"doc");
				}
			}

		}
	});
}
/** END ACTION HANDLER **/

function change_login(a){

	$.ajax({

		type : "POST",
		url  : "handler?session="+rands(),
		data : $(a).serialize(),
		beforeSend : function(){
			$(".use-change").html("Saving ...");
		},
		success : function(event){
			$(".use-change").html("Save Changes");

			if(event.indexOf("<nouser/>") !== -1){
				$(".alert-change").show();
				$(".alert-change").html("Username Do Not Match");

			}else if(event.indexOf("<noold/>") !== -1){
				$(".alert-change").show();
				$(".alert-change").html("Invalid Old Password");

			}else if(event.indexOf("<nopass/>") !== -1){
				$(".alert-change").show();
				$(".alert-change").html("Password Do Not match");

			}else if(event.indexOf("<noconf/>") !== -1){
				$(".alert-change").show();
				$(".alert-change").html("Invalid Password Confirmation");

			}else{

				close_modal();
				$(".alert-change").hide();
				$(".change-set").val('');

			}
		}
	});

	return false;
}

/** CREATE NEW PROJECT **/
function create_new_project(a){

	$.ajax({

		type : "POST",
		url  : "handler?session="+rands(),
		data : {
			path : $("#projectname1").val(),
			act  : 2,
			newname : $("#projectname2").val(),
			type : "file",
		},
		beforeSend : function(){
			$("#projectname1").attr("disabled","true");
			$("#projectname2").attr("disabled","true");
			$("#loading-create0").hide();
			$("#loading-create1").show();
		},
		success : function(event){
			$("#listing-space").load("listing?session="+rands());
			$("#projectname1").removeAttr("disabled");
			$("#projectname2").removeAttr("disabled");
			$("#loading-create0").show();
			$("#loading-create1").hide();
			$("#url-load").val($("#projectname2").val());
			$(".optional-tab").remove();
			$("#script-loader").load("open_file?session="+rands());
			load_page_result(1);
			close_modal();

		}

	});

	return false;

}
/** END CREATE NEW PROJECT **/

/** IMPORT PROJECT **/
function import_project(object = "",id = "",act){

	if(object !== ""){
	var object_data = object;
	var special_id = id;
	}else{
	var object_data = $("div[root]");
	var special_id = $("div[root]").attr("place");
	}

		switch(act){
		case 1:
		$(".fly-box").hide();
		$(".fly-box1").show();
		$(".fly-box2").hide();
		$(".fly-box3").hide();
		$(".fly-box4").hide();
		$(".fly-box5").hide();
		$(".fly-box6").hide();
		$(".fly-box7").hide();
		$(".fly-box8").hide();
		$(".fly-box9").hide();
		$(".fly-box10").hide();
		$(".fly-box11").hide();
		break;

		case 2:
		$(".fly-box").show();
		$(".fly-box1").hide();
		$(".fly-box2").hide();
		$(".fly-box3").hide();
		$(".fly-box4").hide();
		$(".fly-box5").hide();
		$(".fly-box6").hide();
		$(".fly-box7").hide();
		$(".up-margin").show();
		$(".fly-box8").hide();
		$(".fly-box9").hide();
		$(".fly-box10").hide();
		$(".fly-box11").hide();
		break;

		case 3:
		$(".fly-box").hide();
		$(".fly-box1").hide();
		$(".fly-box2").hide();
		$(".fly-box3").show();
		$(".fly-box4").hide();
		$(".fly-box5").hide();
		$(".fly-box6").hide();
		$(".fly-box7").hide();
		$(".fly-box8").hide();
		$(".fly-box9").hide();
		$(".fly-box10").hide();
		$(".fly-box11").hide();
		break;

		case 4:
		$(".fly-box").hide();
		$(".fly-box1").hide();
		$(".fly-box2").hide();
		$(".fly-box3").hide();
		$(".fly-box4").show();
		$(".fly-box5").hide();
		$(".fly-box6").hide();
		$(".mugen-set").fadeOut();
		$(".fly-box7").hide();
		$(".fly-box8").hide();
		$(".fly-box9").hide();
		$(".fly-box10").hide();
		$(".fly-box11").hide();
		break;

		case 5:
		$(".fly-box").hide();
		$(".fly-box1").hide();
		$(".fly-box2").hide();
		$(".fly-box3").hide();
		$(".fly-box4").hide();
		$(".fly-box5").show();
		$(".fly-box6").hide();
		$(".mugen-set").fadeOut();
		$(".fly-box7").hide();
		$(".fly-box8").hide();
		$(".fly-box9").hide();
		$(".fly-box10").hide();
		$(".fly-box11").hide();
		break;

		case 7:
		$(".fly-box").hide();
		$(".fly-box1").hide();
		$(".fly-box2").hide();
		$(".fly-box3").hide();
		$(".fly-box4").hide();
		$(".fly-box5").hide();
		$(".fly-box6").hide();
		$(".mugen-set").fadeOut();
		$(".fly-box7").show();
		$(".fly-box8").hide();
		$(".fly-box9").hide();
		$(".fly-box10").hide();
		$(".fly-box11").hide();

		break;

		case 8:
		$(".fly-box").hide();
		$(".fly-box1").hide();
		$(".fly-box2").hide();
		$(".fly-box3").hide();
		$(".fly-box4").hide();
		$(".fly-box5").hide();
		$(".fly-box6").hide();
		$(".mugen-set").fadeOut();
		$(".fly-box7").hide();
		$(".fly-box8").show();
		$(".fly-box9").hide();
		$(".fly-box10").hide();
		$(".fly-box11").hide();
		break;

		case 9:
		$(".fly-box").hide();
		$(".fly-box1").hide();
		$(".fly-box2").hide();
		$(".fly-box3").hide();
		$(".fly-box4").hide();
		$(".fly-box5").hide();
		$(".fly-box6").hide();
		$(".mugen-set").fadeOut();
		$(".fly-box7").hide();
		$(".fly-box8").hide();
		$(".fly-box9").show();
		$(".fly-box10").hide();
		$(".fly-box11").hide();
		break;

		case 10:
		$(".fly-box").hide();
		$(".fly-box1").hide();
		$(".fly-box2").hide();
		$(".fly-box3").hide();
		$(".fly-box4").hide();
		$(".fly-box5").hide();
		$(".fly-box6").hide();
		$(".mugen-set").fadeOut();
		$(".fly-box7").hide();
		$(".fly-box8").hide();
		$(".fly-box9").hide();
		$(".fly-box10").show();
		$(".fly-box11").hide();
		break;

		case 11:
		$(".fly-box").hide();
		$(".fly-box1").hide();
		$(".fly-box2").hide();
		$(".fly-box3").hide();
		$(".fly-box4").hide();
		$(".fly-box5").hide();
		$(".fly-box6").hide();
		$(".mugen-set").fadeOut();
		$(".fly-box7").hide();
		$(".fly-box8").hide();
		$(".fly-box9").hide();
		$(".fly-box10").hide();
		$(".fly-box11").show();
		break;
	}

      $("#path-up").val(object_data.attr("realpath"));
      $("#id-up").val(special_id);
      $("#name-up").val(object_data.attr("name"));
      $(".dz-message").remove();
      $("#modal-bg").fadeIn();
      $(".modal-upload").show();
}
/** END IMPORT PROJECT **/

/** EXPORT PROJECT **/
function export_project(){

	var object_data = $("div[root]");
	var special_id = $("div[root]").attr("place");

    var special_id = object_data.attr("place");
    $.ajax({
    	type : "POST",
    	url  : "handler?session="+rands(),
    	data : {
    		path : object_data.attr("realpath"),
    		act  : 0,
    		type : "doc",
    		newname : object_data.attr("name"),
    	},
    	beforeSend : function(){
    		$("#data-export").show();
    		$("#success-export").hide();
    		$("#loading-"+special_id).show();
    	},
    	success : function(event){
    		$("#data-export").hide();
    		$("#success-export").css({"display":""});
    		$("#loading-"+special_id).hide();
    		window.location = event;
    	},
		error : function(){
			alert("error : file isn't valid");
			$("#loading-"+special_id).hide();
		}
    });
}
/** END EXPORT PROJECT **/

/** CLOSE ACTION RENAME **/
function close_rename_file(id,type){
	$(".fnm").hide();
    $(".fno").show();
    $("#file-"+id).attr("onClick",$("#file-"+id).attr("onClicks"));
    $("#dir-"+id).attr("onClick",$("#dir-"+id).attr("onClicks"));
    if(type == "dir"){
    	$("#file-"+id).addClass("dir-name");
    }else{
    	$("#file-"+id).addClass("name-file");
    }
}
/** CLOSE ACTION RENAME **/

/** CLOSE ADD NEW FOLDER / FILE **/
function cancel_add($id,$type){
	$("#add-"+$id).hide();
	$("#input-"+$id).val('');
	$("#add1-"+$id).hide();
	$("#input1-"+$id).val('');
}
/** END CLOSE ADD NEW FOLDER / FILE **/

/** RUN BROWSER **/
function load_page_result(action = 0){
		
		$.ajax({
	    	
	    	type : "POST",
	    	url  : "save_change?session="+rands(),
	    	data : { // path of file or dir
	    	url		: $("#url-load").val(),

	       },
	       beforeSend : function(){
	       	$("#load1").show();
	       	$("#load2").hide();
	       },
	       success : function(event){
	       	
	       	$("#load1").hide();
	       	$("#load2").show();

		    $("#box-area-result").html(event);

		 if(action == 0){

		 	panel_result("window");

		 }else{

			panel_result("window-onload");

		 }

		}
    }); 
}
/** END RUN BROWSER **/

function option_close(){

	var data = $("#data-selected").val();
		data = data.split("<>");


	close_tabs_proccess(data[0],data[1]);

		$.ajax({
			type : "POST",
			url  : "handler?session="+rands(),
			data : {
				path : $("#file-"+data[0]).attr("place"),
				act  : 7,
				newname : "",
				type : "file",
			},
			success : function(e){
				close_modal();
			}
		});

}

function save_change(){
	
	save_project();

	var data = $("#data-selected").val();
		data = data.split("<>");


	close_tabs_proccess(data[0],data[1]);
	close_modal();
}

/** CLOSE ACTIVE TABS **/
function close_tabs(id,ext_data){

	var data = $("#flags-"+ext_data).attr("modify");

	if(data == "true"){

	$("#del-alert").html("<b>"+$("#file-"+id).attr("name")+"</b> has been modified, Save changes ? ")

	import_project('','',3);

	$("#data-selected").val(id+"<>"+ext_data);

	

	}else{

		close_tabs_proccess(id,ext_data);
	
	}
}

function close_tabs_proccess(id,ext_data){
	$(".tabs-"+id).remove();
	
	if($(".optional-tab").attr("data") !== "true"){
		$("#script-loader").load("open_file?session="+rands());
	}
	
    var attr_data = $(".tab-data:last");
	attr_data.click();
	var base_data = $("#dir-data").html();
		if(base_data.indexOf(ext_data+'-tabs') !== -1){
			$("#dir-data").html(base_data.replace(ext_data+'-tabs/',''));
		}
}
/** END CLOSE ACTIVE TABS **/

/** CLOSE MODAL **/
function close_modal(){
	$(".mugen-set").hide();
	$("#modal-bg").fadeOut();
	$(".modal-upload").hide();
	$(".dz-preview").remove();
	$(".dz-default").fadeIn();
	$(".alert-change").hide();
	$(".change-set").val('');
	$("#modal-bg1").hide();
	$(".toolbar-box").hide();
	$("#toolbox-log").val("0");
	$(".toolbar-title").removeClass("go_click");
	edit_user();
}
/** CLOSE MODAL **/


$(function(){

/**
* Jquery Context Menu 
* Type     : Plugin
* Base 	   : Code Mirror Plugin & Jquery
* function : Sidebar left box control
*/


	$.contextMenu({
		selector : '.left-box',
		events: {
        	activated: function(op){
        		var log_copy = $("#log-copy").val();
        		var log_move = $("#log-move").val();

        		if($("#log-active").val() !== ""){
        			$(".context-menu-not-selectable").slice(2).show();
        		}else{
        			$(".context-menu-not-selectable").slice(2).hide();
        		}
        		
        		if(log_copy !== ""){

        			$(".icon-pops").parent().show();

        		}else if(log_move !== ""){

        			$(".icon-pops").parent().show();

        		}else{

        			$(".icon-pops").parent().hide();

        		}		
        		
        	}
        }, 
		items:{

		   /** PREVIEW **/
		   Preview: {name: "Preview", icon: "fas fa-globe fas icon-pop",callback : function(){
		   	var object_data = $(this);

            	$("#url-load").val(object_data.attr("browse"));

            	$.ajax({
	        		type : "POST",
	        		url  : "save_change?session="+rands(),
	        		data : { // path of file or dir
	        			url		: $("#url-load").val(),
	        		},
        		beforeSend : function(){
        			$("#load1").show();
        			$("#load2").hide();
        		},
        		success : function(event){
        			
        			$("#load1").hide();
        			$("#load2").show();
	        		
	        		$("#box-area-result").html(event);

	        		panel_result("window");
	        		}
        		}); 
            }},
            /** END PREVIEW **/


            /** REFRESH **/
            Refresh: {name: "Refresh", icon: "fas fa-sync-alt  icon-pop",callback : function(){

            	var object_data = $(this);

            	showDir($("[root]").attr("place"),"true");

            	var data_list = $("#dir-data").html();
				var split_list = data_list.split("/");
				for(var i = 0 ; i < split_list.length - 1; i++){
					is_only($("."+split_list[i]).attr("realpath"),split_list[i]);
				}

            
            }},
            /** END REFRESH **/

             "sep1": "---------",

        	/** IMPORT FILE PROJECT **/
            Import: {name: "Import ", icon: "fas fa-cloud-download-alt icon-pop",callback : function(){
            	var object_data = $(this);
            	var special_id = object_data.attr("place");
            	
            	import_project(object_data,special_id,2);
            }},
            /** END IMPORT FILE PROJECT **/

            "sep2": "---------",

             Paste: {name: "Paste ", icon: "fas fa-paste icon-pops",callback : function(){
            	var object_data = $(this);
            	var special_id = object_data.attr("place");

            	var copy_act = $("#log-copy").val();
            	var move_act = $("#log-move").val();

            	
            	var dest_path = object_data.attr("destpath");

            	if(copy_act !== "") {
            		op_file = "copy";
            		var path = copy_act;
            	}
            	
            	if(move_act !== "") {
            		op_file = "move";
            		var path = move_act;
            	}

            	moveData(path,dest_path,op_file);

            	$("#log-copy").val("");
            	$("#log-move").val("");

            	$("#log-active").val("");


			 }},

			 "sep3": ($("#log-active").val() == "") ? "---------" : {visible: false},



		 /** CREATE NEW FOLDER **/
            NewFolder: {name: "New Folder ", icon: "fas fa-folder-open icon-pop",callback : function(){
            	var object_data = $(this);
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
            	
            }},
            /** END CREATE NEW FOLDER **/

            /** CREATE NEW FILE **/
            NewFile: {name: "New File ", icon: "fas fa-file icon-pop",callback : function(){

            	var object_data = $(this);
            	var special_id = object_data.attr("place");

            	$('.listing-box-body').animate({scrollTop : 0});
            	$(".newf").hide();
            	$("#add1-"+object_data.attr("place")).show();
            	$("#input1-"+object_data.attr("place")).val("");
            	$("#input1-"+object_data.attr("place")).focus();
            	close_rename_file(special_id,"dir");
            	close_rename_file(special_id,"file");
            	$(".fnm").hide();
            	$(".fno").show();

            }},
            /** END CREATE NEW FILE **/

            
		}
	});


/**
* Jquery Context Menu 
* Type     : Plugin
* Base 	   : Code Mirror Plugin & Jquery
* function : Directory Control
*/






$.contextMenu({
        selector: '.dir-name', 
        events: {
        	activated: function(op){
        		var log_copy = $("#log-copy").val();
        		var log_move = $("#log-move").val();

        		
        		if(log_copy !== ""){

        			$(".icon-pops").parent().show();

        		}else if(log_move !== ""){

        			$(".icon-pops").parent().show();

        		}else{

        			$(".icon-pops").parent().hide();

        		}


        		var dest_path = $("#log-dest").val();
        		var base_path = $("#raw-data-id").html();
        	
        		if(dest_path.indexOf(base_path) !== -1) {

        			$(".icon-pops").parent().hide();

        		}	

        		var path = $("#active-select").val();

        		var extention = path.split(".");
        			extention = extention[(extention.length - 1)];

        			if(extention !== "zip"){

        				$(".icon-pop-extract").parent().hide();
        				$(".icon-pop-archive").parent().show();

        			}else{
						$(".icon-pop-archive").parent().hide();        				
        			}

        	}
        }, 
        items: {
        	/** PREVIEW **/
            Preview: {name: "Preview", icon: "fas fa-globe icon-pop",callback : function(){

            	var object_data = $(this);

            	$("#url-load").val(object_data.attr("browse"));

            	$.ajax({
	        		type : "POST",
	        		url  : "save_change?session="+rands(),
	        		data : { // path of file or dir
	        			url		: $("#url-load").val(),
	        		},
	        		beforeSend : function(){
	        			$("#load1").show();
	        			$("#load2").hide();
	        		},
	        		success : function(event){
	        			
	        			$("#load1").hide();
	        			$("#load2").show();
	        			
	        			$("#box-area-result").html(event);

	        			panel_result("window");
	        		}
        		}); 
            }},
            /** END PREVIEW **/

            /** SWITCH **/
            SetProject: {name: "Switch", icon: "fas fa-sitemap icon-pop",callback : function(){

            	var object_data = $(this);
            	var special_id = object_data.attr("place");
            	$("#projectname1").val($("#dir-"+special_id).attr("curentpath"));
            	$("#url-load").val(object_data.attr("browse"));

            	import_project('','',1);
            }},
            /** END SWITCH **/

            /** REFRESH **/
            Refresh: {name: "Refresh", icon: "fas fa-sync-alt  icon-pop",callback : function(){
            	
            	var object_data = $(this);

            	showDir(object_data.attr("place"),"true");

            	var data_list = $("#dir-data").html();
				var split_list = data_list.split("/");
				for(var i = 0 ; i < split_list.length - 1; i++){
					is_only($("."+split_list[i]).attr("realpath"),split_list[i]);
				}

            
            }},

            AddToArchive: {name: "Add to zip", icon: "fas fa-file-archive icon-pop-archive",callback : function(){

            	var object_data = $(this);

            	var special_id = object_data.attr("place");
            	$.ajax({
            		type : "POST",
            		url  : "handler?session="+rands(),
            		data : {
            			path : object_data.attr("realpath"),
            			act  : 16,
            			type : "file",
            			newname : object_data.attr("name"),
            		},
            		beforeSend : function(){
            			$("#loading-"+special_id).show();
            		},
            		success : function(event){

            			var value = event.split("||");

            			$("#loading-"+special_id).hide();
            			showDir(value[1],"true");
            		},
            		error : function(){
            			alert("error : file isn't valid");
            			$("#loading-"+special_id).hide();
            		}
            	});

            	
            }},
            /** END REFRESH **/
            
            "sep1": "---------",

        	/** IMPORT FILE PROJECT **/
            Import: {name: "Import ", icon: "fas fa-cloud-download-alt icon-pop",callback : function(){
            	var object_data = $(this);
            	var special_id = object_data.attr("place");

            	import_project(object_data,special_id,2);
            }},
            /** END IMPORT FILE PROJECT **/

            "sep2": "---------",



			 /** FILE COPY **/
             Copy: {name: "Copy ", icon: "far fa-copy icon-pop",callback : function(){

            	var object_data = $(this);

				$("#log-copy").val(object_data.attr("realpath"));        
            	$("#log-move").val("");
            	
            	var special_id = object_data.attr("place");
            	$("#raw-data-id").html(special_id);

            	$("#log-active").val("true");
            			
            			
            		
            }},

            Move: {name: "Move ", icon: "fas fa-expand-arrows-alt icon-pop",callback : function(){

            	var object_data = $(this);

				$("#log-move").val(object_data.attr("realpath"));        
            	$("#log-copy").val("");
            	
            	var special_id = object_data.attr("place");
            	$("#raw-data-id").html(special_id);

            	$("#log-active").val("true");
            			
            
            }},
            /** END FILE COPY **/

             Paste: {name: "Paste ", icon: "fas fa-paste icon-pops",callback : function(){
            	var object_data = $(this);
            	var special_id = object_data.attr("place");

            	var copy_act = $("#log-copy").val();
            	var move_act = $("#log-move").val();

            	
            	var dest_path = object_data.attr("destpath");

            	if(copy_act !== "") {
            		op_file = "copy";
            		var path = copy_act;
            	}
            	
            	if(move_act !== "") {
            		op_file = "move";
            		var path = move_act;
            	}

            	moveData(path,dest_path,op_file);

            	$("#log-copy").val("");
            	$("#log-move").val("");

            	$("#log-active").val("");


			 }},

            "sep5": "---------",

            /** CREATE NEW FOLDER **/
            NewFolder: {name: "New Folder ", icon: "fas fa-folder-open icon-pop",callback : function(){
            	var object_data = $(this);
            	var special_id = object_data.attr("place");

            	$(".newf").hide();
            	$("#add-"+object_data.attr("place")).show();
            	$("#input-"+object_data.attr("place")).val("");
            	$("#input-"+object_data.attr("place")).focus();
            	close_rename_file(special_id,"dir");
            	close_rename_file(special_id,"file");
            	$(".fnm").hide();
            	$(".fno").show();
            	
            }},
            /** END CREATE NEW FOLDER **/

            /** CREATE NEW FILE **/
            NewFile: {name: "New File ", icon: "fas fa-file icon-pop",callback : function(){
            	var object_data = $(this);
            	var special_id = object_data.attr("place");

            	$(".newf").hide();
            	$("#add1-"+object_data.attr("place")).show();
            	$("#input1-"+object_data.attr("place")).val("");
            	$("#input1-"+object_data.attr("place")).focus();
            	close_rename_file(special_id,"dir");
            	close_rename_file(special_id,"file");
            	$(".fnm").hide();
            	$(".fno").show();

            }},
            /** END CREATE NEW FILE **/

            "sep3": "---------",

            /** RENAME DIRECTORY **/
            Rename: {name: "Rename ", icon: "fas fa-pencil-alt icon-pop",callback : function(){
            	var object_data = $(this);
            	var special_id = object_data.attr("place");

            	close_rename_file(special_id,"file");

            	$(".fnm").hide();
            	$(".fno").show();
            	$(".newf").hide();

            	$("#name-dir-"+special_id).hide();
            	$("#go-change-name-"+special_id).fadeIn();
            	$("#dir-"+special_id).attr("onClicks",$("#dir-"+special_id).attr("onClick"));
            	$("#dir-"+special_id).removeAttr("onClick");
            	$("#dir-"+special_id).removeClass("name-file");

            	$("#change-file-name-"+special_id).val(object_data.attr("name"));
            	$("#change-file-name-"+special_id).focus();

            }},
            /** END RENAME DIRECTORY **/

            /** DELETE DIRECTORY **/
            Delete: {name: "Delete ", icon: "fas fa-trash icon-pop",callback : function(){

            	var object_data = $(this);
            	var special_id = object_data.attr("place");

            	$("#del-data-alert").html("Are you sure want to delete <b>"+object_data.attr("name")+"</b> data ?");
            	$("#file-data-selected").val(special_id);
				import_project('','',9);

            }},
            /** END DELETE DIRECTORY **/

            "sep4": "---------",

             Permition : {name: "Change Permition ", icon: "fas fa-key icon-pop",callback : function(){
            	
            	var object_data = $(this);

            	$.ajax({
            		type : "POST",
            		url  : "handler?session="+rands(),
            		data : {
            			type    : "file",
            			act     : 17,
            			path    : $(this).attr("realpath") // path of file or dir
            		},
            		success : function(event){

            			var paramater = event.split("/");

            			var check = paramater[0].split("-");

            			for(var i = 0; i < check.length; i++){

            				if(check[i].indexOf("unceck") !== -1) {
            					var get_class = check[i].split("=");
            					$("."+get_class[1]).prop("checked",false);
            					console.log(get_class[1]);
            				}else{
            					$("."+check[i]).prop("checked",true);
            				}

            			}

            			var code = paramater[1].split("-");

            			for(var i = 1; i < 4; i++){

            				$(".conf"+i).html(code[(i-1)]);

            			}
            			$("#text-file-name").html("("+paramater[2]+")");
            			import_project("","",8);

            		}
            	});

            }},

            /** FILE PROPERTIES **/
             Properties: {name: "Properties ", icon: "fas fa-info-circle icon-pop",callback : function(){

            	var object_data = $(this);

            	$.ajax({
            		type : "POST",
            		url  : "handler?session="+rands(),
            		data : {
            			type    : "file",
            			act     : 9,
            			path    : $(this).attr("realpath") // path of file or dir
            		},
            		success : function(event){

            			var data = event.split("<|>");
            				
            			var list = ["f","t","l","s","c","m","a","i","n","jml1","jml2","p"];
            			

            			for(var i = 0; i < list.length; i++){
							
							$("#"+list[i]+"-name").html(data[i]);

            			}

            			if(data[(data.length - 1)].indexOf("1") !== -1){
            				
            				$("#contains-data").show();

            			}else{

            				$("#contains-data").hide();
            			}

            			import_project("","",5);
            			
            		}
            	});
            }},
            /** END FILE PROPERTIES **/
        }
    });


/**
* Jquery Context Menu 
* Type     : Plugin
* Base 	   : Code Mirror Plugin & Jquery
* function : File Control
*/



    $.contextMenu({
        selector: '.name-file',
        events : {
        	activated : function(op){

        		var path = $("#active-select").val();

        		var extention = path.split(".");
        			extention = extention[(extention.length - 1)];

        			if(extention !== "zip"){

        				$(".icon-pop-extract").parent().hide();
        				$(".icon-pop-archive").parent().show();

        			}else{
						$(".icon-pop-archive").parent().hide();        				
        			}
      		
        	}
        },
        items: {


        	/** PREVIEW **/
            Preview: {name: "Preview", icon: "fas fa-globe icon-pop",callback : function(){

            	var object_data = $(this);

            	$("#url-load").val(object_data.attr("browse"));
            	
            	$.ajax({
	        		type : "POST",
	        		url  : "save_change?session="+rands(),
	        		data : { // path of file or dir
	        			url		: $("#url-load").val(),
	        		},
	        		beforeSend : function(){
	        			$("#load1").show();
	        			$("#load2").hide();
	        		},
	        		success : function(event){
	        			
	        			$("#load1").hide();
	        			$("#load2").show();
	        			
	        			$("#box-area-result").html(event);
	        			panel_result("window");
	        		},
            		error : function(){
            			alert("error : file isn't valid");
            			$("#loading-"+special_id).hide();
            		}
        		}); 
            }},

            AddToArchive: {name: "Add to zip", icon: "fas fa-file-archive icon-pop-archive",callback : function(){

            	var object_data = $(this);

            	var special_id = object_data.attr("place");
            	$.ajax({
            		type : "POST",
            		url  : "handler?session="+rands(),
            		data : {
            			path : object_data.attr("realpath"),
            			act  : 16,
            			type : "file",
            			newname : object_data.attr("name"),
            		},
            		beforeSend : function(){
            			$("#loading-"+special_id).show();
            		},
            		success : function(event){

            			var value = event.split("||");

            			$("#loading-"+special_id).hide();
            			showDir(value[1],"true");
            		},
            		error : function(){
            			alert("error : file isn't valid");
            			$("#loading-"+special_id).hide();
            		}
            	});

            	
            }},
             Extract: {name: "Extract", icon: "fab fa-dropbox icon-pop-extract",callback : function(){

            	var object_data = $(this);

            	var special_id = object_data.attr("place");
            	$.ajax({
            		type : "POST",
            		url  : "handler?session="+rands(),
            		data : {
            			path : object_data.attr("realpath"),
            			act  : 15,
            			type : "file",
            			newname : object_data.attr("name"),
            		},
            		beforeSend : function(){
            			$("#loading-"+special_id).show();
            		},
            		success : function(event){

            			var value = event.split("||");

            			$("#loading-"+special_id).hide();
            			showDir(value[1],"true");
            		},
            		error : function(){
            			alert("error : file isn't valid");
            			$("#loading-"+special_id).hide();
            		}
            	});


            	
            }},

            /** END PREVIEW **/

            "sep1": "---------",

            /** EXPORT FILE PROJECT **/
            Export: {name: "Export ", icon: "far fa-arrow-alt-circle-up icon-pop",callback : function(){
            	var object_data = $(this);
            	var special_id = object_data.attr("place");
            	$.ajax({
            		type : "POST",
            		url  : "force_download?session="+rands(),
            		data : {
            			path : object_data.attr("realpath"),
            			newname : object_data.attr("name"),
            			option : "generate"
            		},
            		beforeSend : function(){
            			$("#loading-"+special_id).show();
            		},
            		success : function(event){
            			$("#loading-"+special_id).hide();
            			$(".force-download").html(event);
            		},
            		error : function(){
            			alert("error : file isn't valid");
            			$("#loading-"+special_id).hide();
            		}
            	});
            }},
            /** END EXPORT FILE PROJECT **/

			"sep5": "---------",

			 /** FILE COPY **/
             Copy: {name: "Copy ", icon: "far fa-copy icon-pop",callback : function(){

            	var object_data = $(this);          

            	$("#log-copy").val(object_data.attr("realpath"));        
            	$("#log-move").val("");

            	var special_id = object_data.attr("place");
            	$("#raw-data-id").html(special_id);

            	$("#log-active").val("true");
            	
            			
            			
            		
            }},

            Move: {name: "Move ", icon: "fas fa-expand-arrows-alt icon-pop",callback : function(){

            	var object_data = $(this);

				$("#log-move").val(object_data.attr("realpath"));        
            	$("#log-copy").val("");
            	
            	var special_id = object_data.attr("place");
            	$("#raw-data-id").html(special_id);

            	$("#log-active").val("true");
            			
            
            }},
            /** END FILE COPY **/

            "sep2": "---------",

        	/** RENAME FILE **/
            Rename: {name: "Rename", icon: "fas fa-pencil-alt icon-pop",callback : function(){

            	var object_data = $(this);
            	var special_id = object_data.attr("place");

            	close_rename_file(special_id,"dir");
            	$(".fnm").hide();
            	$(".fno").show();
            	$(".newf").hide();
            	$("#active-name-file-"+special_id).hide();
            	$("#go-change-name-"+special_id).fadeIn();
            	$("#file-"+special_id).attr("onClicks",$("#file-"+special_id).attr("onClick"));
            	$("#file-"+special_id).removeAttr("onClick");
            	$("#file-"+special_id).removeClass("name-file");            	       
            	$("#change-file-name-"+special_id).val(object_data.attr("name"));
            	$("#change-file-name-"+special_id).focus();

            }},
            /** END RENAME FILE **/


			/** DELETE FILE **/

            Delete: {name: "Delete ", icon: "fas fa-trash icon-pop",callback : function(){

            	var object_data = $(this);
            	var special_id = object_data.attr("place");

            	$("#del-data-alert").html("Are you sure want to delete <b>"+object_data.attr("name")+"</b> data ?");
            	$("#file-data-selected").val(special_id);
				import_project('','',9);

            }},

            /** END DELETE FILE **/

            "sep3": "---------",

             Permition : {name: "Change Permition ", icon: "fas fa-key icon-pop",callback : function(){
            	
            	var object_data = $(this);

            	$.ajax({
            		type : "POST",
            		url  : "handler?session="+rands(),
            		data : {
            			type    : "file",
            			act     : 17,
            			path    : $(this).attr("realpath") // path of file or dir
            		},
            		success : function(event){

            			var paramater = event.split("/");

            			var check = paramater[0].split("-");

            			for(var i = 0; i < check.length; i++){

            				if(check[i].indexOf("unceck") !== -1) {
            					var get_class = check[i].split("=");
            					$("."+get_class[1]).prop("checked",false);
            					console.log(get_class[1]);
            				}else{
            					$("."+check[i]).prop("checked",true);
            				}

            			}

            			var code = paramater[1].split("-");

            			for(var i = 1; i < 4; i++){

            				$(".conf"+i).html(code[(i-1)]);

            			}

            			$("#text-file-name").html("("+paramater[2]+")");
            			import_project("","",8);

            		}
            	});

            }},

            /** FILE PROPERTIES **/
             Properties: {name: "Properties ", icon: "fas fa-info-circle icon-pop",callback : function(){

            	var object_data = $(this);

            	$.ajax({
            		type : "POST",
            		url  : "handler?session="+rands(),
            		data : {
            			type    : "file",
            			act     : 9,
            			path    : $(this).attr("realpath") // path of file or dir
            		},
            		success : function(event){

            			var data = event.split("<|>");
            				
            			var list = ["f","t","l","s","c","m","a","i","n","jml1","jml2","p"];
            			

            			for(var i = 0; i < list.length; i++){
							
							$("#"+list[i]+"-name").html(data[i]);

            			}

            			if(data[(data.length - 1)].indexOf("1") !== -1){
            				
            				$("#contains-data").show();

            			}else{

            				$("#contains-data").hide();
            			}

            			import_project("","",5);
            			
            		}
            	});
            }},

          
            /** END FILE PROPERTIES **/

            
        }
    });

     $.contextMenu({
        selector: '.optional-tab', 
        items: {


        	/** PREVIEW **/
            Preview: {name: "Preview", icon: "fas fa-globe icon-pop",callback : function(){

            	var object_data = $(this);

            	$("#url-load").val(object_data.attr("browse"));
            	
            	$.ajax({
	        		type : "POST",
	        		url  : "save_change?session="+rands(),
	        		data : { // path of file or dir
	        			url		: $("#url-load").val(),
	        		},
	        		beforeSend : function(){
	        			$("#load1").show();
	        			$("#load2").hide();
	        		},
	        		success : function(event){
	        			
	        			$("#load1").hide();
	        			$("#load2").show();
	        			
	        			$("#box-area-result").html(event);
	        			panel_result("window");
	        		}
        		}); 
            }},
            /** END PREVIEW **/
        }
    });



/**
* Jquery dropzone 
* Type     : Source Code
* Base 	   : Jquery
* function : Dropzone upload
*/


     // Drag enter
    $('.upload-area').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var id = $(this).attr("place");
        if( $(this).attr("root") !== "true"){
        $(this).css({"background" : "#f1f1f1"});
        $(".uploads-"+id).addClass("fa-upload");
        $(".uploads-"+id).show();

    }
    });

    // drag leave
    $('.upload-area').on('dragleave', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var id = $(this).attr("place");
        if( $(this).attr("root") !== "true"){
        $(this).css({"background" : ""});
        $(".uploads-"+id).addClass("fa-upload");
        $(".uploads-"+id).hide();

    }
    });

    // Drag over
    $('.upload-area').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var id = $(this).attr("place");
        $(".up-margin").hide();

    });

    // Drop
    $('.upload-area').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();

        var id = $(this).attr("place");
        if( $(this).attr("root") !== "true"){
        $("#loading-"+id).show();
        $(".uploads-"+id).hide();
    	}

        var file = e.originalEvent.dataTransfer.files;
        var fd = new FormData();

        fd.append('path', $(this).attr("realpath"));
        fd.append('type', "doc");
        fd.append('act', 1);
        fd.append('file', file[0]);	
        
        var uniq_data = $(this).attr("place");

        uploadData(fd,uniq_data);

    });

    // Open file selector on div click
    $("#filedrop").prop("disabled","true");

    $(".dropzone").dropzone({
    
		complete : function(file){
			setTimeout(function(){
				$(".dz-progress").remove();
			},600);

			showDir($("#id-up").val(),"true");
			// close_modal();
		}
	});

});



// Sending AJAX request and upload file
function uploadData(formdata,uniq_id){



    $.ajax({
        url: 'handler',
        type: 'post',
        data: formdata,
        contentType: false,
        processData: false,
      
        success: function(response){

            showDir(uniq_id,"true");

            if( $("#dir-"+uniq_id).attr("root") !== "true"){
	            
	            $("#loading-"+uniq_id).hide();
	            $(".uploads-"+uniq_id).show();
	            $(".uploads-"+uniq_id).addClass("fa-check");
	            $(".uploads-"+uniq_id).removeClass("fa-upload");
	            $(".uploads-"+uniq_id).delay(3000).fadeOut();
	            $("#dir-"+uniq_id).css({"background" : ""});
	           

        	}

        	 coba();
        }
    });
}

function coba(){
	$(".up-margin").hide();
}

function moveData(path,dest_path,op_file){

	$.ajax({
      	type : "POST",
      	url  : "handler?session="+rands(),
      	data : {
      		type    : "file",
      		act     : 10,
      		path    : path, // path of file or dir
      		dest 	: dest_path,
      		opfile 	: op_file
      	},
      	beforeSend : function(){
      		$("#loading-copy").show();
      	},
      	success : function(event){

      		var value = event.split("||");

      		if(event.indexOf("<success/>") !== -1){

	      			if(event.indexOf("<remove/>") !== -1){

	      			$(".file-name-"+$("#raw-data-id").html()).toggle("slide");
	      			$("#"+$("#raw-data-id").html()).toggle("slide");

	      			var data_list = $("#dir-data").html();
					var split_list = data_list.split("/");

						for(var i = 0 ; i < split_list.length - 1; i++){
							is_only($("."+split_list[i]).attr("realpath"),split_list[i]);
						}

      				}
      			
      			if(event.indexOf("<true/>") !== -1){
      				
      				$("#listing-space").load("listing?session="+rands());

      			}else{
      				
      				showDir(value[1],"true");
      			}

	      		// showDir(value[0],true);
	      		// showDir(value[1],"true");
	      		$("#copy-alert").hide();
	      		close_modal();

      		}else{

      			$("#copy-alert").show();
      			$("#copy-alert").html("Warning : Wrong Destination Path");

      		}            			
			
			$("#loading-copy").hide();

   		}
   });
}

function edit_user(nama = ""){
	if(($("#config-user").css("display") == "none") && nama != ""){
		
		$.ajax({
			type : "POST",
			url : "edituser",
			data : {
				id : nama
			},
			success : function(event){
				$("#list-user").hide();
				$("#config-user").show();
				$("#config-user").html(event);
				$("#user-close").attr("onClick","edit_user()");
				$("#user-save").show();
				$("#user-delete").show();
				$("#user-close").html("Cancel");
				$("#user-delete").attr("onClick","user_delete('"+nama+"')");
				$("#user-save").attr("onClick","user_save('"+nama+"')");
				$("#adduser").hide();
			}

		});

	}else{

		$("#list-user").show();
		$("#config-user").hide();
		$("#config-user").html("");
		$("#user-close").attr("onClick","close_modal()");
		$("#user-save").hide();
		$("#user-delete").hide();
		$("#user-close").html("Close");
		$("#user-delete").removeAttr("onClick");
		$("#user-save").attr("onClick");
		$("#adduser").hide();
	}
}

function user_suspend(username){

	$.ajax({
		type : "POST",
		url  : "handler?session="+rands(),
		data : {
			type    : "file",
			act     : 11,
			user 	: username
		},
		success : function(event){

			if(event.indexOf("<on/>") !== -1){
				
				$(".lock-"+username).removeClass("btn-danger");
				$(".lock-"+username).addClass("btn-default");
				$(".lock-"+username+" i").removeClass("fa-lock");
				$(".lock-"+username+" i").addClass("fa-lock-open");
				$("#adduser").hide();


			}else{

				$(".lock-"+username).removeClass("btn-default");
				$(".lock-"+username).addClass("btn-danger");
				$(".lock-"+username+" i").removeClass("fa-lock-open");
				$(".lock-"+username+" i").addClass("fa-lock");
				$("#adduser").hide();


			}
		}
	});

}

function user_delete(username){

	if(confirm("Are you sure want to delete this user ?") == true){
		$.ajax({
			type : "POST",
			url  : "handler?session="+rands(),
			data : {
				type    : "file",
				act     : 12,
				user 	: username
			},
			success : function(event){

				if(event.indexOf("<remove/>") !== -1){
					
					edit_user();
					$(".list-"+username).remove();



				}
			}
		});
	}
}

function user_save(username){

	$.ajax({
		type : "POST",
		url  : "handler?session="+rands(),
		data : {
			type    : "file",
			act     : 13,
			user 	: username,
			p_path  : $("#d1").val(),
			p_url   : $("#d2").val(),
			dany_ext: $("#d3").val(),
			
		},
		success : function(event){

			edit_user();
			$("#list-user").html(event);

		}
	});
	
}

function addUser(){
	if($("#adduser").css("display") == "none"){
		$("#adduser").show();
		$("#config-user").hide();
		$("#list-user").hide();
		$("#user-save").show();
		$("#user-save").attr("onClick","saveAddUser()");
		$("#user-close").attr("onClick","addUser()");
	}else{
		$("#adduser").hide();
		$("#config-user").hide();
		$("#list-user").show();
		$("#user-save").hide();
		$("#user-save").attr("onClick","");
		$("#user-close").attr("onClick","close_modal()");

	}
}

function saveAddUser(){

		$.ajax({
		type : "POST",
		url  : "handler?session="+rands(),
		data : {
			type    : "file",
			act     : 14,
			user  : $("#add1").val(),
			pass   : $("#add2").val(),
			project_path : $("#add3").val(),
			preview_project_path: $("#add4").val(),
			disallow : $("#add5").val(),
			
		},
		success : function(event){

			$("#listing-space").load("listing?session="+rands());
			addUser();
			$("#list-user").html(event);

		}
	});

}

function set_base_path(){
	$('.select-area').mousedown(function(event) {
	    if(event.which == 3) {
	    	
	    	$("#log-dest").val($(this).attr("place"));
	    	
	    }
	    
	});
}

function setChmod(op){

	var el     = $(op);
	var act    = el.attr("act");
	var data   = el.attr("data");
	var status = el.attr("status");


	if($(op).prop('checked')) {
				
		var sum = parseInt($(".conf"+act).html()) + parseInt(data);
		el.attr("status","1");
		$(".conf"+act).html(sum);

	}else{

		var sum = parseInt($(".conf"+act).html()) - parseInt(data);
		el.attr("status","0");
		$(".conf"+act).html(sum);

	}

}

function change_permition(){

	var attr_data = "";
	for(var i = 1; i < 4; i++){
		attr_data += $(".conf"+i).html();
	}

	$.ajax({
		type : "POST",
		url  : "handler?session="+rands(),
		data : {
			type    : "file",
			act     : 18,
			attr 	: attr_data,
			path 	: $("#active-select").val()
		},
		success : function(event){
			close_modal();
		}
	});
}

function save_delete_file(){


		var special_id = $("#file-data-selected").val();
		var object_data = $(".file-name-"+special_id);
		var doc_type = object_data.attr("doctype");

		if(doc_type == "doc"){

		$.ajax({
			type : "POST",
			url  : "handler?session="+rands(),
			data : {
				type    : "doc",
				act     : 5,
				path    : object_data.attr("realpath") // path of file or dir
			},
			beforeSend : function(){
				$("#loading-"+special_id).show();
			},
			success : function(event){
				$("#loading-"+special_id).hide();
				$(object_data).toggle("slide");
				$("#"+object_data.attr("place")).toggle("slide");


				var data_list = $("#dir-data").html();
				var split_list = data_list.split("/");
				for(var i = 0 ; i < split_list.length - 1; i++){
					is_only($("."+split_list[i]).attr("realpath"),split_list[i]);
				}

				close_modal();

			},
			error : function(){
				alert("error : file isn't valid");
				$("#loading-"+special_id).hide();
			}
		});

		}else{

		$.ajax({
    		type : "POST",
    		url  : "handler?session="+rands(),
    		data : {
    			type    : "file",
    			act     : 4,
    			path    : object_data.attr("realpath") // path of file or dir
    		},
    		success : function(event){
    			
    			$(object_data).toggle("slide");

    			if($(".tabs-"+object_data.attr("place")).attr("data") == "true"){
    				$(".tabs-"+object_data.attr("place")).remove();
    				$("#script-loader").load("open_file?session="+rands());
    				var attr_data = $(".tab-data");
    				attr_data.click();
    			}

    			close_modal();
    		}
        });

		}

	}


	function show_toolbox(data){

		if($(".tool-"+data).css("display") == "none"){
			$(".toolbar-box").hide();
			$(".tool-"+data).show();
			$("#modal-bg1").show();
			$("#toolbox-log").val(data);
			$(".toolbar-title").addClass("go_click");

			if($("#dir-data").html() == ""){

				$(".save-act").css({
					"color" : "#ccc"
				});

				$(".save-act i").css({
					"color" : "#80C3FF"
				});

				$(".save-act").attr("backup",$(".save-act").attr("onClick"));
				$(".save-act").removeAttr("onClick");

				$(".close-act").css({
					"color" : "#ccc"
				});

				$(".close-act i").css({
					"color" : "#80C3FF"
				});

				$(".close-act").attr("backup",$(".close-act").attr("onClick"));
				$(".close-act").removeAttr("onClick");

				$(".close-all-act").css({
					"color" : "#ccc"
				});

				$(".close-all-act i").css({
					"color" : "#80C3FF"
				});

				$(".close-all-act").attr("backup",$(".close-all-act").attr("onClick"));
				$(".close-all-act").removeAttr("onClick");

			}else{

				$(".save-act").css({
					"color" : "#434343"
				});

				$(".save-act i").css({
					"color" : "#2980b9"
				});
				$(".save-act").attr("onClick",$(".save-act").attr("backup"));

				$(".close-act").css({
					"color" : "#434343"
				});

				$(".close-act i").css({
					"color" : "#2980b9"
				});
				$(".close-act").attr("onClick",$(".close-act").attr("backup"));

				$(".close-all-act").css({
					"color" : "#434343"
				});

				$(".close-all-act i").css({
					"color" : "#2980b9"
				});
				$(".close-all-act").attr("onClick",$(".close-all-act").attr("backup"));

			}
		
		}else{

			$(".tool-"+data).hide();
			$("#modal-bg1").hide();
			$("#toolbox-log").val("0");
			$(".toolbar-title").removeClass("go_click");

		}		

	}
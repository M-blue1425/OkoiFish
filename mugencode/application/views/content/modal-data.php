	<!-- File Upload -->
	<div class="panel-body fly-box" style="cursor: pointer;display: none;">

		<div style="margin-top: -10px;text-align: center;border-bottom:1px #ddd solid;padding-top: 10px;margin-bottom:10px;padding-bottom:5px;">
			<span style="font-size: 15px;color:#666"><i class="fas fa-cloud-download-alt " style="font-size: 20px;color:#aaa;cursor: pointer;"></i>
			Drag your file in the area below</span>
		</div>

		<form action="<?=HomeUrl()."/handler"?>" class="dropzone needsclick dz-clickable" style="border:transparent;text-align: left;position: relative;z-index:999;background: transparent;">

			<!-- paramater upload -->
			<input type="text" id="act-up" name="act" style="display: none;" value="1">
			<input type="text" id="path-up" name="path" style="display: none;" value="">
			<input type="text" id="type-up" name="type" style="display: none;" value="doc">
			<input type="text" id="id-up" style="display: none;" value="">
			<input type="text" id="name-up"  style="display: none;" value="">
			<!-- / paramater upload -->

			<div class="dz-messages needsclick dz-clickable" style="cursor: pointer;position: relative;">

			</div>

		</form>
		

		<div style="margin-top: 10px;text-align: right;border-top:1px #ddd solid;padding-top: 10px;">
			<button class="btn btn-default" onClick="close_modal()"> Close</button>
		</div>
	</div>
	<!-- / File Upload -->


	<!-- Change Project -->
	<?php if(config()->level >= 1){ ?>
	<div class="panel-body fly-box1" style="display: none;">
			
		<div style="margin-top: -10px;text-align: left;border-bottom:1px #ddd solid;padding-top: 10px;margin-bottom:10px;padding-bottom:5px;">
			<span style="font-size: 20px;">Switch Project</span>
		</div>

		<form id="form-new-project" method="POST" onSubmit="return create_new_project(this)">

			<div id="create-new-project" style="margin-bottom: 20px">

				<p style="font-family: sans-serif;">Project Path</p>
				<input style="font-family: sans-serif;" type="text" id="projectname1" class="form-control" placeholder="Ex : myproject" value="{preview path}">

				<p style="font-family: sans-serif;margin-top:10px;">Project view Url</p>
				<input style="font-family: sans-serif;" type="text" id="projectname2" class="form-control" placeholder="Ex : http://localhost/myproject/" value="{preview url}">

			</div>

			<div style="margin-top: 10px;text-align: right;border-top:1px #ddd solid;padding-top: 10px;">
			<button class="btn btn-info" type="submit">
			<i class="fas fa-sync-alt" id="loading-create0"></i> 
			<img src="<?=projectUrl().'/assets/img/ovalo-black.svg'?>" id="loading-create1" width="13" style="margin-top: 0px;display: none;">
			Switch</button>
			<button class="btn btn-default" type="button" onClick="close_modal()"> Cancel</button>
		</div>

		</form>

	</div>
	<?php } ?>
	<!-- / Change Project -->


	<!-- Unsaved Confirmation -->
	<div class="panel-body fly-box3" style="display: none;">
	
	<table width="100%">
		<tr>
			<td valign="top" style="padding: 10px;">
				<i class="fas fa-exclamation-circle" style="font-size: 70px;color: #f5da2e">
			</td>
			<td valign="top" style="padding: 10px;">
				<div style="margin-bottom: 10px;" id="del-alert"></div>
				<button class="btn btn-info" onClick="save_change()">Yes</button>
				<button class="btn btn-default" onClick="option_close()">No</button>
				<button class="btn btn-default" onClick="close_modal()">Cancel</button>
				<input type="text" id="data-selected" style="display: none;">
			</td>
		</tr>
	</table>
	</div>
	<!-- / Unsaved Confirmaton -->




	<!-- Login Setting -->
	<div class="panel-body fly-box4" style="display: none;">
		<div style="border-bottom: 1px #ddd solid;margin-top: -10px;padding-top: 10px;margin-bottom:10px;padding-bottom:5px;">
			<span style="font-size: 20px;" id="info-properties">Change Password</span>
		</div>
		<form method="POST" action="<?php echo HomeUrl()?>/handler" onSubmit="return change_login(this)">
			
			
			
			<input style="font-family: sans-serif;margin-top: 3px;" type="text" name="old" class="form-control change-set" placeholder="Old Password" value="">
			<input style="font-family: sans-serif;margin-top: 3px;" type="text" name="new" class="form-control change-set" placeholder="New Password" value="">
			<input style="font-family: sans-serif;margin-top: 3px;" type="text" name="renew" class="form-control change-set" placeholder="Retype New Password" value="">
			
			<input style="display: none;" type="text" name="act" value="8">
			<input style="display: none;" type="text" name="type" value="file">

			<div class="alert alert-danger alert-change" style="margin-top: 10px;margin-bottom: 10px;display: none;"></div>

			<div style="margin-top: 10px;text-align: right;border-top:1px #ddd solid;padding-top: 10px"><button type="submit" class="btn btn-info use-change">Save Changes</button>
			<button type="button" onClick="close_modal()" class="btn btn-default">Cancel</button>
			</div>

	</form>
	</div>
	<!-- / Login Setting -->


	<!-- properties -->
	<div class="panel-body fly-box5" style="display: none;">
		<div style="border-bottom: 1px #ddd solid;margin-top: -10px;padding-top: 10px;margin-bottom:10px;padding-bottom:5px;">
			<span style="font-size: 20px;" id="info-properties"><span id="i-name"></span> <span id="n-name">mugencode.txt</span> Properties</span>
		</div>

		<table width="100%">
			<tr>
				<td style="width: 100px;padding: 5px">File Name</td>
				<td style="width: 10px;padding: 5px">:</td>
				<td style="padding: 10px" valign="top" id="f-name"></td>
			</tr>
			<tr>
				<td style="width: 100px;padding: 5px">File Type</td>
				<td style="width: 10px;padding: 5px">:</td>
				<td style="padding: 10px" valign="top" id="t-name"></td>
			</tr>

			<tr style="border-top:1px #ddd solid;">
				<td style="width: 100px;padding: 5px">Location</td>
				<td style="width: 10px;padding: 5px">:</td>
				<td style="padding: 10px" valign="top" id="l-name"></td>
			</tr>

			<tr>
				<td style="width: 100px;padding: 5px">Size</td>
				<td style="width: 10px;padding: 5px">:</td>
				<td style="padding: 10px" valign="top" id="s-name"></td>
			</tr>
			<tr style="border-top:1px #ddd solid;">
				<td style="width: 100px;padding: 5px">Created</td>
				<td style="width: 10px;padding: 5px">:</td>
				<td style="padding: 10px" valign="top" id="c-name"></td>
			</tr>
			<tr>
				<td style="width: 100px;padding: 5px">Modified</td>
				<td style="width: 10px;padding: 5px">:</td>
				<td style="padding: 10px" valign="top" id="m-name"></td>
			</tr>
			<tr>
				<td style="width: 100px;padding: 5px">Accessed</td>
				<td style="width: 10px;padding: 5px">:</td>
				<td style="padding: 10px" valign="top" id="a-name"></td>
			</tr>
			<tr style="border-top:1px #ddd solid;" id="contains-data">
				<td style="width: 100px;padding: 5px">Contains</td>
				<td style="width: 10px;padding: 5px">:</td>
				<td style="padding: 10px" valign="top">
					<span id="jml1-name"></span>, 
					<span id="jml2-name"></span>

				</td>
			</tr>

			<tr>
				<td style="width: 100px;padding: 5px">Permition</td>
				<td style="width: 10px;padding: 5px">:</td>
				<td style="padding: 10px" valign="top" id="p-name"></td>
			</tr>

			<tr>
			
		</table>

		<div style="margin-top: 10px;text-align: right;border-top:1px #ddd solid;padding-top: 10px;">
			<button class="btn btn-default" onClick="close_modal()"> Close</button>
		</div>

	</div>
	<!-- / properties -->

	<!-- manage user -->
	<div class="panel-body fly-box7" style="display: none;">
		<div style="border-bottom: 1px #ddd solid;margin-top: -10px;padding-top: 10px;margin-bottom:10px;padding-bottom:8px;">
			<span style="font-size: 20px;" id="copy-title">Manage User</span>
			<span style="float: right;">
				<table width="250" style="margin-top: -5px;" >
					<tr>
						
						<td style="padding: 3px;text-align: right;">
							<button class="btn btn-info" onClick="addUser()" ><i class="fas fa-plus"></i></button>
						</td>

				</table>
			</span>
		</div>
		<div id="list-user"><?php echo listUser() ?></div>
		<div id="config-user" style="display: none;"></div>
		<div id="adduser" style="display: none">
			<label>Username</label>
			<input id="add1" type="text" name="username" class="form-control" style="margin-bottom: 10px;" required="">
			
			<label>Password</label>
			<input id="add2" type="password" name="password" class="form-control" style="margin-bottom: 10px;" required="">
			
			<label>Project path</label>
			<input id="add3" type="text" name="project_path" class="form-control" style="margin-bottom: 10px;" required="">

			<label>Preview Project path</label>
			<input id="add4" type="text" name="preview_project_path" class="form-control" style="margin-bottom: 10px;">
			
			<label>Disallow Extention</label>
			<input id="add5" type="text" name="disallow" class="form-control" style="margin-bottom: 10px;">
		</div>
		<div style="margin-top: 10px;padding-top: 10px;">
			
			<button class="btn btn-danger" id="user-delete" type="button" style="display: none;" onClick=""><i class="fas fa-trash"></i></button>

			
			<span style="float:right">
				<button class="btn btn-info" id="user-save" type="button" style="display: none;" onClick=""> Save</button>
				<button class="btn btn-default" id="user-close" type="button" onClick="close_modal()"> Close</button>
			</span>
		</div>

	</div>
	<!-- / manage user -->


	<!---change permition-->
	<div class="panel-body fly-box8" style="display: none;">
		<div style="border-bottom: 1px #ddd solid;margin-top: -10px;padding-top: 10px;margin-bottom:10px;padding-bottom:5px;">
			<span style="font-size: 20px;" id="info-properties">Change Permition <span style="font-size: 15px;color:#666" id="text-file-name"></span></span>
		</div>
		
		
		<table width="100%">
			<tr>
				<td style="text-align: right;width:130px;padding: 5px;"></td>
				<td style="padding: 5px;text-align: center;font-size:17px;color:#666;font-weight:400">Owner</td>
				<td style="padding: 5px;text-align: center;font-size:17px;color:#666;font-weight:400">Group</td>
				<td style="padding: 5px;text-align: center;font-size:17px;color:#666;font-weight:400">Other</td>
			</tr>
			<tr>
				<td style="text-align: right;width:130px;padding: 5px;font-size:17px;color:#666;font-weight:400">Read (4)</td>
				<td style="padding: 5px;text-align: center;"><input class="4a" status="0" type="checkbox" act="1" data="4" onChange="return setChmod(this)"></td>
				<td style="padding: 5px;text-align: center;"><input class="4b" status="0" type="checkbox" act="2" data="4" onChange="return setChmod(this)"></td>
				<td style="padding: 5px;text-align: center;"><input class="4c" status="0" type="checkbox" act="3" data="4" onChange="return setChmod(this)"></td>
			</tr>
			<tr>
				<td style="text-align: right;width:130px;padding: 5px;font-size:17px;color:#666;font-weight:400">Write (2)</td>
				<td style="padding: 5px;text-align: center;"><input class="2a" status="0" type="checkbox" act="1" data="2" onChange="return setChmod(this)"></td>
				<td style="padding: 5px;text-align: center;"><input class="2b" status="0" type="checkbox" act="2" data="2" onChange="return setChmod(this)"></td>
				<td style="padding: 5px;text-align: center;"><input class="2c" status="0" type="checkbox" act="3" data="2" onChange="return setChmod(this)"></td>
			</tr>
			<tr>
				<td style="text-align: right;width:130px;padding: 5px;font-size:17px;color:#666;font-weight:400">Execute (1)</td>
				<td style="padding: 5px;text-align: center;"><input class="1a" status="0" type="checkbox" act="1" data="1" onChange="return setChmod(this)"></td>
				<td style="padding: 5px;text-align: center;"><input class="1b" status="0" type="checkbox" act="2" data="1" onChange="return setChmod(this)"></td>
				<td style="padding: 5px;text-align: center;"><input class="1c" status="0" type="checkbox" act="3" data="1" onChange="return setChmod(this)"></td>
			</tr>
			<tr>
				<td style="text-align: right;width:130px;padding: 5px;font-size:17px;color:#666;font-weight:400"></td>
				<td style="padding: 5px;text-align: center;font-size: 17px;"><button type="button" style="padding: 5px;background:#f5f5f5;color:#666;width: 50px;border-radius: 5px;border:1px #ddd solid;" class="conf1">0</button></td>
				<td style="padding: 5px;text-align: center;font-size: 17px;"><button type="button" style="padding: 5px;background:#f5f5f5;color:#666;width: 50px;border-radius: 5px;border:1px #ddd solid;" class="conf2">0</button></td>
				<td style="padding: 5px;text-align: center;font-size: 17px;"><button type="button" style="padding: 5px;background:#f5f5f5;color:#666;width: 50px;border-radius: 5px;border:1px #ddd solid;" class="conf3">0</button></td>
			</tr>
		</table>

			<div style="margin-top: 10px;text-align: right;border-top:1px #ddd solid;padding-top: 10px"><button type="submit" class="btn btn-info use-change" onClick="return change_permition()">Save Changes</button>
			<button type="button" onClick="close_modal()" class="btn btn-default">Cancel</button>
			</div>

	
	</div>
	<!--/change permition-->

	<!-- confirm delete -->
	<div class="panel-body fly-box9" style="display: none;">
	
	<table width="100%">
		<tr>
			<td valign="top" style="padding: 10px;">
				<i class="fas fa-exclamation-circle" style="font-size: 70px;color: #f5da2e">
			</td>
			<td valign="top" style="padding: 10px;">
				<div style="margin-bottom: 10px;" id="del-data-alert"></div>
				<button class="btn btn-info" onClick="save_delete_file()">Delete</button>
				<button class="btn btn-default" onClick="close_modal()">Cancel</button>
				<input type="text" id="file-data-selected" style="display: none;">
			</td>
		</tr>
	</table>
	</div>

	<!-- confirm delete -->


	<div class="panel-body fly-box10" style="display: none;">
	
	<center>
		<img src="{favicon}" width="200"> 
		<p style="font-weight:600;font-size:25px;">Mugencode</p>
		<p>Copyright &copy; 2017 - <?php echo date("Y")?><br>Iamroot Community BUild Version 1.0.4</p>
	</center>

	<div style="margin-top: 10px;text-align: right;border-top:1px #ddd solid;padding-top: 10px">
			<button type="button" onClick="close_modal()" class="btn btn-default">Close</button>
			</div>
	</div>

<div class="panel-body fly-box11" style="display: none;">
	<div style="overflow-y: scroll;height: 500px;">
	<h2 style="margin-top:0px;margin-bottom: 10px;">Mugencode Change Log</h2>
	<p>All changes, additions and improvements to the system will be presented in this window</p>
	<h4 style="background: #f9f9f9;padding: 7px;border:1px #ddd solid;"><b>1.0.4</b> <span style="color:#ccc;font-size:13px;font-weight: 400">August 24, 2019</span></h4>
	<ul>
		<li>Fix all bug and error</li>
		<li>Create Toolbar menu</li>
		<li>Added Undo Feture</li>
		<li>Added Redo Feture</li>
		<li>Added Find and Replace Feature</li>
		<li>Added Copy/Cut & Paste Text or file feature</li>
		<li>Remove old style of toolbar</li>
		<li>Added uniq file reader</li>
		<li>Improve time proccess of data</li>
		<li>Fixed Local File Distinc Bugs</li>
		<li>Fixed zip creator system</li>
		<li>Added input area focus on ready</li>
		<li>Added change file pertmition feature</li>
		<li>Added toolbar close all file</li>
		<li>Fixed upoload file progress</li>
		<li>Fixed bug of copy/cut and paste only using click</li>
		<li>Fixed file autory who allowed to add zip and to export</li>

	</ul>
	<h4 style="background: #f9f9f9;padding: 7px;border:1px #ddd solid;"><b>1.0.3</b> <span style="color:#ccc;font-size:13px;font-weight: 400">January 8, 2019</span></h4>
	<ul>
		<li>Added Chaptcha verified for login system</li>
		<li>Added switch project feture</li>
		<li>Added file properties</li>
	</ul>
	<h4 style="background: #f9f9f9;padding: 7px;border:1px #ddd solid;"><b>1.0.2</b> <span style="color:#ccc;font-size:13px;font-weight: 400">Agustus 25, 2018</span></h4>
	<ul>
		<li>Adds zip and extract zip features</li>
		<li>Added export data feature</li>
		<li>Blinds feature of viewing files based on their extent</li>
		<li>Create a system for adding users and deleting users</li>
		<li>Creating a security system and limiting health rights to each user</li>
		<li>Can lock user access</li>
		<li>Added tool bar preview file</li>
		<li>Added fiture Create File anda Directory</li>
	</ul>
	<h4 style="background: #f9f9f9;padding: 7px;border:1px #ddd solid;"><b>1.0.1</b> <span style="color:#ccc;font-size:13px;font-weight: 400">Marc 15, 2018</span></h4>
	<ul>
		<li>Create a context menu effect when right-clicking on the listing file</li>
		<li>Fix auto save which has problem in sending data</li>
		<li>Add manual save mode</li>
		<li>Make a navigation bar with 3 main menus, namely settings, browser, and preview</li>
		<li>Add file import feature</li>
		<li>Added file icon to file listing</li>
		<li>Added file rename featur</li>
		<li>Added file delete feture</li>
		<li>Added refresh featur</li>
		<li>Added color picker</li>
		<li>Added auto complete feture</li>

	</ul>
	<h4 style="background: #f9f9f9;padding: 7px;border:1px #ddd solid;"><b>1.0.0</b> <span style="color:#ccc;font-size:13px;font-weight: 400">December 20, 2017</span></h4>
	<ul>
		<li>Build basic system</li>
		<li>Integrated With Codemirror</li>
		<li>Improved the reading of the sysntax program</li>
		<li>Change the file access point to be dynamic</li>
		<li>Add auto save feature</li>
		<li>Added file icon to file listing</li>
		<li>Timezone synchronization</li>
		<li>Make a Small browser on the right side of the window</li>

	</ul>
</div>

	<div style="margin-top: 10px;text-align: right;border-top:1px #ddd solid;padding-top: 10px">
			<button type="button" onClick="close_modal()" class="btn btn-default">Close</button>
			</div>
	</div>

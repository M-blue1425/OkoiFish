<?php 

userspace();

// Get listing data


if(isset($_POST['path']) and !empty(trim($_POST['path']))){ 
	
	echo showFileName($_POST['path']); 

	echo '<script>

		$(".child-content").mousedown(function(event) {
			$("#active-select").val($(this).attr("realpath"));
		});

		set_base_path();

	</script>';
	
}else{
	
	$special_id = preg_replace("([:/. _])","-",DirSeparator(project_disk()->realpath)); 
	
	?>


<div type="parent" browse="<?=project_disk()->domainname?>" root="true" doctype="doc" status="hide" class="base-listing upload-area dir-name file-name file-name-<?=$special_id?> listing-box left-box" id="dir-<?=$special_id?>" name="" place="<?=$special_id?>" realpath="" style="background:#24282a">

	<div class="listing-box-body">
		<b style="font-size: 14px;margin-left: 14px;color:#f1f1f1">FOLDERS</b>

		<table class="newf" id="add-<?=$special_id?>" style="width:86%;display:none;z-index:1;margin-left: -5px;">
			<tr>
				<td style="width:20px;"></td>

				<td>
					<input class="form-control form-control-custom" type="text" id="input-<?=$special_id?>" style="border:1px #ccc solid;border-radius:4px;width:100%;padding-left:5px;font-size:12px;" Placeholder="New Folder">
				</td>

				<td style="width:50px;text-align:right">
					<i class="fas fa-check" style="cursor:pointer;" onClick="save_rename_file('<?=$special_id?>','doc','3','input','newdir')"></i>
					<i class="fas fa-times" style="cursor:pointer;" onClick="cancel_add('<?=$special_id?>','doc')"></i>
				</td>
			</tr>
			</table>

			<table class="newf" id="add1-<?=$special_id?>" style="width:86%;display:none;z-index:1;margin-left:-5px;">
			<tr>
				<td style="width:20px;"></td>

				<td>
					<input class="form-control form-control-custom" type="text" id="input1-<?=$special_id?>" style="border:1px #ccc solid;border-radius:4px;width:100%;padding-left:5px;font-size:12px;" Placeholder="New File">
				</td>

				<td style="width:50px;text-align:right">
					<i class="fas fa-check" style="cursor:pointer;" onClick="save_rename_file('<?=$special_id?>','doc','2','input1','newfile')"></i>
					<i class="fas fa-times" style="cursor:pointer;" onClick="cancel_add('<?=$special_id?>','doc')"></i>
				</td>

			</tr>
			</table>

		<ul class="listing-box-content">
			
			<?php 

			if(isset($_POST['path'])) 

				echo showFileName($_POST['path']);

			else 

				echo showFileName();
			?>

		</ul>
	</div>
</div>

<script>

	onready();

	$('.child-content').mousedown(function(event) {
		$("#active-select").val($(this).attr("realpath"));
	});

	set_base_path();

</script>

	<?php

}

	BlockFunction();

?>
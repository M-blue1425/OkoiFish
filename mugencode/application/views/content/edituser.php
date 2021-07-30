<?php 
if(isset($_POST['id'])) { 

$data = fetch_json(projectDir()."/userconfig/".$_POST['id'].".json");

?>

	<p>Project Path</p>
	<input type="text" id="d1" class="form-control" value="<?=$data->preview_path?>">
	<p></p>
	<p>Preview Url</p>
	<input type="text" id="d2" class="form-control" value="<?=$data->preview_url?>">
	<p></p>
	<p>Extention Danied</p>
	<input type="text" id="d3" class="form-control" value="<?=implode(",",$data->wipe_illegal_extention)?>">

<?php } ?>
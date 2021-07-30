
<?php 

$query = $this->db()->query("SELECT * FROM db_pay_info WHERE id='".$this->get("id")."' ");
$show = $query->fetch();

?>

<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>" Menu untuk mengubah informasi bank yang dapat gunakan oleh customer untuk mentransfer pembayaran"</i></p>

<form method="POST" action="<?php echo HomeUrl()?>/adminpanel/edit_bank?id=<?php echo $this->get("id")?>" enctype="multipart/form-data">
<table width="100%" style="">
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Bank Name</p>
			<p class="t2">* Nama bank</p>
		
		<input type="text" name="bank_name" class="form-input" required value="<?php echo $show['bank_name']?>"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Rekening Number</p>
		
		<input type="text" name="bank_info" class="form-input" required value="<?php echo $show['bank_info']?>"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Bank Code</p>
		
		<input type="text" name="code_bank" class="form-input" required value="<?php echo $show['code_bank']?>"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Account holder's name</p>
			<p class="t2">* Nama pemilik yang terdaftar pada rekening bank</p>
		
		<input type="text" name="atas_nama" class="form-input" required value="<?php echo $show['atas_nama']?>"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Bank Icon</p>
			<p class="t2">* Logo / icon dari bank untuk mempermudah pemahaman customer</p>
		

			
			<?php 

			if(empty($show['icon'])) $pict = sourceUrl()."/img/img-upload.png";
			else $pict = sourceUrl()."/bank/".$show['icon']; 

			?>

			<img src="<?php echo $pict?>" style="width: 75px;height:75px;cursor: pointer;" id="img-icon" onClick="click_upload('input-icon')">
				<input type="file" id="input-icon" name="icon" style="display: none;">
		</td>
	</tr>

	<tr>
		<td>
			
			<div style="border-top:2px #ddd dashed;height:20px;margin-top:20px;"></div>
			<button class="btn-white" type="submit" style="cursor:pointer;padding: 10px;font-size: 15px;">Save Bank Info</button>
		</td>
	</tr>

</table>

</form>
<?php 
$query = $this->db()->query("SELECT * FROM db_destination_address WHERE user_id='".userinfo()->user_id."'  and id='".$this->get("id")."' ");
$show = $query->fetch();
?>

<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>" Masukan alamat yang benar dan tepat untuk mempermudah dalam proses pengiriman barang pesanan anda "</i></p>

<form method="POST" action="<?php echo HomeUrl()?>/clientarea/rubahalamat?id=<?php echo $show['id']?>" enctype="multipart/form-data">
<table width="100%" style="">
	
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Nama Penerima</p>
			<p class="t2">* Nama penerima sesuai alamat yang anda masukkan</p>
		</td>
		<td><input type="text" name="nama_penerima" class="form-input" required value="<?php echo $show['nama_penerima']?>"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Alamat</p>
			<p class="t2">* Masukkan alamat lengkap</p>
		</td>
		<td><input type="text" name="address" class="form-input" required value="<?php echo $show['address']?>"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Provinsi</p>
		</td>
		<td>
			<select name="province" class="form-input" style="width: 99.5%">
				<?php 

					foreach(provinsi() as $key => $value){

						if($value == $show['province'])
						echo "<option value='$key'>$value</option>";

					}

				?>

				<?php 

					foreach(provinsi() as $key => $value){

						if($value !== $show['province'])
						echo "<option value='$key'>$value</option>";

						else $kode = $key;

					}

				?>
			</select>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Kabupaten / Kota</p>
		</td>
		<td>
			<select name="state" class="form-input" style="width: 99.5%">
				<?php 

					foreach(kabupaten($kode) as $key => $value){

						if($value == $show['state'])
						echo "<option value='$key'>$value</option>";

					}

				?>
				<?php 

					foreach(kabupaten($kode) as $key => $value){

						if($value !== $show['state'])
						echo "<option value='$key'>$value</option>";
						else $kode = $key;

					}

				?>
			</select>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Kecamatan</p>
		</td>
		<td>
			<select name="district" class="form-input" style="width: 99.5%">

				<?php 

					foreach(kecamatan($kode) as $key => $value){

						if($value == $show['district'])
						echo "<option value='$key'>$value</option>";

					}

				?>

				<?php 

					foreach(kecamatan($kode) as $key => $value){

						if($value !== $show['district'])
						echo "<option value='$key'>$value</option>";
						else $kode = $key;

					}

				?>
			</select>
		</td>
	</tr>


	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Kode Pos</p>
		</td>
		<td><input type="text" name="zip_code" class="form-input" required value="<?php echo $kode?>" readonly="" style="background: #f5f5f5"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Label</p>
		</td>
		<td>
			<input type="text" name="label" class="form-input" required value="<?php echo $show['label']?>">
			<span style="color:#666;font-size:12px;">Contoh : Rumah, Apatement, Kantor, Kos, Dll</span>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Nomor Telephone</p>
			<p class="t2">* Nomor telepon yang dapat di hubungi</p>
		</td>
		<td><input type="text" name="phone_number" class="form-input" required value="<?php echo $show['phone_number']?>"></td>
	</tr>

	<tr>
		<td></td>
		<td>
			<div style="border-top:2px #ddd dashed;height:20px;margin-top:20px;"></div>
			<button class="btn-white rebuild" type="submit" style="cursor:pointer;padding: 10px;font-size: 15px;">Simpan Alamat</button>
		</td>
	</tr>

</table>

</form>
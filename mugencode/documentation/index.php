<?php require_once("header.php"); ?>
	<div class="container">
		<div class="col-md-9">
	<div class="panel panel-info">
		<div class="panel-body">
			<h3 id="sc-0">Database Configuration</h3>
			<p>Untuk dapat mengkoneksikan PHP dengan MySQL database, anda perlu mengkonfigurasi data login ke MySQL dengan melakukan edit file <span class="text-orange">application/config/dbconfig.php</span> dengan konfigurasi seperti berikut ini.
			<div class="alert alert-info">
				<?php echo highlight_file("source/dbconfig.txt") ?>
			</div>
			<h3 id="sc-1">Rewrite Url</h3>
			<p>Merewrite url seperti layaknya yang dilakukan oleh file <span class="text-orange">.htaccess</span> sebagai contoh misalkan anda mengakses <span class="text-orange">http://namadomain.com/url-custom</span> maka akan merewrite menuju file tertentu. Hal tersebut bisa anda lakukan dengan merubah konfigurasi seperti berikut ini.</p>
			<img src="image/url-bar.PNG" width="100%" height="40" class="thumbnail">
			<p class="step">Buka File <span class="text-orange">application/config/controller/config.php</span></p>
			<p>Setelah itu masukan konfigurasi seperti contoh berikut ini :</p>
			<div class="alert alert-info">
				<?php echo highlight_file("source/controller.txt") ?>
			</div>
			<p>Jika dilihat seperti contoh diatas, maka jika anda mengakses <span class="text-orange">http://namadomain.com/rewrite-url</span> maka file yang akan terbuka yaitu file yang berada pada <span class="text-orange">application/views/path_file_to_rewrite.php</span>. Lalu jika anda ingin membuatnya tereksekusi berdasarkan device yang digunakan untuk mengakses url tersebut, anda bisa mengubahnya seperti konfigusai dibawah ini.</p>
			<div class="alert alert-info">
				<?php echo highlight_file("source/controller1.txt") ?>
			</div>
			<p>setelah memasukan konfigurasi tersebut, selanjutnya buatlah 2 folder di dalam <span class="text-orange">application/views/</span> yang bernama <span class="text-orange">desktop</span> dan <span class="text-orange"> mobile</span> dan letakan file yang di rewrite berdasarkan konfigurasi yang anda masukan seperti contoh di atas yaitu file <span class="text-orange">path_file_to_rewrite.php</span> ke dalam kedua folder yang baru dibuat tersebut.<br><br>
				<img src="image/listing.PNG" width="100%" class="thumbnail">
				
			Jika anda mengaksesnya melalui perangkat mobile, maka file <span class="text-orange">path_file_to_rewrite.php</span> yang akan ter-eksekusi yaitu file yang berada didalam folder <span class="text-orange">mobile/path_file_to_rewrite.php</span> dan begitu pula sebaliknya.
				<br><br>
				
				Anda juga bisa mengatur aksesnya secara lebih spesifik dengan memasukkan konfigurasi seperti berikut ini
			</p>
			<div class="alert alert-info">
				<?php echo highlight_file("source/controller3.txt") ?>
			</div>
			<p>Berdasarkan konfigurasi di atas, maka system akan membaca path aksesnya secara static. Jika kita menggunakan <span class="text-orange">"amp"</span> seperti konfigurawsi sebelumnya, itu akan membuat sistem mengalihkan pathnya secara otomatis. Dan jika anda memasukkan konfigurasi devicenya secara spesific seperti contoh diatas, maka jika anda memasukkan konfigurasi rewritenya hanya untuk desktop, maka anda tidak dapat membukanya jika anda mengaksesnya menggunakan perangkat mobile dan hanya bisa diakses jika anda menggunakan perangkat mobile dan begitupun sebaliknya.</p>

			<h3 id="sc-1-1">Membuat Halaman 404</h3>
			<p>halaman 404 adalah halaman yang menunjukan bahwa document yang anda akses tidak ada sehingga memberikan umpan balik berupa header response code 404. Anda cukup membuat file <span class="text-orange">404.php</span> pada <span class="text-orange">application/views/</span> atau jika anda menyeting rewrite rulesnya <span class="text-orange">"amp"</span> anda cukup membuat <span class="text-orange">404.php</span> didalam folder <span class="text-orange">mobile / desktop</span></p>

			<h3 id="sc-2">Custom Fungsi</h3>
			<p>Jika anda membutuhkan suatu fungsi tertentu dan ingin membuat fungsi tersebut, anda bisa membuatnya pada <span class="text-orange">application/controller/</span></p>
			<div class="alert alert-info">
				<?php echo highlight_file("source/action.txt") ?>
			</div>
			<p>Dibuat, anda dapat memanggil dan menggunakan fungsi tersebut pada file yang sama ataupun pada project yang berada di <span class="text-orange">application/views/</span></p>
			
			<h3 id="sc-3">PHP Mailer</h3>
			<p>Mengirim e-mail yang terintegrasi dengan PHP Source Code dengan cara penggunaan seperti dibawah ini</p>
			
			<div class="alert alert-info">
				<?php echo highlight_file("source/phpmailer.txt") ?>
			</div>
			<h3 id="sc-4">Create QR Code</h3>
			<p>QR adalah salah satu jenis kode matriks atau kode batang dua dimensi yang dikembangkan Denso Wave, Denso Wave adalah sebuah divisi di perusahaan Denso Corporation Jepang, QR Code pertama kali dipublikasikan pada tahun 1994. Sedangkan perangkat yang digunakan untuk membaca QR Code disebut QR Scaner, atau pemindai QR<br><br>
			Untuk cara penggunaan fungsi untuk menggenerate QRcode Image, lihatlah contoh konfigurasinya seperti dibawah ini.
			</p>
			<div class="alert alert-info">
				<?php echo highlight_file("source/qrcode.txt") ?>
			</div>
			
			<p><b>1.</b> <span class="text-orange">$QR->url</span> akan menampilkan url dari gambar QR yang telah berhasil tergenerate<br>
			<b>2.</b> <span class="text-orange">$QR->image</span> akan menampilkan gambar dari QRcode yang telah tergenerate<br>
				
				<b>3.</b> <span class="text-orange">$text</span> value yang akan disimpan ke dalam QRCode<br>
				<b>4.</b> <span class="text-orange">$width</span> Lebar gambar QRcode yang akan di generate<br>
				<b>5.</b> <span class="text-orange">$height</span> Tinggi gambar QRcode yang akan di generate<br>
				<b>6.</b> <span class="text-orange">$filename</span> namafile gambar QRcode yang akan disimpan<br>
				<b>7.</b> <span class="text-orange">$save_path</span> Alamat menyimpan gambar Qrcode
			<br><br>
				anda bisa mengosongkan beberapa paramater yang memiliki nilai default dan anda hanya wajib mengisi paramater <span class="text-orange">$text</span> sebagai string yang akan dikonversi ke dalam QRcode dan paramater sisanya besifat optional.
			</p>
			<h3 id="sc-5">ZIP & UnZIP</h3>
			<b>Create ZIP</b>
			<p>Anda dapat mengkompresi file ataupun folder kedalam suatu zip compresiion dengan konfigurasi penggunaan sebagai berikut ini : </p>
			<div class="alert alert-info">
				<?php echo highlight_file("source/zip.txt") ?>
			</div>
			
			<b>Extract ZIP</b>
			<p>Anda dapat mengextract atau mendekompresi file berformat zip</p>
			<div class="alert alert-info">
				<?php echo highlight_file("source/unzip.txt") ?>
			</div>
			<p>Untuk melakukan kedua action tersebut, anda harus memberikan permition file / dir </p>
			<h3 id="sc-6">Generate Captcha</h3>
			<p>Mengenerate kode unik untuk meverifikasi sebelum melakukan request dengan penggunaan sebagai berikut</p>
			<div class="alert alert-info">
				<?php echo highlight_file("source/captcha.txt") ?>
			</div>
			
			<h3 id="sc-7">Generate MD5</h3>
			<p>Dapat hashing dan un </p>
			<div class="alert alert-info">
				<?php echo highlight_file("source/captcha.txt") ?>
			</div>
			
			<h3 id="sc-8">Query</h3>
			<div class="alert alert-info">
				<?php echo highlight_file("source/query.txt") ?>
			</div>

			<h3 id="sc-9">Date & Time</h3>
			<p>Mengatur waktu yang diperlukan seperti untuk mendapatkan waktu yang telah berlalu atau mendapatkan waktu yang telah berlalu secara spesifik seperti hanya menampilkan waktu berupa detik, menit, jam, hari, minggu, tahun.<br><br>
			<b>Untuk Mendapatkan Perhitungan Waktu YAng Telah Berlalu</b>
			<div class="alert alert-info">
				<?php echo highlight_file("source/date.txt") ?>
			</div>
			<p>Untuk menampilkan waktu secara spesifik anda perlu memasukan konfigurasi pada paramater ke tiga yaitu dengan pilihan sebagai berikut.
				<br><br>
			<b>1.</b> <span class="text-orange">second</span> mendapatkan hasil dalam satuan waktu detik<br>
			<b>2.</b> <span class="text-orange">minute</span> mendapatkan hasil dalam satuan waktu menit<br>
			<b>3.</b> <span class="text-orange">hour</span> mendapatkan hasil dalam satuan waktu jam<br>
			<b>4.</b> <span class="text-orange">day</span> mendapatkan hasil dalam satuan waktu hari<br>
			<b>5.</b> <span class="text-orange">week</span> mendapatkan hasil dalam satuan waktu minggu<br>
			<b>6.</b> <span class="text-orange">Year</span> mendapatkan hasil dalam satuan waktu tahun<br>

			</p>
			<p><b>Mengkonversi angka ke bulan dan sebaliknya</b></p>
			<div class="alert alert-info">
				<?php echo highlight_file("source/date1.txt") ?>
			</div>
			<h3 id="sc-10">Directory Action</h3>
			<p><b>Scan Directory</b></p>
			<div class="alert alert-info">
				<?php echo highlight_string("<?php scan_dir('directory path') ?>") ?>
			</div>
			<p>menghasilkan keluaran array<br><br>
				<b>Literator Scan</b>
			</p>

			<p>fungsi ini berguna untuk melakukan scaning data / file sampai ke bagian terdalamnya</p>
			<div class="alert alert-info">
				<?php echo highlight_string("<?php LiteratorScan('directory path') ?>") ?>
			</div>
			<p>menghasilkan keluaran array<br><br>
				<b>Menghitung Ukuran Folder</b>
			</p>
			<div class="alert alert-info">
				<?php echo highlight_string("<?php CalcDirectorySize('directory path') ?>") ?>
			</div>
			<p>Menghasilkan output berupaka ukuran dari size folder yang dihitung</p>
			<p><b>Menghitung jumlah file di dalam folder</b></p>
			<div class="alert alert-info">
				<?php echo highlight_string("<?php CountFile('directory path') ?>") ?>
			</div>
			<p>Menghasilkan output berupa jumlah file yang dihitung dalam folder</p>
			<p><b>Mengcopy / menggandakan folder</b></p>
			<div class="alert alert-info">
				<?php echo highlight_string("<?php CopyDirectory('directory path asal', 'directory path tujuan') ?>") ?>
			</div>
			<p><b>Menghapus Bug LFD atau Local File Distinc</b></p>
			<div class="alert alert-info">
				<?php echo highlight_string("<?php DirSeparator('path') ?>") ?>
			</div>
			<h3 id="sc-11">Force Download</h3>
			<div class="alert alert-info">
				<?php echo highlight_string("<?php force_download('path file') ?>") ?>
			</div>



		</div>
	</div>
	</div>
</div>
	
<?php require_once("footer.php"); ?>
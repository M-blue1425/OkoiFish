<?php 
$query = $this->db()->query("SELECT * FROM db_custom_page WHERE id='".splice(3)."'");
$show = $query->fetch();

if($show['contact_form'] > 0){
	$class1 = "col-lg-7";
}else{
	$class1 = "col-lg-12";
}
?>
<div class="container" style="margin-top: 70px;padding: 0px;">
<div style="border:1px #ddd solid;background: #fff;">

		<div class="<?php echo $class1?>" style="padding:10px;">
			<h3 style="color:#434343;padding: 5px;font-size: 18px;"><?php echo $show['title']?></h3>
			<p style="padding: 10px;font-weight: 400;color:#666;padding-top:0px;padding-bottom: 0px;margin-top:20px;margin-bottom: 4px;"><?php echo date("d M Y, H:i", $show['date_time'])?></p>

			<div style="float:right;margin-top: -37px;margin-bottom: 20px;">
					<ul class="product_sorting" style="position: relative;">
							<li style="text-align: left;width: 140px;border:transparent;">
								<div class="type_sorting_text" style="float: right;border:1px #ccc solid;border-radius: 10px;width: 40px;height: 40px;margin-right:-12px;">
									<img src="<?php echo sourceUrl()?>/media/share.png" width="24" style="margin-left:7px;margin-top:-2px;">
								</div>
								<ul class="sorting_type" style="border:1px #ddd solid;border-radius: 10px;margin-top:10px;padding-top: 10px;width: 140px;">

									

									<?php 

									$ln = "https://social-plugins.line.me/lineit/share?url=".urlencode(documentUrl())."&text=".urlencode($this->get_title());

									$fb = "https://www.facebook.com/sharer/sharer.php?u=".urlencode(documentUrl());

									$tw = "https://twitter.com/intent/tweet?text=".urlencode($this->get_title())."&url=".urlencode(documentUrl());

									?>
									
									<li class="type_sorting_btn" style="text-align:left;">
										<p style="font-weight: 400;font-size: 13px" onClick="window.open('<?php echo $fb?>','share','toolbar=0,status=0,width=550,height=400')"><img src="<?php echo sourceUrl()?>/media/fb.png" style="width:20px;height:20px;border-radius: 5px;margin-right: 10px;">
											Facebook
										</p>

										<p style="font-weight: 400;font-size: 13px" onClick="window.open('<?php echo $tw?>','share','toolbar=0,status=0,width=550,height=400')"><img src="<?php echo sourceUrl()?>/media/tw.png" style="width:20px;height:20px;border-radius: 5px;margin-right: 10px;">
											Twitter
										</p>

										<p style="font-weight: 400;font-size: 13px" onClick="window.open('<?php echo $ln?>','share','toolbar=0,status=0,width=550,height=400')"><img src="<?php echo sourceUrl()?>/media/ln.png" style="width:20px;height:20px;border-radius: 5px;margin-right: 10px;">
											Line
										</p>

										<p style="font-weight: 400;font-size: 13px" onClick="copy_link()"><img src="<?php echo sourceUrl()?>/media/link.png" style="width:20px;height:20px;border-radius: 5px;margin-right: 10px;">
											Salin Url
										</p>
									</li>

								</ul>
							</li>
						</ul>
					</div>

			<?php if(!empty($show['img'])){ ?>

				<p style="text-align: center;">
				<img src="<?php echo sourceUrl()?>/website/<?php echo $show['img']?>" style="width: 100%;border-radius: 3px;border:1px #ddd solid;">
				</p>

			<?php } ?>
			<div style="padding: 5px;"><?php echo str_replace("../sources/",HomeUrl()."/sources/",$show['content']) ?></div>

			<div style="margin-top: 17px;margin-bottom: 20px;">
					<ul class="product_sorting" style="position: relative;">
							<li style="text-align: left;width: 140px;border:1px #ddd solid;border-radius: 3px;">
								<span class="type_sorting_text loc-name">
									<img src="<?php echo sourceUrl()?>/media/share.png" width="20" style="margin-right:10px;color:#666;"> Bagikan
								</span>
								<i class="fa fa-angle-down" ></i>
								<ul class="sorting_type" style="border:1px #ddd solid;border-radius: 10px;margin-top:10px;padding-top: 10px;width: 140px;">

									

									<?php 

									$ln = "https://social-plugins.line.me/lineit/share?url=".urlencode(documentUrl())."&text=".urlencode($this->get_title());

									$fb = "https://www.facebook.com/sharer/sharer.php?u=".urlencode(documentUrl());

									$tw = "https://twitter.com/intent/tweet?text=".urlencode($this->get_title())."&url=".urlencode(documentUrl());

									?>
									
									<li class="type_sorting_btn" style="text-align:left;">
										<p style="font-weight: 400;font-size: 13px" onClick="window.open('<?php echo $fb?>','share','toolbar=0,status=0,width=550,height=400')"><img src="<?php echo sourceUrl()?>/media/fb.png" style="width:20px;height:20px;border-radius: 5px;margin-right: 10px;">
											Facebook
										</p>

										<p style="font-weight: 400;font-size: 13px" onClick="window.open('<?php echo $tw?>','share','toolbar=0,status=0,width=550,height=400')"><img src="<?php echo sourceUrl()?>/media/tw.png" style="width:20px;height:20px;border-radius: 5px;margin-right: 10px;">
											Twitter
										</p>

										<p style="font-weight: 400;font-size: 13px" onClick="window.open('<?php echo $ln?>','share','toolbar=0,status=0,width=550,height=400')"><img src="<?php echo sourceUrl()?>/media/ln.png" style="width:20px;height:20px;border-radius: 5px;margin-right: 10px;">
											Line
										</p>

										<p style="font-weight: 400;font-size: 13px" onClick="copy_link()"><img src="<?php echo sourceUrl()?>/media/link.png" style="width:20px;height:20px;border-radius: 5px;margin-right: 10px;">
											Salin Url
										</p>
									</li>

								</ul>
							</li>
						</ul>
					</div>

		</div>



</div>

<div style="border:1px #ddd solid;background: #fff;margin-bottom:20px;margin-top:10px;">

<div class="breadcrumbs d-flex flex-row align-items-center" style="padding:10px;font-weight: 600;font-size:16px;">
	Artikel Lainnya
</div>



<div style="padding: 10px;margin-top: -70px;">
<?php 
$query = $this->db()->query("SELECT * FROM db_custom_page WHERE level=2 and status=1 ORDER BY RAND() LIMIT 20");
while($show = $query->fetch()){ 
	$url = HomeUrl()."/blog/".url_title($show['title'],"-",true)."/".$show['id'];
	?>

	<a href="<?php echo $url?>"><p style="border-bottom: 1px #ddd dashed;padding-bottom: 10px;font-weight: 400"><?php echo strip_tags($show['title']) ?></p></a>

<?php } ?>
</div>
</div>

</div>
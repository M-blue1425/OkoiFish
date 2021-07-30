<div id="result-box" class="result-area" style="z-index: 7;"></div>

<div id="result-box1" class="result-area" style="z-index: 6;border-left:transparent;"></div>

	<div class="panel panel-default panel-result" >
		<div class="panel-heading" style="padding: 10px">
			<table width="70%">
				<tr>
					<td style="width: 40px;">
					
						<button onClick="load_page_result()" id="load1" class="btn-run-browser-ssl" style="display: none;">
							<img src="<?=projectUrl()?>/assets/img/ovalo-black.svg" width="20">
						</button>

						<button onClick="load_page_result()" id="load2" class="btn-run-browser-ssl">
							<i class="fas fa-lock" style="font-size: 20px;color:#3bb810"></i>
						</button>

					</td>

					<td style="width: 90%">
						<input type="text" id="url-load" class="form-control browser-url-form" name="url" style="" placeholder="Url ..." value="<?php echo project_disk()->domainname?>">
					</td>

					<td style="width: 30px;">
						<button onClick="load_page_result()" class="btn-run-browser">
							<i class="fas fa-search icon-run"></i>
						</button>
					</td>
				</tr>
			</table>

		<span style="float:right;margin-top:-33px;margin-right:5px">
			
			<button onClick="panel_result('hide')" class="btn btn-default btn-browser">
				<i class="fas fa-window-minimize"></i>
			</button>

			<button onClick="panel_result('window')" class="btn btn-default btn-browser">
				<i class="fas fa-window-maximize"></i>
			</button>

			<button onClick="window_open()" class="btn btn-default btn-browser">
				<i class="fas fa-window-restore"></i>
			</button>

		</span>

		</div>

		<div id="box-area-result">

				<iframe id='iframe' style='width:100%;height:100%;border:transparent'></iframe>

		</div>
	</div>

<div class="panel panel-default navbar-tool">
	<span class="navbar-tool-left">
		<span class="navbar-tool-logo-container" >
			<img src="{favicon}" class="navbar-tool-logo-img"> 
			
			<table class="toolbar-menu" >
				<tr>
					<td><div class="toolbar-title" onClick="show_toolbox('file')">File</div>
						<div class="toolbar-box tool-file" >
							<ul class="list-toolbar">
								<li onClick="toolbar('newfile')"><i class="fas fa-file"></i> New File </li>
								<li onClick="toolbar('newdir')"><i class="fas fa-folder-open"></i> New Dir </li>
								<li onClick="toolbar('import')" class="line-break"><i class="fas fa-cloud-download-alt"></i> Import File</li>
								<li onClick="toolbar('export')"><i class="far fa-arrow-alt-circle-up"></i> Export to Zip</li>
								<li onClick="toolbar('save')" class="line-break save-act"><i class="fas fa-save"></i> Save File <span>Ctrl + S</span></li>
								<li onClick="set_setting(1,'real-mod')"><i class="fas fa-sync-alt"></i> Auto Save Mode {real-set}</li>
								<li onClick="toolbar('close')" class="line-break close-act"><i class="fas fa-times"></i> Close File <span>Ctrl + Q</span></li>
								<li onClick="toolbar('close-all')" class="close-all-act"><i class="fas fa-times-circle"></i> Close All Files</li>
							</ul>
						</div>
					</td>
					<td>
						<div class="toolbar-title" onClick="show_toolbox('edit')">Edit</div>
						<div class="toolbar-box tool-edit" >
							<ul class="list-toolbar">
								<li onClick="toolbar('')"><i class="fas fa-undo"></i> Undo <span>Ctrl + Z</span></li>
								<li onClick="toolbar('')"><i class="fas fa-redo"></i> Rendo <span>Ctrl + U</span></li>
								<li onClick="toolbar('copy')" class="line-break"><i class="fas fa-copy"></i> Copy <span>Ctrl + C</span></li>
								<li onClick="toolbar('')"><i class="fas fa-expand-arrows-alt"></i> Move <span>Ctrl + X</span></li>
								<li onClick="toolbar('')"><i class="fas fa-paste"></i> Paste <span>Ctrl + V</span></li>
							</ul>
						</div>
					</td>
					<td>
						<div class="toolbar-title" onClick="show_toolbox('find')">Find</div>
						<div class="toolbar-box tool-find" >
							<ul class="list-toolbar">
								<li onClick="toolbar('search')"><i class="fas fa-search"></i> Find <span>Ctrl + F</span></li>
								<li onClick="toolbar('replace')"><i class="fas fa-clipboard"></i> Replace <span>Ctrl + H</span></li>
							</ul>
						</div>
					</td>
					<td>
						<div class="toolbar-title" onClick="show_toolbox('view')">View</div>
						<div class="toolbar-box tool-view" >
							<ul class="list-toolbar">
								<li onClick="toolbar('browser')"><i class="fas fa-globe"></i> Open Browser </li>
								<li onClick="toolbar('refresh')"class="line-break"><i class="fas fa-sync-alt"></i> Refresh Data <span>Ctrl + R</span></li>
							</ul>
						</div>
					</td>
					<td>
						<div class="toolbar-title" onClick="show_toolbox('preference')">Preference</div>
						<div class="toolbar-box tool-preference" >
							<ul class="list-toolbar">

								<?php if(config()->level < 2){ ?>
								<li onClick="toolbar('')" style="color:#ccc"><i style="color:#80C3FF" class="fas fa-users"></i> Manage User</li>
								<?php }else{ ?>
								<li onClick="toolbar('manage-user')"><i class="fas fa-users"></i> Manage User</li>
								<?php } ?> 
								<li onClick="toolbar('change-pass')"><i class="fas fa-key"></i> Change Password</li>
								<li class="line-break" onClick="toolbar('logout')"><i class="fas fa-power-off"></i> Logout</li>
							</ul>
						</div>
					</td>
					<td>
						<div class="toolbar-title" onClick="show_toolbox('help')">Help</div>
						<div class="toolbar-box tool-help" >
							<ul class="list-toolbar">
								<?php if(config()->level < 2){ ?>
									<li onClick="toolbar('')" style="color:#ccc"><i style="color:#80C3FF" class="fas fa-file"></i> Switch project</li>
								<?php }else{ ?>
									<li onClick="toolbar('switch')"> <i class="fas fa-file"></i> Switch project</li>
								<?php } ?>
								
								<li onClick="toolbar('')" class="line-break" style="color:#ccc"><i style="color:#80C3FF" class="fas fas fa-sitemap"></i> Documentation</li>
								<li onClick="toolbar('')" style="color:#ccc"><i style="color:#80C3FF" class="fas fa-code-branch"></i> Fork Me</li>
								<li onClick="toolbar('log')"><i class="far fa-sticky-note"></i> Change Log</li>
								<li onClick="toolbar('about')" class="line-break"><i class="fas fa-info-circle"></i> About Mugencode</li>
							</ul>
						</div>
					</td>
				</tr>
			</table>

		</span>
	</span>

</div>

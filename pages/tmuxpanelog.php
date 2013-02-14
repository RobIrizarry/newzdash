<?php
	if ( isset($_SESSION['total']) )
		$_SESSION['total'] = 0;
?>
			<!-- breadcrumbs end -->
			<div class="breadcrumb">
				<h2>TMUX Pane Log</h2><hr style="color:#000000; background-color:#000000; height:3px;"><br />
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td width="5%">
							<div align="center"><strong>Log ID</strong></div>
						</td>
						<td width="50%">
							<div align="center"><strong>Pane Name</strong></div>
						</td>
						<td width="30%">
							<div align="center"><strong>State</strong></div>
						</td>
						<td>
							<div align="center"><strong>Time Date</strong></div>
						</td>
					</tr>
				</table>
						
				<div id="list" style="overflow:scroll; overflow-x:hidden; height:500px;">
				</div>
				<br />
			</div>

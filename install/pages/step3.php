	<!-- breadcrumbs end -->
	<div class="breadcrumb">
		<h2>NewzDash Install - Step Three</h2><br /><strong>Database and Newznab Location Setup</strong><hr style="color:#000000; background-color:#000000; height:3px;">
		<div align="left">
			<?php
				if ( $config->hasError ) {
					echo "<font color=\"#ff4444\"><strong>Errors Exist:</strong></font><br />";
					for ( $i=0 ; $i<count($config->errorText) ; $i++ )
					{
						echo ( $config->errorText[$i] . "<br />" );
					}
					
					echo ( "<hr style=\"color:#000000; background-color:#000000; height:3px;\">" );
				}
			?>
			<form action="" method="post">
			
				<h3 style="display:inline;">MySQL Configuration</h3><br />
				<strong>Newznab Database Configuration:</strong>
				<table border="0" bordercolor="" style="background-color:" width="350" cellpadding="3" cellspacing="3">
					<tr>
						<td><div align="right">Hostname</div></td>
						<td><div align="left"><input type="text" name="db_host" value="<?php echo ( $config->DB_NNDB_HOST ); ?>"></div></td>
					</tr>
					<tr>
						<td><div align="right">Port</div></td>
						<td><div align="left"><input type="text" name="db_port" value="<?php echo ( $config->DB_NNDB_PORT ); ?>"></div></td>
					</tr>
					<tr>
						<td><div align="right">User</div></td>
						<td><div align="left"><input type="text" name="db_user" value="<?php echo ( $config->DB_NNDB_USER ); ?>"></div></td>
					</tr>
					<tr>
						<td><div align="right">Password</div></td>
						<td><div align="left"><input type="text" name="db_password" value="<?php echo ( $config->DB_NNDB_PASS ); ?>"></div></td>
					</tr>
					<tr>
						<td><div align="right">Database</div></td>
						<td><div align="left"><input type="text" name="db_name" value="<?php echo ( $config->DB_NNDB_DBNAME ); ?>"></div></td>
					</tr>
				</table>
				<br />
				<strong>NewzDash Database Configuration:</strong></br>
				<strong>Note:</strong> This database needs to be created before hand, this installer will not create it for you.<br />
				<table border="0" bordercolor="" style="background-color:" width="350" cellpadding="3" cellspacing="3">
					<tr>
						<td><div align="right">Hostname</div></td>
						<td><div align="left"><input type="text" name="nddb_host" value="<?php echo ( $config->DB_NDDB_HOST ); ?>"></div></td>
					</tr>
					<tr>
						<td><div align="right">Port</div></td>
						<td><div align="left"><input type="text" name="nddb_port" value="<?php echo ( $config->DB_NDDB_PORT ); ?>"></div></td>
					</tr>
					<tr>
						<td><div align="right">User</div></td>
						<td><div align="left"><input type="text" name="nddb_user" value="<?php echo ( $config->DB_NDDB_USER ); ?>"></div></td>
					</tr>
					<tr>
						<td><div align="right">Password</div></td>
						<td><div align="left"><input type="text" name="nddb_password" value="<?php echo ( $config->DB_NDDB_PASS ); ?>"></div></td>
					</tr>
					<tr>
						<td><div align="right">Database</div></td>
						<td><div align="left"><input type="text" name="nddb_name" value="<?php echo ( $config->DB_NDDB_DBNAME ); ?>"></div></td>
					</tr>
				</table>
				<br />
				<h3 style="display:inline;">Newznab Configuration</h3>
				<table border="0" bordercolor="" style="background-color:" width="350" cellpadding="3" cellspacing="3">
					<tr>
						<td><div align="right">Newznab Path</div></td>
						<td><div align="left"><input type="text" name="nn_path" value="<?php echo ( $config->NEWZNAB_DIR ); ?>"></div></td>
					</tr>
					<tr>
						<td><div align="right">Newznab URL</div></td>
						<td><div align="left"><input type="text" name="nn_url" value="<?php echo ( $config->NNURL ); ?>"></div></td>
					</tr>
				</table>
				<br />
				<h3 style="display:inline;">Newzdash Configuration</h3>
				<table border="0" bordercolor="" style="background-color:" width="350" cellpadding="3" cellspacing="3">
					<tr>
						<td><div align="right">Update Rate</div></td>
						<td><div align="left"><input type="text" name="nd_jsupdate_delay" value="<?php echo ( $config->JSUPDATE_DELAY ); ?>"></div></td>
					</tr>
				</table>
				<br />
				<h3 style="display:inline;">TMUX Configuration</h3>
				<br /><strong>Make a note of this shared secret, or create your own for input into defaults.sh of your TMUX install</strong><br />
				<table border="0" bordercolor="" style="background-color:" width="350" cellpadding="3" cellspacing="3">
					<tr>
						<td><div align="right">Shared Secret</div></td>
						<td><div align="left"><input type="text" name="tmux_shared_secret" value="<?php echo ( $config->TMUX_SHARED_SECRET ); ?>"></div></td>
					</tr>
				</table>
				<h3 style="display:inline;">Cache Configuration</h3>
				<?php
					if ( $config->CACHE_METHOD == "memcache" || ($config->getCacheMethodsFromSystem(true) == "memcache" && $config->CACHE_METHOD == "-2") )
					{
						echo ( "<table border=\"0\" bordercolor=\"\" style=\"background-color:\" width=\"350\" cellpadding=\"3\" cellspacing=\"3\">
							<tr>
								<td><div align=\"right\">Memcache IP</div></td>
								<td><div align=\"left\"><input type=\"text\" name=\"memcache_server\" value=\"" . $config->MEMCACHE_SERVER . "\"></div></td>
							</tr>
							<tr>
								<td><div align=\"right\">Memcache Port</div></td>
								<td><div align=\"left\"><input type=\"text\" name=\"memcache_port\" value=\"" . $config->MEMCACHE_PORT . "\"></div></td>
							</tr>
						</table>" );
					}else{
						if ( $config->CACHE_METHOD != "-3" )
						{
							if ( $config->CACHE_METHOD != "-2" )
							{
								echo "<br />" . $config->CACHE_METHOD . " does not require any extra configuration.";
							}else{
								echo "<br />You are letting the system decide the best caching method, good for you!";
							}
						}else{
							echo "<br />You have not installed a cache method, for this is bad!";
						}
					}
				?>
				
				<div align="center">
				<input type="submit" value="Next Step" />
				</div>
				<input type="hidden" name="step" value="3">
			</form>
		</div>
	</div>
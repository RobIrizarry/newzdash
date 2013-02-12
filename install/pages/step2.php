<?php
	
	// Do writeable checks here
	$canWriteConfig = false;
	$canWritexcache = false;
	$hasErrored = false;
	if ( is_writeable($config->WWW_DIR) )
	{
		$canWriteConfig = true;		
	}else{
		$hasErrored = true;
	}
	
	if ( ini_get("xcache.var_size") != "0" )
	{
		$canWritexcache = true;
	}else{
		$hasErrored = true;
	}

?>
	<div class="breadcrumb">
		<h2>NewzDash Install - Step Two</h2><br /><strong>Permissions and Functionality Check</strong><hr style="color:#000000; background-color:#000000; height:3px;">
		<br />
		<strong>config.php writeable check</strong><br />
		- File Path: <?php echo ( $config->WWW_DIR.'/config.php' ); if ( $canWriteConfig ) { echo ( " - <font color=\"#00ff00\">Okay</font>" ); } else { echo ( " - <font color=\"#ff0000\">Error!</font><br /> -- Fix: chmod 0777 " . WWW_DIR."/" ); } ?>
		<br /><br />
		<strong>xcache Variable Cache Size check</strong><br />
		- <?php if ( $canWritexcache ) { echo ( "<font color=\"#00ff00\">xcache Var Size Okay.</font>" ); } else { echo ( "xcache.var_size is 0 (zero), please modify this value to 16M or more." ); } ?>
		<div align="center">
		
		<?php
			if ( $hasErrored )
			{
				echo ( "<form action=\"\" method=\"post\">
					<input type=\"submit\" value=\"Retry\" />
					<input type=\"hidden\" name=\"step\" value=\"1\">
				</form>" );
			}else{
				echo ( "<form action=\"\" method=\"post\">
					<input type=\"submit\" value=\"Next Step\" />
					<input type=\"hidden\" name=\"step\" value=\"2\">
				</form>" );
			}
		?>
			
		</div>
	</div>
	


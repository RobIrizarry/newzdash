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
	
	$cacheMethods = $config->getCacheMethodsFromSystem();
?>
	<div class="breadcrumb">
		<h2>NewzDash Install - Step Two</h2><br /><strong>Permissions and Functionality Check</strong><hr style="color:#000000; background-color:#000000; height:3px;">
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
		<br />
		<strong>config.php writeable check</strong><br />
		- File Path: <?php echo ( $config->WWW_DIR.'/config.php' ); if ( $canWriteConfig ) { echo ( " - <font color=\"#00ff00\">Okay</font>" ); } else { echo ( " - <font color=\"#ff0000\">Error!</font><br /> -- Fix: chmod 0777 " . $config->WWW_DIR."/" ); } ?>
		<br /><br />
		<strong>Cache Methods Detected</strong><br />
		
		<form action="" method="post">
			<?php
				if ( count($cacheMethods) )
				{
					if ( count($cacheMethods) == 1 )
					{
						echo ( "One cache method has been found so it has been selected for you<br />
								" . $cacheMethods[0] . " will be used for this install" );
						echo ( "<input type=\"hidden\" name=\"cachemethod\" value=\"" . $cacheMethods[0] . "\">" );
					}else{
						echo ( "<select name=\"cachemethod\">" );
						echo ( "<option value=\"-1\">Select A Caching Method</option>" );
						foreach ( $cacheMethods as $cacheMethod )
						{
							if ( strtolower($config->CACHE_METHOD) == strtolower($cacheMethod) )
							{
								echo "<option selected=\"selected\" value=\"" . $cacheMethod . "\">" . $cacheMethod . "</option><br />";
							}else{
								echo "<option value=\"" . $cacheMethod . "\">" . $cacheMethod . "</option><br />";
							}
						}
						echo ( "<option value=\"-2\">Let the system decide</option>" );
						echo ( "</select>" );
						echo ( "<br />Note:<br />Letting the system decide will try the cache methods in this order: apc, memcache, xcache" );
					}
				}else{
					echo "<strong>It is highly recomended that you install either: XCache, APC or Memcache before contiuning with this install.<br />While NewzDash will work without these PHP Modules it will use more bandwidth<br />APC or Memcache are supported by the NewzDash team.";
					echo ( "<input type=\"hidden\" name=\"cachemethod\" value=\"-3\">" );
				}
			?>
			<div align="center">
			
			<input type="submit" value="Next Step" />
			<input type="hidden" name="step" value="2">
		</form>
			
		</div>
	</div>
	


<?php

?>

	<div class="breadcrumb">
			<h2>NewzDash Install - Step Four</h2><br /><strong>Database Install</strong><hr style="color:#000000; background-color:#000000; height:3px;"><br />
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
				Found newznab install titled <?php echo ( $config->DB_NNDB_TITLE ); ?>, we are linked into this database now.<br />
				Pre-SQL Connection Checks were Okay, ready to install the required tables.<br /><br />
				<form action="" method="post">
					<input type="submit" value="Install Tables" />
					<input type="hidden" name="step" value="4">
				</form>
			</div>
	</div>
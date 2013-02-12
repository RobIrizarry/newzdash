	<div class="breadcrumb">
		<h2>NewzDash Install - Step Five</h2><br /><strong>Saving Configuration</strong><hr style="color:#000000; background-color:#000000; height:3px;"><br />
		<div align="left">
		Tables have successfully been installed into your database.<br />
		<br />
		DB Host: <?php echo ( $config->DB_NNDB_HOST ); ?><br />
		DB User: <?php echo ( $config->DB_NNDB_USER ); ?><br />
		DB Pass: <?php echo ( $config->DB_NNDB_PASS ); ?><br />
		DB Name: <?php echo ( $config->DB_NNDB_DBNAME ); ?><br />
		JSUPDLY: <?php echo ( $config->JSUPDATE_DELAY ); ?><br />
		NZNBURL: <?php echo ( $config->NNURL ); ?><br />
		NZNBDIR: <?php echo ( $config->NEWZNAB_DIR ); ?><br />
		NNDBDIR: <?php echo ( $config->WWW_DIR ); ?><br />
		TMUXSHS: <?php echo ( $config->TMUX_SHARED_SECRET ); ?><br />
		<form action="" method="post">
			<input type="submit" value="Save Configuration" />
			<input type="hidden" name="step" value="5">
		</form>
				
		</div>
	</div>
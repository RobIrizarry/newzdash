<?php
	include ( 'config.php' );
	include ( WWW_DIR.'/lib/sql/db_newzdash.php' );
	
	$paneName = null;
	$paneState = null;
	$sharedSecret = null;
	
	//pname, pstate, ndsharedsecret
	if ( isset($_GET['pname']) )
		$paneName = $_GET['pname'];
		
	if ( isset($_GET['pstate']) )
		$paneState = $_GET['pstate'];
		
	if ( isset($_GET['ndsharedsecret']) )
		$sharedSecret = $_GET['ndsharedsecret'];
		
	if ( ($paneName == null) || ($paneState == null) || ($sharedSecret == null) )
	{
		die("err");
	}else{
		if ( $sharedSecret != TMUX_SHARED_SECRET )
		{
			die("ss");
		}else{
			$updateState = null;
			switch ( strtolower($paneState) )
			{
				case "started":
					$updateState = 1;
					break;
					
				case "stopped":
					$updateState = 2;
					break;
					
				case "killed":
					$updateState = 3;
					break;
			}
			
			if ( $updateState == null )
				die ("err updstate");
				
			$nddb = new NDDB;
			if ( !$nddb->isOkay() )
				die("err db");
				
			$query = 'INSERT INTO `newzdash`.`newzdash_tmuxlog` (`id`, `PANE_NAME`, `PANE_STATE`, `TIMESTAMP`) VALUES (NULL, \'' . $paneName . '\', \'' . $updateState . '\', CURRENT_TIMESTAMP);';
			$result = $nddb->queryInsert($query);
			if ( $result ) {
				echo "ok";
			}else{
				echo "err query . " . mysql_error();
			}
		}
	}
	
?>
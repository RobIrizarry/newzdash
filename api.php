<?php

	include ( 'config.php' );
	
	require_once("lib/dashdata.php");
	$dd = new DashData;
	
	if ( isset($_GET['mode']) ) {
		$requestMode = $_GET['mode'];
		$retVal = "";
		
		switch ( $requestMode ) {
		
			case "releases":
				$retVal = $dd->getReleaseCount(true);
				break;
				
			case "lastgroupupdate":
				$retVal = $dd->getLastGroupUpdate(true);
				break;
				
			case "lastupdateduration":
				$retVal = $dd->getLastUpdateDuration();
				break;
				
			case "activegroups":
				$retVal = $dd->getActiveGroupCount(true);
				break;
				
			case "pendingprocessing":
				$retVal = $dd->getPendingProcessingCount(true);
				break;
				
			case "lastbinaryadded":
				$retVal = $dd->getLastBinaryAdded(true);
				break;
				
			case "lastreleasecreated":
				$retVal = $dd->getLastReleaseCreated(true);
				break;
				
			case "partstablesize":
				$retVal = $dd->getPartsTableSize();
				break;
			
			case "partstabledbsize":
				$retVal = $dd->getPartsTableDBSize();
				break;
				
			case "partstablestats":
				$retVal = $dd->getPartsTableSize() . " (" . $dd->getPartsTableDBSize() . ")";
				break;

			case "newznabversion":
				$retVal = $dd->getSubversionInfo();
				break;
				
			case "newznabtmuxversion":
				$retVal = $dd->getNewzNabTmuxInfo();
				break;

			case "newzdashversion":
				$retVal = $dd->getNewzDashInfo();
				break;
				
			case "":
				
				break;
		}
		
		if ( $retVal != "" )
		{
			if ( $retVal == "now" )
					$retVal = "less than 1s ago";

			printf("%s", $retVal);
		}else{
			printf("Error");
		}
	}
?>
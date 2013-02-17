<?php

function round_up ( $value, $precision ) { 
    $pow = pow ( 10, $precision ); 
    return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow + 0.1; 
} 


	require_once ( "./lib/schema.php" );
	
		
	$var = "0";
	$var2 = "0.9";
	$var3 = "1.0";
	
	for ( $i=0 ; $i<40 ; $i++ )
	{
		$var += 0.1;
		echo number_format($var,1) . "|";
	}

	exit();
	$sqlSchema = new SQLSchema;
	echo ( "Current Schema: " );
	print_r($sqlSchema->getSchema());
?>
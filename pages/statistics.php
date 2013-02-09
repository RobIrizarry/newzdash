
<?php
	include ( './lib/stats.php' );

	$stats = new Stats;
	$stats->buildPendingTable();
	$stats->buildReleaseTable();
	$stats->buildGroupTable();
?>
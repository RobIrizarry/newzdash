<?php
	require_once("lib/recentreleases.php");
	$rr = new RecentReleases;
?>

<?php $rr->buildRecentMoviesTable(); ?> 

<?php $rr->buildRecentMusicTable(); ?> 

<?php $rr->buildRecentTVTable(); ?> 

<?php $rr->buildRecentGameTable(); ?> 

<?php $rr->buildRecentPCTable(); ?> 

<?php $rr->buildRecentOtherTable(); ?> 

<?php $rr->buildRecentXXXTable(); ?> 


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
	function updateReleaseCount() {
		$("#releaseCount").load("./api.php?mode=releases");
	}
	
	function updateLastGroupUpdate() {
		$("#lastgroupupdate").load("./api.php?mode=lastgroupupdate");
	}
	
	function updateLastUpdateDuration() {
		$("#lastupdateduration").load("./api.php?mode=lastupdateduration");
	}
	
	function updateActiveGroups() {
		$("#activegroups").load("./api.php?mode=activegroups");
	}
	
	function updatePendingProcessing() {
		$("#pendingprocessing").load("./api.php?mode=pendingprocessing");
	}
	
	function updateLastBinaryAdded() {
		$("#lastbinaryadded").load("./api.php?mode=lastbinaryadded");
	}
	
	function updateLastReleaseCreated() {
		$("#lastreleasecreated").load("./api.php?mode=lastreleasecreated");
	}
	
	function updatePartsTableStats() {
		$("#partstablestats").load("./api.php?mode=partstablestats");
	}
	
	function updateAll() {
		updateReleaseCount();
		updateLastGroupUpdate();
		updateLastUpdateDuration();
		updateActiveGroups();
		updatePendingProcessing();
		updateLastBinaryAdded();
		updateLastReleaseCreated();
		updatePartsTableStats();
	}
	
	function fetchTMUXLog(){
		$.ajax({
			url: './tmuxbridge/fetch.php',
			success: function(data) {
				$("#list").prepend(data);
				if($("#list table").length > 30){
					$('#list table:gt(29)').remove();
				}
				$("#list p").fadeIn();
				setTimeout("fetchTMUXLog()", 1000);
			}
		});
	}
	
	function updateVersions() {
		updateNewzNabVersion();
		updateNewzNabTmuxVersion();
		updateNewzDashVersion();
	}
	
	function updateNewzNabVersion() {
		$("#newznabversion").load("./api.php?mode=newznabversion");
	}
	
	function updateNewzNabTmuxVersion() {
		$("#newznabtmuxversion").load("./api.php?mode=newznabtmuxversion");
	}
	
	function updateNewzDashVersion() {
		$("#newzdashversion").load("./api.php?mode=newzdashversion");
	}
	
	
	$(document).ready(function() {
		updateVersions();
		fetchTMUXLog();
		setInterval ( updateAll, <?php echo ( JSUPDATE_DELAY ); ?> );
		setInterval ( updateVersions, <?php echo ( CACHE_TTL ); ?>*1000);
	});
	
</script>

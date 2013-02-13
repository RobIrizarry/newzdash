<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
	function updateReleaseCount() {
		$("#releaseCount").load("./api.php?mode=releases");
	}
	
	function updateLastGroupUpdate() {
		$("#lastgroupupdate").load("./api.php?mode=lastgroupupdate");
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
				if($("#list table").length > 10){
					$('#list table:gt(9)').remove();
				}
				$("#list p").fadeIn();
				setTimeout("fetchTMUXLog()", 1000);
			}
		});
	}
	
	$(function () {
		setInterval ( updateAll, <?php echo ( JSUPDATE_DELAY ); ?> );
		fetchTMUXLog();
	});
</script>
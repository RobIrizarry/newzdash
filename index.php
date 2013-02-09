
<?php

include('config.php');


if (!file_exists(NEWZNAB_HOME."/www/config.php"))
{
	# send the browser to the configuration page, something is wrong!
	header("Location: configure.php");
}

require_once("lib/dashdata.php");

$dashdata = new DashData;

?>

<html lang="en">

<?php include 'includes/header.php'; ?>
<script>
	function updateReleaseCount() {
		$("#releaseCount").load("api.php?mode=releases");
	}
	
	function updateLastGroupUpdate() {
		$("#lastgroupupdate").load("api.php?mode=lastgroupupdate");
	}
	
	function updateActiveGroups() {
		$("#activegroups").load("api.php?mode=activegroups");
	}
	
	function updatePendingProcessing() {
		$("#pendingprocessing").load("api.php?mode=pendingprocessing");
	}
	
	function updateLastBinaryAdded() {
		$("#lastbinaryadded").load("api.php?mode=lastbinaryadded");
	}
	
	function updateLastReleaseCreated() {
		$("#lastreleasecreated").load("api.php?mode=lastreleasecreated");
	}
	
	function updatePartsTableStats() {
		$("#partstablestats").load("api.php?mode=partstablestats");
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
	
	$(function () {
		setInterval ( updateAll, <?php echo ( JSUPDATE_DELAY ); ?> );
	});
</script>
<body>
<?php include 'includes/topbar.php'; ?>

		<div class="container-fluid">
			<div class="row-fluid">
				<?php include('includes/leftmenu.php'); ?>

				<noscript>
					<div class="alert alert-block span10">
						<h4 class="alert-heading">Warning!</h4>
						<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
					</div>
				</noscript>
				
				<div id="content" class="span10">
				<!-- content starts -->
					
				<?php
					if ( isset($_GET['p']) )
					{
						$page = $_GET['p'];
					
						if ( (strpos( $page, "." ) > 0) || (strpos( $page, "\\" ) > 0) || (strpos( $page, "/" ) > 0) ) {
							echo ( "
							<div>
								<ul class=\"breadcrumb\">
									Error:<br />
									Illegal characters found in page URL!
								</ul>
							</div>" );
							$page = "";
						}else{
							if ( !file_exists("./pages/" . $page . ".php") )
							{
								echo ( "
								<div>
									<ul class=\"breadcrumb\">
										Error:<br />
										Unable to find the page " . $page . "
									</ul>
								</div>" );
								$page = "";
							}
						}
					}else{
						$page = "dashboard";
					}
					
					if ( $page != "" )
					{
						include ( "./pages/" . $page . ".php");
					}
				?>
			</div>
			<hr>
			<?php include 'includes/bottombar.php'; ?>
		</div>
	</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

</body>
</html>

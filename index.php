<?php
if (!file_exists("config.php"))
{
	# send the browser to the configuration page, something is wrong!
	header("Location: ./install");
}

include('config.php');

if ( !defined("DB_NDDB_HOST") )
{
	die ( "Unable to find DB_NDDB_HOST, this is normally due to a git pull and a large update - please delete config.php, install.lock and try again." );
}

$page = "dashboard";
$pageScripts = false;

if ( isset($_GET['page']) )
{
	$page = $_GET['page'];

	if ( (strpos( $page, "." ) > 0) || (strpos( $page, "\\" ) > 0) || (strpos( $page, "/" ) > 0) ) {
		echo ( "
		<div>
			<ul class=\"breadcrumb\">
				Error:<br />
				Illegal characters found in page URL!
			</ul>
		</div>" );
		$page = "";
		die();
	}else{
		if ( !file_exists(WWW_DIR . "/pages/" . $page . ".php") )
		{
			echo ( "
			<div>
				<ul class=\"breadcrumb\">
					Error:<br />
					Unable to find the page " . $page . "
				</ul>
			</div>" );
			$page = "";
			die();
		}
		
	}
}else{
	$page = "dashboard";
}

if ( file_exists(WWW_DIR . "/pages/" . $page . "_script.php") )
{
	$pageScripts = true;
}

require_once("lib/dashdata.php");
$dashdata = new DashData;

?>
<!DOCTYPE html>
<html>
<head>
<?php
	if ( $pageScripts ) {
		include ( WWW_DIR . "/pages/" . $page . "_script.php" );
	}
	include 'includes/header.php';
?>
</head>
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

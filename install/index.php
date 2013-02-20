<?php
	@session_start();
	require_once('./installer.php');
	
	DEFINE ( 'INSTALL_STEP_CACHE', '3' );
	DEFINE ( 'INSTALL_STEP_CONFIG', '4' );
	DEFINE ( 'INSTALL_STEP_DATABASE', '5' );
	DEFINE ( 'INSTALL_STEP_SAVECONFIG', '6' );
	
	if ( isset($_POST['submit']) ) {
		if ( $_POST['submit'] == "Reset Settings" )
		{
			@session_unset();
			@session_start();
			unset($_POST['step']);
		}
	}
	
	$config = new Installer();
	
	if (!$config->isInitialized()) {
		$config->setInstallerOptions();
		
		if ( !$config->hasError )
			$config->setSession();
		
	}else{
		$config = $config->getSession();
	}
	
	if ( isset($_POST['step']) )
	{
		$installStep = $_POST['step'];
		$installStep++;
	}else{
		$installStep = 1;
	}

	switch ( $installStep )
	{
	
		case INSTALL_STEP_CACHE:
			$config->resetErrors();
			
			if ( (!$config->setOption('CACHE_METHOD', $_POST['cachemethod'])) || ($_POST['cachemethod'] == "-1") )
			{
				$config->setError("Please select a caching method to use from the list provided.");
			}
			break;
	
		case INSTALL_STEP_CONFIG:
			$config->resetErrors();
			
			
			/*
				~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
				~ Newznab Database Config
				~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
			*/
			if ( !$config->setOption('DB_NNDB_HOST', $_POST['db_host']) )
			{
				$config->setError("[newznab] SQL Host must not be empty!");
			}
			
			if ( !$config->setOption('DB_NNDB_PORT', $_POST['db_port']) )
			{
				$config->setError("[newznab] SQL Port must not be empty!");
			}
			
			if ( !$config->setOption('DB_NNDB_USER', $_POST['db_user']) )
			{
				$config->setError("[newznab] SQL User must not be empty!");
			}
			
			if ( !$config->setOption('DB_NNDB_PASS', $_POST['db_password']) )
			{
				$config->setError("[newznab] SQL Password must not be empty!");
			}
			
			if ( !$config->setOption('DB_NNDB_DBNAME', $_POST['db_name']) )
			{
				$config->setError("[newznab] SQL Database Name must not be empty!");
			}
			
			/*
				~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
				~ NewzDash Database Config
				~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
			*/
			if ( !$config->setOption('DB_NDDB_HOST', $_POST['nddb_host']) )
			{
				$config->setError("[newzdash] SQL Host must not be empty!");
			}
			
			if ( !$config->setOption('DB_NDDB_PORT', $_POST['nddb_port']) )
			{
				$config->setError("[newzdash] SQL Host must not be empty!");
			}
			
			if ( !$config->setOption('DB_NDDB_USER', $_POST['nddb_user']) )
			{
				$config->setError("[newzdash] SQL User must not be empty!");
			}
			
			if ( !$config->setOption('DB_NDDB_PASS', $_POST['nddb_password']) )
			{
				$config->setError("[newzdash] SQL Password must not be empty!");
			}
			
			if ( !$config->setOption('DB_NDDB_DBNAME', $_POST['nddb_name']) )
			{
				$config->setError("[newzdash] SQL Database Name must not be empty!");
			}
			
			/*
				~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
				~ NewzDash TMUX Shared Secret
				~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
			*/
			if ( !$config->setOption('TMUX_SHARED_SECRET', $_POST['tmux_shared_secret']) )
			{
				$config->setError("TMUX Shared Secret is required!");
			}else{
				if ( strlen($_POST['tmux_shared_secret']) < 10 )
				{
					$config->setError("TMUX Shared Secret is too short (10+ characters required)");
				}
			}	
			
			/*
				~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
				~ Newznab URL and Directory
				~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
			*/
			if ( !$config->setOption('NNURL', $_POST['nn_url']) )
			{
				$config->setError("Newznab URL cannot be blank");
			}else{
				if ( $_POST['nn_url'] == "http://" )
				{
					$config->setError("Newznab URL has not been completed");
				}
			}
			
			if ( !$config->setOption('NEWZNAB_DIR', $_POST['nn_path']) )
			{
				$config->setError("Newznab Directory must not be empty!");
			}else{
				//Double check to see if we can see the config.php!
				if ( !file_exists($config->NEWZNAB_DIR."/www/config.php") ) {
					$config->setError("Unable to locate config.php in " . $config->NEWZNAB_DIR . "/www.");
				}
			}
			
			/*
				~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
				~ NewzDash Javascript Update Delay
				~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
			*/
			if ( !$config->setOption('JSUPDATE_DELAY', $_POST['nd_jsupdate_delay']) )
			{
				$config->setError("JS Update Delay must not be empty!");
			}else{
				if ( $config->JSUPDATE_DELAY < 1000 )
				{
					$config->setError("JS Update Delay should not be under 1 second (<1000)");
				}
			}
			
			/*
				~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
				~ Database Name Check
				~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
			*/
			if ( $config->DB_NNDB_DBNAME == $config->DB_NDDB_DBNAME ) {
				$config->setError("You cannot use the same databases for both Newznab and NewzDash");
			}

			
			/*
				~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
				~ SQL Connection Test (for Newznab)
				~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
			*/
			if ( !$config->hasError ) {
				$config->resetErrors();
				$dbConnection_newznab = $config->tryDatabaseConnection("newznab");
				if ( !$config->hasError )
				{
					$query = "SELECT value FROM site WHERE setting='title';";
					$result = $dbConnection_newznab->query($query);
					if ( $result === FALSE ) {
						$config->setError("[newznab] This does not look like a newznab database, did you configure it correctly?");
					}else{
						$tmp = $result->fetch_assoc();
						$config->DB_NNDB_TITLE = $tmp['value'];
					}
				}
				
				$dbConnection_newznab = $config->tryDatabaseConnection("newzdash");
			}
			
			/*
				~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
				~ Memcache Settings
				~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
			*/
			if ( isset($_POST['memcache_server']) )
			{
				if ( !$config->setOption('MEMCACHE_SERVER', $_POST['memcache_server']) )
				{
					$config->setError("Memcache requires a server IP Address!");
				}
			}
			
			if ( isset($_POST['memcache_port']) )
			{
				if ( !$config->setOption('MEMCACHE_PORT', $_POST['memcache_port']) )
				{
					$config->setError("Memcache requires a server Port!");
				}
			}

			break;
			
		case INSTALL_STEP_DATABASE:
			$config->resetErrors();
			
			$dbConnection_newznab = $config->tryDatabaseConnection("newznab");
			if ( !$config->hasError )
			{
				if ( !file_exists($config->INSTALL_DIR.'/sql/install.sql')	 )
					die ( "install.sql cannot be found!" );
				
				$dbConnection_newzdash = $config->tryDatabaseConnection("newzdash");
				if ( !$config->hasError )
				{
					if ( !file_exists($config->INSTALL_DIR.'/sql/install.sql')	 )
						die ( "install.sql cannot be found, maybe you need to pull the github repo again?" );
						
					$queryFile = file_get_contents($config->INSTALL_DIR.'/sql/install.sql');
					$queries = explode(";", $queryFile);
					foreach ( $queries as $query )
					{
						if ( $query != "" )
						{
							$queryData = $dbConnection_newzdash->query ( $query . ";" );
							if ( $queryData === FALSE ) {
								$config->setError("MySQL Error, MySQL Said: " . $dbConnection_newzdash->error);
							}
						}
					}
					
					mysqli_close($dbConnection_newzdash);
				}
				mysqli_close($dbConnection_newznab);
			}
			break;
			
		case INSTALL_STEP_SAVECONFIG:
			$config->resetErrors();
			$config->saveConfigFile();
			$config->lockInstall();
			break;
			
		default:
			$config->resetErrors();
			break;
	}
	
	//Check if the installer has already created its lock file
	if ( $config->isLocked() && $config->installStep == 0 ) {
		$config->hasError = true;
	}
	
	//Backup a step as we are erroring.
	if ( $config->hasError )
		$installStep--;
				
	
	$installPage = "step" . $installStep;
	$config->installStep = $installStep;
	
	//Save the current session data
	$config->setSession();
?>

<!-- head starts -->
<head>
	<meta charset="utf-8">
	<title>NewzNab Dashboard - Install</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Newznab, a usenet indexing web application with community features.">
	<meta name="author" content="AlienX">

	<!-- The styles -->
	<link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
	<style type="text/css">
	  body {
		padding-bottom: 40px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	</style>
	<link href="css/charisma-app.css" rel="stylesheet">
	<link href='css/uniform.default.css' rel='stylesheet'>
	
	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- The fav icon -->
	<link rel="shortcut icon" href="../img/favicon.ico">

	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script>
		function tryFetchSettings() {
			alert ( "This does not work yet, you're going to have to use the good ol' copy and paste method here!");
		}
	</script>

</head>
<!-- head ends -->

<body>
	<!-- topbar starts -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="index.php"><span>NewzDash</span></a>
			</div>
		</div>
	</div>
	<!-- topbar ends -->

		<div class="container-fluid">
			<div class="row-fluid">
							
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
						$page = $installPage;
					}
					
					if ( $page != "" )
					{
						if ( $config->hasError && !count($config->errorText) )
						{
							echo "Something went wrong, send a bug report to someone!";
						}else{
							if ( $config->isLocked() )
							{
								echo "<h2 style=\"display:inline\"><strong>Error</strong></h2><br />install.lock file found, if you want to reinstall this please remove the file first.";
							}else{
								include ( "./pages/" . $page . ".php");
							}
						}
					}
				?>
			</div>
		</div>
	</div><!--/.fluid-container-->

	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

</body>
</html>

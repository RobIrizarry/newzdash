<?php
//NEWZNAB CONFIGURATION v0.2
define('NEWZNAB_URL','%%NNURL%%');
define('NEWZNAB_HOME', '%%NNDIR%%');

//SITE CONFIGURATION
define('WWW_DIR', '%%WWW_DIR%%');
define('SHOW_MOVIES','checked');
define('SHOW_TV','checked');
define('SHOW_MUSIC','checked');
define('SHOW_GAMES','checked');
define('SHOW_PC','checked');
define('SHOW_OTHER','checked');
define('SHOW_XXX','checked');
define('SHOW_PROCESSING','checked');
define('SHOW_RPC','checked');
define('SHOW_RPG','checked');

//SQL CONFIGURATION (newznab)
define('DB_HOST', '%%DB_NNDB_HOST%%');
define('DB_USER', '%%DB_NNDB_USER%%');
define('DB_PASSWORD', '%%DB_NNDB_PASS%%');
define('DB_NAME', '%%DB_NNDB_DBNAME%%');
define('DB_PCONNECT', %%DB_NNDB_PCONNECT%%);
define('DB_PORT', %%DB_NNDB_PORT%%);

//SQL CONFIGURATION (newzdash)
define('DB_NDDB_HOST', '%%DB_NDDB_HOST%%');
define('DB_NDDB_USER', '%%DB_NDDB_USER%%');
define('DB_NDDB_PASSWORD', '%%DB_NDDB_PASS%%');
define('DB_NDDB_NAME', '%%DB_NDDB_DBNAME%%');
define('DB_NDDB_PCONNECT', %%DB_NDDB_PCONNECT%%);
define('DB_NDDB_PORT', %%DB_NDDB_PORT%%);

//DASHBOARD UPDATE DELAY (1000 = 1 second)
define('JSUPDATE_DELAY', '%%JSUPDATE_DELAY%%');

//TMUX CONFIGURATION
//Enter a random phrase or a set of random characters for a shared key, do not give it out to anyone.
//You also need to enter the same shared key into your tmux configuration file
define('TMUX_SHARED_SECRET', '%%TMUX_SHARED_SECRET%%');

//Error reporting on/off
error_reporting(E_ALL);
	ini_set('display_error', 1);

?>

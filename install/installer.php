<?php

	Class Installer
	{
		
		/*
			Newznab Database Settings (NNDB)
		*/
		public $DB_NNDB_HOST = "localhost";
		public $DB_NNDB_USER = "";
		public $DB_NNDB_PASS = "";
		public $DB_NNDB_PCONNECT = false;
		public $DB_NNDB_DBNAME = "newznab";
		public $DB_NNDB_PORT = 3306;
		public $DB_NNDB_TITLE;
		
		/*
			NewzDash Database Settings (NDDB)
		*/
		public $DB_NDDB_HOST = "localhost";
		public $DB_NDDB_USER = "";
		public $DB_NDDB_PASS = "";
		public $DB_NDDB_PCONNECT = false;
		public $DB_NDDB_PORT = 3306;
		public $DB_NDDB_DBNAME = "newzdash";
		
		/*
			Cache Settings
		*/
		public $CACHE_TTL = 600;
		public $CACHE_METHOD;
		public $MEMCACHE_SERVER;
		public $MEMCACHE_PORT;
		
		public $WWW_DIR;
		public $INSTALL_DIR;
		public $NEWZNAB_DIR;
		
		public $NNURL = "http://";
		
		public $TMUX_SHARED_SECRET;
		
		public $JSUPDATE_DELAY = "5000";
		
		public $hasError = false;
		public $errorText = array();
		
		public $installStep = 0;
		
		function setInstallerOptions() {
			$this->WWW_DIR = dirname(realpath('.'));
			$this->INSTALL_DIR = $this->WWW_DIR . "/install";
			$this->TMUX_SHARED_SECRET = $this->generateRandomString(25);
		}
		
		function saveConfigFile() {
			$cfgBuffer = file_get_contents($this->INSTALL_DIR . "/config.php.tpl");
			
			//Database [newznab]
			$cfgBuffer = str_replace('%%DB_NNDB_HOST%%', $this->DB_NNDB_HOST, $cfgBuffer);
			$cfgBuffer = str_replace('%%DB_NNDB_USER%%', $this->DB_NNDB_USER, $cfgBuffer);
			$cfgBuffer = str_replace('%%DB_NNDB_PASS%%', $this->DB_NNDB_PASS, $cfgBuffer);
			$cfgBuffer = str_replace('%%DB_NNDB_PCONNECT%%', $this->tftostring($this->DB_NNDB_PCONNECT), $cfgBuffer);
			$cfgBuffer = str_replace('%%DB_NNDB_DBNAME%%', $this->DB_NNDB_DBNAME, $cfgBuffer);
			$cfgBuffer = str_replace('%%DB_NNDB_PORT%%', $this->DB_NNDB_PORT, $cfgBuffer);
			
			//Database [Newzdash]
			$cfgBuffer = str_replace('%%DB_NDDB_HOST%%', $this->DB_NDDB_HOST, $cfgBuffer);
			$cfgBuffer = str_replace('%%DB_NDDB_USER%%', $this->DB_NDDB_USER, $cfgBuffer);
			$cfgBuffer = str_replace('%%DB_NDDB_PASS%%', $this->DB_NDDB_PASS, $cfgBuffer);
			$cfgBuffer = str_replace('%%DB_NDDB_PCONNECT%%', $this->tftostring($this->DB_NDDB_PCONNECT), $cfgBuffer);
			$cfgBuffer = str_replace('%%DB_NDDB_DBNAME%%', $this->DB_NDDB_DBNAME, $cfgBuffer);
			$cfgBuffer = str_replace('%%DB_NDDB_PORT%%', $this->DB_NDDB_PORT, $cfgBuffer);
			
			//Cache
			$cfgBuffer = str_replace('%%CACHE_TTL%%', $this->CACHE_TTL, $cfgBuffer);
			$cfgBuffer = str_replace('%%CACHE_METHOD%%', $this->CACHE_METHOD, $cfgBuffer);
			$cfgBuffer = str_replace('%%MEMCACHE_SERVER%%', $this->MEMCACHE_SERVER, $cfgBuffer);
			$cfgBuffer = str_replace('%%MEMCACHE_PORT%%', $this->MEMCACHE_PORT, $cfgBuffer);
			
			//Javascript
			$cfgBuffer = str_replace('%%JSUPDATE_DELAY%%', $this->JSUPDATE_DELAY, $cfgBuffer);
			
			//Newznab
			$cfgBuffer = str_replace('%%NNURL%%', $this->NNURL, $cfgBuffer);
			$cfgBuffer = str_replace('%%NNDIR%%', $this->NEWZNAB_DIR, $cfgBuffer);
			
			//Local Website WWW Directory
			$cfgBuffer = str_replace('%%WWW_DIR%%', $this->WWW_DIR, $cfgBuffer);
			
			//TMUX Config (ss)
			$cfgBuffer = str_replace('%%TMUX_SHARED_SECRET%%', $this->TMUX_SHARED_SECRET, $cfgBuffer);
			
			return @file_put_contents($this->WWW_DIR.'/config.php', $cfgBuffer);
		}
		
		public function setOption($option, $value)
		{
			$this->{$option} = $value;
			
			if ( $value != "" )
			{
				return true;
			}else{
				return false;
			}
		}
		
		public function resetErrors() {
			$this->hasError = false;
			$this->errorText = array();
		}
				
		public function isLocked() {
			if ( $this->installStep > 0 ) return false;
			return (file_exists($this->WWW_DIR.'/install.lock') ? true : false);
		}
		
		public function lockInstall() {
			return (@file_put_contents($this->WWW_DIR.'/install.lock', 'LOCKED INSTALL'));
		}
			
		public function setSession() {
			$_SESSION['cfg'] = serialize($this);
		}
				
		public function getSession() {
			$tmpCfg = unserialize($_SESSION['cfg']);
			$tmpCfg->error = false;
			$tmpCfg->doCheck = false;
			return $tmpCfg;
		}
		
		public function isInitialized() {
			return (isset($_SESSION['cfg']) && is_object(unserialize($_SESSION['cfg'])));
		}
		
		function tftostring($input) {
			if ( $input ) 
			{
				return "true";
			}else{
				return "false";
			}
		}
		
		function generateRandomString($length = 10) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, strlen($characters) - 1)];
			}
			
			return $randomString;
		}
		
		function tryDatabaseConnection($where) {
			switch ($where)
			{
				case "newznab":
					$conn = @new mysqli($this->DB_NNDB_HOST, $this->DB_NNDB_USER, $this->DB_NNDB_PASS, $this->DB_NNDB_DBNAME, $this->DB_NNDB_PORT);
					if ( $conn->connect_errno )
					{
						$this->hasError = true;
						$this->errorText[] = "[newznab] MySQL Connection Error: " . $conn->connect_error;
					}else{
						return $conn;
					}
					break; 
					
				case "newzdash":
					$conn = @new mysqli($this->DB_NDDB_HOST, $this->DB_NDDB_USER, $this->DB_NDDB_PASS, $this->DB_NDDB_DBNAME, $this->DB_NDDB_PORT);
					if ( $conn->connect_errno )
					{
						$this->hasError = true;
						$this->errorText[] = "[newzdash] MySQL Connection Error: " . $conn->connect_error;
					}else{
						return $conn;
					}
					break;
				
				default:
					return false;
					break;
			}
			return null;
		}
		
		function getCacheMethodsFromSystem($returnCacheName = false)
		{
			$cacheMethods = array();
			if (function_exists('apc_store'))
				$cacheMethods[] = "apc";
				
			if (extension_loaded('memcache'))
				$cacheMethods[] = "memcache";
				
			if ( function_exists("xcache_set") )
				$cacheMethods[] = "xcache";
				
			if ( $returnCacheName )
			{
				if ( count($cacheMethods) )
					return $cacheMethods[0];
				else
					return array();
			}else{
				return $cacheMethods;
			}
		}
		
		function setError($strErr)
		{
			$this->errorText[] = $strErr;
			$this->hasError = true;
		}
	}
?>
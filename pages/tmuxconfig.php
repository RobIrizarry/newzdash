<?php

if(!defined("NEWZNAB_HOME"))
	include('../config.php');

// read the untouched config to always write a defaults file containing all variables
$configFile = realpath(NEWZNAB_HOME).'/misc/update_scripts/nix_scripts/tmux/config.sh';
$config = file_get_contents($configFile);

// if it exists, read the customized defaults file to get the local settings - otherwise load the untouched config again
//
// TESTING! writes to 'defaults.sh.test', not the real 'defaults.sh'
//
$defaultsFile = realpath(NEWZNAB_HOME).'/misc/update_scripts/nix_scripts/tmux/defaults.sh.test';
if(file_exists($defaultsFile)) {
	$defaults = file_get_contents($defaultsFile);
}else{
	$defaults = file_get_contents($configFile);
}

$ignoreVars = array("NEWZNAB_PATH", "TESTING_PATH", "ADMIN_PATH", "TMUX_SESSION", "TMUX_CONF");

// find all variable names and values from the untouched config
preg_match_all('|^export ([a-z_]*)="(.*)"$|im', $config, $configVars);

// find all variable names and values from the customized defaults file
preg_match_all('|^export ([a-z_]*)="(.*)"$|im', $defaults, $defaultsVars);

if(isset($_POST['action']) && $_POST['action'] == 'savetmuxconfig') {

	// create defaults file from untouched config
	$defaults = $config;

	foreach($_POST['vars'] as $key=>$newVar) {
		// get the untouched value
		$origVar = $configVars[2][ array_search($key, $configVars[1]) ];
		// if the untouched value does not match the POST'ed customized value, replace it
		if($origVar != $newVar) {
			$defaults = preg_replace('|^(export '.$key.'=")(.*)(")$|m', '${1}'.$newVar.'${3}', $defaults);
		}
	}
	
	if($fh = fopen($defaultsFile, 'w')) {
		fwrite($fh, $defaults);
		fclose($fh);
	}else{
		echo "Error: could not open ".$defaultsFile." for writing!";
	}
	
	//
	// TESTING!
	//
	echo "<pre>";
	echo $defaults;
	die;
}
?>
<form action="pages/tmuxconfig.php" method="POST">
<?php
foreach($configVars[1] as $var) {
	if(array_search($var, $ignoreVars) === false) {
		// if the variable is in 'config.sh' and 'defaults.sh', output the customized value
		if(in_array($var, $defaultsVars[1])) {
			$key = array_search($var, $defaultsVars[1]);
			$outputValue = $defaultsVars[2][$key];
			$class = "";
		
		// otherwise use the untouched value from 'config.sh' and set the class "newVar"
		}else{
			$key = array_search($var, $configVars[1]);
			$outputValue = $configVars[2][$key];
			$class = "newVar";
		}
		echo '<label for="var_'.$var.'" class="'.$class.'">'.$var."</label>";
		echo '<input type="text" name="vars['.$var.']" id="var_'.$var.'" value="'.$outputValue.'" /><br >'."\n";
		unset($class);
	}
}

?>
<input type="hidden" name="action" value="savetmuxconfig" />
<input type="submit" name="submit" value="save" />
</form>

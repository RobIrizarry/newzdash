 <?php
@session_start();
include("./../config.php");
include("./../lib/sql/db_newzdash.php");

$nddb = new NDDB;

$sql = "SELECT COUNT(`id`) AS total_entries
        FROM `newzdash_tmuxlog`";
$result = $nddb->queryOneRow($sql);
$total_entries = $result["total_entries"];

if ( $_SESSION['total'] == 0 )
	$_SESSION['total'] = $total_entries-10;
	
if($_SESSION["total"] != $total_entries){
    $limit = $total_entries - $_SESSION["total"];
    $sql = "SELECT *
            FROM `newzdash_tmuxlog`
            ORDER BY `id` DESC
            LIMIT ".$limit;
    $result = $nddb->query($sql);
	
    if(count($result)>0){
        foreach ( $result as $row ) {
			$pName = $row['PANE_NAME'];
			$pState = $row['PANE_STATE'];
			$pTimeArr = explode(" ", $row['TIMESTAMP']);
			$pID = $row['id'];
			
			$pTime = $pTimeArr[1] . " " . $pTimeArr[0];
			
			$tableRowColor = "#ffffff";
			
			switch ( $pState )
			{
				case "1": $pState = "Started"; $tableRowColor = "#D8FFD8"; break;
				case "2": $pState = "Stopped"; $tableRowColor = "#F5CCCC"; break;
				case "3": $pState = "Killed"; $tableRowColor = "#F5CCCC"; break;
			}
			
			switch ( strtolower($pName) ) {
				case "update_binaries": $pName = "Update Binaries"; break;
				case "processothers": $pName = "Process Others"; break;
			}
			
			if ( trim($pName) != "" ) {
				echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">";
				echo "	<tr>";
				echo "		<td bgcolor=\"" . $tableRowColor . "\" width=\"5%\">";
				echo "			<div align=\"center\">".$pID."</div>";
				echo "		</td>";
				echo "		<td bgcolor=\"" . $tableRowColor . "\" width=\"50%\">";
				echo "			<div align=\"center\">".$pName."</div>";
				echo "		</td>";
				echo "		<td bgcolor=\"" . $tableRowColor . "\" width=\"30%\">";
				echo "			<div align=\"center\">".$pState."</div>";
				echo "		</td>";
				echo "		<td bgcolor=\"" . $tableRowColor . "\">";
				echo "			<div align=\"center\">".$pTime."</div>";
				echo "		</td>";
				echo "	</tr>";
				echo "</table>";
				//echo "<p>" . $pName . "</p>";
			}
        }
    }
    $_SESSION["total"] = $total_entries;
}
?> 
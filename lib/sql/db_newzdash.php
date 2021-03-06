<?php
/*
	File Obtained From:
		https://github.com/Aaron-/nnplus/blob/momo/www/lib/framework/db.php
		
	-- AlienX
	
	-- 16/02/2013
		Switched to mysqli extension
*/

require_once ( WWW_DIR . '/lib/sql/db_cache.php' );

class NDDB
{
	private static $initialized = false;
	private static $mysqliHandle = null;

	function NDDB()
	{
		if (NDDB::$initialized === false)
		{
			if ( DB_NDDB_PORT > 0 )
			{
				NDDB::$mysqliHandle = @new mysqli(DB_NDDB_HOST, DB_NDDB_USER, DB_NDDB_PASSWORD, DB_NDDB_NAME, DB_NDDB_PORT);
			}else{
				NDDB::$mysqliHandle = @new mysqli(DB_NDDB_HOST, DB_NDDB_USER, DB_NDDB_PASSWORD, DB_NDDB_NAME);
			}
			
			if ( NDDB::$mysqliHandle->connect_errno )
			{
				printf ( "Unable to establish a connection to the SQL Server, SQL Said:\n%s", NDDB::$mysaliHandle->connect_error() );
				exit();
			}
			
			NDDB::$mysqliHandle->select_db(DB_NDDB_NAME)
				or die("Unable to select the database '" . DB_NDDB_NAME . "', check your configuration!");
			
			NDDB::$initialized = true;
		}			
	}	
	
	public function isOkay()
	{
		if ( NDDB::$initialized ) {
			return true;
		}else{
			return false;
		}
	}
					
	public function queryInsert($query, $returnlastid=true)
	{
		$result = NDDB::$mysqliHandle->query($query);
		return ($returnlastid) ? NDDB::$mysqliHandle->insert_id : $result;
	}
	
	public function queryOneRow($query, $useCache = false, $cacheTTL = '')
    {
        if($query=="")
            return false;

        $rows = $this->query($query, $useCache, $cacheTTL);
        return ($rows ? $rows[0] : false);
    }
		
    public function query($query, $useCache = false, $cacheTTL = '')
    {
        if($query=="")
            return false;

        if ($useCache) {
            $cache = new Cache();
            if ($cache->enabled && $cache->exists($query)) {
                $ret = $cache->fetch($query);
                if ($ret !== false)
                    return $ret;
            }
        }

        $result = NDDB::$mysqliHandle->query($query);


        if ($result === false || $result === true)
            return array();

        $rows = array();

        while ($row = $result->fetch_assoc())
            $rows[] = $row;

        $result->free_result();

        if ($useCache)
            if ($cache->enabled)
                $cache->store($query, $rows, $cacheTTL);

        return $rows;
    }
	
	/*
		~~~~~~ Helper Functions ~~~~~~~~
	*/
	public function escapeString($str)
	{
		return "'" . NDDB::$mysqliHandle->real_escape_string($str) . "'";
	}
}
?>
<?php
/*
	File Obtained From:
		https://github.com/Aaron-/nnplus/blob/momo/www/lib/framework/db.php
		
	-- AlienX
	
	-- 16/02/2013
		Switched to mysqli extension
*/

require_once ( WWW_DIR . '/lib/sql/db_cache.php' );

class DB
{
	private static $initialized = false;
	private static $mysqliHandle = null;

	function DB()
	{
		if (DB::$initialized === false)
		{
			if ( DB_PORT > 0 )
			{
				DB::$mysqliHandle = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
			}else{
				DB::$mysqliHandle = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			}
			
			if ( DB::$mysqliHandle->connect_errno )
			{
				printf ( "Unable to establish a connection to the SQL Server, SQL Said:\n%s", DB::$mysaliHandle->connect_error() );
				exit();
			}
			
			DB::$mysqliHandle->select_db(DB_NAME)
				or die("Unable to select the database '" . DB_NAME . "', check your configuration!");
			
			DB::$initialized = true;
		}			
	}	
	
	public function isOkay()
	{
		if ( DB::$initialized ) {
			return true;
		}else{
			return false;
		}
	}
					
	public function queryInsert($query, $returnlastid=true)
	{
		$result = DB::$mysqliHandle->query($query);
		return ($returnlastid) ? DB::$mysqliHandle->insert_id : $result;
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

        $result = DB::$mysqliHandle->query($query);


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
		return "'" . DB::$mysqliHandle->real_escape_string($str) . "'";
	}
}
?>
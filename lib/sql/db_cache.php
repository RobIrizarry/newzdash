<?php

class Cache {
	public $ttl = 600;
	public $enabled = true;
	public $method = 'none';
	public $mc;
	
	function Cache() 
	{
		$this->location = WWW_DIR.'../db/cache/';

		if (defined("CACHEOPT_TTLMEDIUM"))
			$this->ttl =  CACHEOPT_TTLMEDIUM;

		if (defined("CACHEOPT_METHOD"))
			$this->method = CACHEOPT_METHOD;
		
		switch($this->method)
		{
			case 'apc':
				if (function_exists('apc_store') == false)
					$this->enabled = false;
			break;
			default:
				$this->enabled = false;
			break;
		}
	}
	
	public function store($key, $data, $ttl='')
	{
		$ret = false;
		if ($ttl != '')
			$this->ttl = (int) $ttl;
			
		if ($this->enabled)
		{
			switch($this->method)
			{
				case 'apc':
					$ret = apc_store($this->getKey($key), $this->pack($data), $this->ttl);
				break;
			}
		}
		return $ret;
	}
	
	public function pack($data)
	{
		return gzdeflate(serialize($data), 3);
	}
	
	public function unpack($data)
	{
		return unserialize(gzinflate($data));
	}	
	
	public function fetch($key)
	{
		$ret = false;
		if ($this->enabled)
		{
			switch($this->method)
			{
				case 'apc':
					$ret = $this->unpack(apc_fetch($this->getKey($key)));
				break;
			}
		}
		return $ret;
	}

	public function exists($key)
	{
		$ret = false;
		if ($this->enabled)
		{
			switch($this->method)
			{
				case 'apc':
					$ret = apc_exists($this->getKey($key));
				break;
				case 'memcache':
					$ret = true;
				break;
			}
		}
		return $ret;
	}
	
	public function getKey($str)
	{
		return substr(hash('sha512',$str),0,20);
	}

}

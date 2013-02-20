<?php

class Cache {
	public $ttl = 600;
	public $enabled = false;
	public $method = '';
	public $mc;
	
	function Cache() 
	{
		if (defined("CACHE_TTL"))
			$this->ttl =  CACHE_TTL;

		$this->method = $this->getMethodFromSystem();
			
		//Still allow the method to be overwritten by a config value.
		if (defined("CACHE_METHOD"))
			$this->method = CACHE_METHOD;
		
		switch($this->method)
		{
			case 'apc':
				if (function_exists('apc_store') == false)
					$this->enabled = false;
			break;
			case 'memcache':
				if (!extension_loaded('memcache')) 
					$this->enabled = false;
				else
				{
					if ( defined("MEMCACHE_SERVER") && defined("MEMCACHE_PORT") )
					{
						$this->mc = new Memcache;
						$this->mc->connect(MEMCACHE_SERVER, MEMCACHE_PORT) 
							or $this->enabled = false;					
					}else{
						$this->enabled = false;
					}
				}
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
				case 'memcache':
					$ret = $this->mc->set($this->getKey($key), $this->pack($data), false, $this->ttl);
					break;				
				case 'xcache':
					if ( $ttl == '' )
					{
						xcache_set($this->getKey($key), $this->pack($data));
					}else{
						xcache_set($this->getKey($key), $this->pack($data), $ttl);
					}
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
				case 'memcache':
					$ret = $this->unpack($this->mc->get($this->getKey($key)));
					break;
				case 'xcache':
					if ( xcache_isset($this->getKey($key)) ) {
						$ret = $this->unpack(xcache_get($this->getKey($key)));
					} else {
						$ret = '';
					}
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
				case 'xcache':
					if ( xcache_set($this->getKey($key)) )
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
		
	private function getMethodFromSystem()
	{
		if (function_exists('apc_store'))
			return "apc";
			
		if (extension_loaded('memcache'))
			return "memcache";
			
		if ( function_exists("xcache_set") )
			return "xcache";	
			
		return null;
	}
}

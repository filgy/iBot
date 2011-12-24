<?php

	class iCore{
		private $socketPoll;

		private $servers = Array();
		
		private $timers = Array();
		
		public function __construct(){
			$this->socketPoll = new iSocketPoll();

		}
		
		public function addServer($serverName, $remoteHost, $remotePort, Array $channels = Array()){
			
			$this->servers[$serverName] = new iServer($serverName, $remoteHost, $remotePort, $channels);
			$this->timers[$serverName] = new iTimer(); 
			
			return $this->servers[$serverName];
		}
		
		public function joinChannel($serverName, $channel){
			if(!isset($this->servers[$serverName]))
					throw new iCoreException("Server with name ".$serverName." is not exists");
			
			$this->servers[$serverName]->joinChannel($channel);
		}
		
		public function run(){
			foreach($this->servers as $server)
				$this->socketPoll->addSocket($server->getServerName(), $server->getRemoteHost(), $server->getRemotePort());
			
			if($this->socketPoll->getCount() == 0)
				throw new iCoreException("Cannot start bot without any servers");
			
			while(true){
				$this->socketPoll->handle();
				
				
				
			}
		}
		
		
	}
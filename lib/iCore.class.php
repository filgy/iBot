<?php

	class iCore{
		private $socketPoll;

		private $servers = Array();
		
		public function __construct(){
			$this->socketPoll = new iSocketPoll();

		}
		
		public function addServer($serverName, $remoteHost, $remotePort, Array $channels = Array()){
			$server = new iServer($serverName, $remoteHost, $remotePort, $channels);
			
			$this->servers[$serverName] = $server;
			
			return $this->servers[$serverName];
		}
		
		public function joinChannel($serverName, $channel){
			if(!isset($this->servers[$serverName]))
					throw new iCoreException("Server with name ".$serverName." is not exists");
			
			$this->servers[$serverName]->joinChannel($channel);
		}
		
		public function run(){
			//$this->socketPoll->addSocket($server->getRemoteHost(), $server->getRemotePort());
			
			if($this->socketPoll->getCount() == 0)
				throw new iCoreException("Cannot start bot without any servers");
			
			while(true){
				$this->socketPoll->handle();
				
				
				
			}
		}
		
		
	}
<?php

	class  iServer{
		private $serverName;
		
		private $userName;
		private $userDomain;
		private $userRealName;

		private $remoteHost;
		private $remotePort;
		
		private $channels = Array();
		
		public function __construct($serverName, $remoteHost, $remotePort, Array $channels = Array()){
			$this->serverName = $serverName;
			$this->remoteHost = $remoteHost;
			$this->remotePort = $remotePort;
			$this->channels = $channels;
			
			$this->userName = "iBot";
			$this->userDomain = "sniff.cz";
			$this->userRealName = "HistCrawler";
		}
		
		public function __destruct(){
			unset($this->channels);
			unset($this->serverName);
			unset($this->remoteHost);
			unset($this->remotePort);
		}
		
		public function joinChannel($channel){
			$this->channels[] = $channel;
			return $this;
		}
		
		public function setUser($userName, $userDomain, $userRealName){
			$this->userName = $userName;
			$this->userDomain = $userDomain;
			$this->userRealName = $userRealName;
			return $this;
		}
		
		public function getServerName(){
			return $this->serverName;
		}
		
		public function getUserName(){
			return $this->userName;
		}
		
		public function getUserDomain(){
			return $this->userDomain;
		}
		
		public function getUserRealName(){
			return $this->userRealName;
		}
		
		public function getChannels(){
			return $this->channels;
		}
		
		public function getRemoteHost(){
			return $this->remoteHost;
		}
		
		public function getRemotePort(){
			return $this->remotePort;
		}
	}
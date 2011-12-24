<?php
	
	class iSocketPoll{
		private $handlers = Array();
		
		private $count;
		
		public function __construct(){
			$this->count = 0;
		}
		
		public function addSocket($remoteHost, $remotePort){
			$socket = new iSocket($remoteHost, $remotePort);
			$socket->create();
			$socket->connect();
			
			$this->handlers[] = $socket;
			$this->count++;
		}
		
		public function removeSocket($socketId){
			if(!isset($this->handlers[$socketId]))
				throw new iNetworkException("Socket with this id is not exists");
			
			$this->handlers[$socketId]->disconnect();
			unset($this->handlers[$socketId]);
			$this->count--;
		}
		
		public function handle(){
			$readHandlers = $writeHandlers = $exceptedHandlers = Array();

			foreach($this->handlers as $handler)
				$readHandlers[] = $handler->getHandler();

			if(socket_select($readHandlers, $writeHandlers, $exceptedHandlers, 0) > 0){
				foreach($readHandlers as $key => $handler)
					$this->handlers[$key]->read();
				
				foreach($writeHandlers as $key => $handler)
					$this->handlers[$key]->write();
				
			}
				
		}
		
		public function getCount(){
			return $this->count;
		}
	};
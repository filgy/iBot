<?php
	
	class iSocketPoll{
		private $handlers = Array();
		
		private $count;
		
		private $outputQueue;
		private $inputQueue;
		
		public function __construct(){
			$this->count = 0;
			$this->outputQueue = new iQueue();
			$this->inputQueue = new iQueue();

			$this->outputQueue->push(Array('socket' => "Quakenet" , 'data' => "USER |Kennydev| sniff.cz |Kennydev| :HistCrawlerDev"));
			$this->outputQueue->push(Array('socket' => "Quakenet" , 'data' => "NICK |Kennydev|"));
		}
		
		public function addSocket($serverName, $remoteHost, $remotePort){
			$socket = new iSocket($remoteHost, $remotePort);
			$socket->create();
			$socket->connect();
			
			$this->handlers[$serverName] = $socket;
			$this->count++;
		}
		
		public function removeSocket($serverName){
			if(!$this->findSocket($serverName))
				throw new iNetworkException("Socket with this id is not exists");
			
			$this->handlers[$serverName]->disconnect();
			unset($this->handlers[$serverName]);
			$this->count--;
		}

		public function findSocket($serverName){
			if(!isset($this->handlers[$serverName]))
				return FALSE;
			
			return $this->handlers[$serverName];
		}
		
		public function handle(){
			$readHandlers = $writeHandlers = $exceptedHandlers = Array();

			foreach($this->handlers as $serverName => $handler){
				$readHandlers[$serverName] = $handler->getHandler();
				$exceptedHandlers[$serverName] = $handler->getHandler();
			}

			if(socket_select($readHandlers, $writeHandlers, $exceptedHandlers, 1) > 0){
				foreach($readHandlers as $serverName => $handler){
					//Read data from socket
					$this->handlers[$serverName]->read();

					//Load queue from socket to main queue
					$queue = $this->handlers[$serverName]->getInputQueue();
					while(!$queue->isEmpty())
						$this->inputQueue->push(Array('socket' => $serverName, 'data' => $queue->pop()));

					//Clear socket queue
					$this->handlers[$serverName]->clearInputQueue();
				}
				
				foreach($exceptedHandlers as $serverName => $handler){
					
				}
			}
			
			//Write from queue to sockets
			while(!$this->outputQueue->isEmpty()){
				$message = $this->outputQueue->pop();
				
				if($this->findSocket($message['socket']))
					$this->findSocket($message['socket'])->write($message['data']);
			}
				

		var_dump($this->outputQueue);
		var_dump($this->inputQueue);
	}
		
		public function getCount(){
			return $this->count;
		}
	};
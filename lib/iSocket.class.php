<?php

	DEFINE("SOCK_EMPTY",					0);
	DEFINE("SOCK_READY",					1);
	DEFINE("SOCK_CONNECTED",			2);
	DEFINE("SOCK_DISCONNECTED",		3);

	class  iSocket{
		private $handler;
		
		private $remoteHost;
		private $remotePort;
		
		private $status;

		private $inputBufer;		
		private $inputQueue;
		
		private $lineDelimiter;
		
		public function __construct($remoteHost, $remotePort){
			$this->remoteHost = gethostbyname($remoteHost);
			$this->remotePort = $remotePort;
			
			$this->inputBuffer = "";
			$this->inputQueue = new iQueue();
			
			$this->lineDelimiter = "\n";
			
			$this->status = SOCK_EMPTY;
		}
		
		public function create(){
			$this->handler = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

			if($this->handler === FALSE)
				throw new iNetworkException("Cannot create socket");
			
//			socket_set_nonblock($this->handler);
			socket_set_option($this->handler, SOL_SOCKET, SO_REUSEADDR, 1);
			socket_set_option($this->handler, SOL_SOCKET, SO_RCVTIMEO, Array('sec' => 0, 'usec' => 1));
			
			$this->status = SOCK_READY;
		}
		
		public function connect(){
			if(socket_connect($this->handler, $this->remoteHost, $this->remotePort) === FALSE )
					throw new iNetworkException("Cannot connect to remote host");
			
			$this->status = SOCK_CONNECTED;
			
			socket_clear_error($this->handler);
		}
		
		public function read(){
			while(($buffer = socket_read($this->handler, 1024, PHP_BINARY_READ)) != "")
				$this->inputBuffer .= trim($buffer).$this->lineDelimiter;
			
			while(($pos = strpos($this->inputBuffer, "\n")) !== FALSE){
				$this->inputQueue->push(substr($this->inputBuffer, 0, $pos)); 
				
				$this->inputBuffer = substr($this->inputBuffer, $pos + 1);
			}
		}
		
		public function write($data){
			socket_write($this->handler, $data.$this->lineDelimiter, strlen($data.$this->lineDelimiter));
		}
		
		public function clearInputQueue(){
			$this->inputQueue->clear();
		}
		
		public function disconnect(){
			socket_close($this->handler);
		}
		
		public function getHandler(){
			return $this->handler;
		}
		
		public function getInputQueue(){
			return $this->inputQueue;
		}
		
		public function getInputBuffer(){
			return $this->inputBuffer;
		}
		
		public function getInputSize(){
			return $this->inputSize;
		}

		public function getStatus(){
			return $this->status;
		}

		public function getError(){
			return socket_last_error($this->handler);
		}
		
		public function getStrError(){
			return socket_strerror($this->getError());
		}
		
	};
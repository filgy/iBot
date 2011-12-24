<?php

	DEFINE("SOCK_READY",					0);
	DEFINE("SOCK_CONNECTING",			1);
	DEFINE("SOCK_CONNECTED",			2);
	DEFINE("SOCK_DISCONNECTED",		3);

	class  iSocket{
		private $handler;
		
		private $remoteHost;
		private $remotePort;
		
		private $status;

		private $inputSize;		
		private $inputBuffer;
		
		private $outputSize;
		private $outputBuffer;
		
		public function __construct($remoteHost, $remotePort){
			$this->remoteHost = gethostbyname($remoteHost);
			$this->remotePort = $remotePort;
			$this->status = SOCK_READY;
			
			$this->inputSize = 0;
			$this->inputBuffer = "";
			$this->outputSize = 0;
			$this->outputBuffer = "";
		}
		
		public function create(){
			$this->handler = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			
			if($this->handler === FALSE)
				throw new iNetworkException("Cannot create socket");
			
//			socket_set_nonblock($this->handler);
			
			$this->status = SOCK_CONNECTING;
		}
		
		public function connect(){
			if(socket_connect($this->handler, $this->remoteHost, $this->remotePort) === FALSE )
					throw new iNetworkException("Cannot connect to remote host");
			
			$this->status = SOCK_CONNECTED;
			
			socket_clear_error($this->handler);
		}
		
		public function read(){
			$this->inputBuffer = socket_read($this->handler, 1024, PHP_NORMAL_READ);
			
			echo trim($this->inputBuffer)."\n";
		}
		
		public function write(){
			
		}
		
		public function clearInputBuffer(){
			$this->inputBuffer = "";
			$this->inputSize = 0;
		}
		
		public function disconnect(){
			socket_close($this->handler);
		}
		
		public function getHandler(){
			return $this->handler;
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
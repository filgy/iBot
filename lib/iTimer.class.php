<?php

	class iTimer{
		private $triggers = Array();
		
		private $currentTime;
		
		public function __construct(){
			$this->currentTime = $this->getTime();
		}
		
		public function __destruct(){
			unset($this->triggers);
			unset($this->currentTime);
		}
		
		public function addTrigger($triggerName, $timeout, $callback){
			$this->triggers[$triggerName] = Array('last' => 0, 'timeout' => $timeout, 'callback' => $callback);
		}
		
		public function delTrigger($triggerName){
			if(isset($this->triggers[$triggerName]))
				unset($this->triggers[$triggerName]);
		}
		
		public function handle(){
			$this->currentTime = $this->getTime();

			foreach($this->triggers as $trigger){
				if(($trigger['last'] + $trigger['timeout']) >= $this->currentTime){

					//Proc callback

					$trigger['last'] = $this->getTime();
				}
			}
		}
		
		public function getTime(){
			return microtime(true);
		}
	};
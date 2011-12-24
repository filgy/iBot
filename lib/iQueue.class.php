<?php

	class iQueue{
		private $queue = Array();
		
		private $size;
		
		public function __construct(){
			$this->size = 0;
		}
		
		public function __destruct(){
			unset($this->queue);
			unset($this->size);
		}
		
		public function push($item){
			array_push($this->queue, $item);
			
			$this->size++;
		}
		
		public function pop(){
			if($this->isEmpty())
				return "";
			
			$this->size--;
			return array_shift($this->queue);
		}
		
		public function clear(){
			unset($this->queue);
			
			$this->queue = Array();
			$this->size = 0;
		}
		
		public function getSize(){
			return $this->size;
		}
		
		public function isEmpty(){
			return ($this->size == 0)? TRUE : FALSE;
		}
		
	};
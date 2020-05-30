<?php

namespace solo5star\promexporter\metrics;

use pocketmine\utils\Utils;

class MemoryHeapBytes extends Metric{

	public function getName(){
		return "memory_heap_bytes";
	}

	public function collect(){
		$this->registry
       			->getOrRegisterGauge(Metric::PREFIX, $this->getName(), "Memory usage of heap")
		  		->set(Utils::getRealMemoryUsage()[0]);
	}
}


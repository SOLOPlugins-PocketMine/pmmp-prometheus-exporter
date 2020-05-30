<?php

namespace solo5star\promexporter\metrics;

use pocketmine\utils\Utils;

class MemoryMainThreadBytes extends Metric{

	public function getName(){
		return "memory_main_thread_bytes";
	}

	public function collect(){
		$this->registry
       			->getOrRegisterGauge(Metric::PREFIX, $this->getName(), "Memory usage of main thread")
		  		->set(Utils::getMemoryUsage(true)[0]);
	}
}


<?php

namespace solo5star\promexporter\metrics;

use pocketmine\utils\Utils;

class MemoryMaximumBytes extends Metric{

	public function getName(){
		return "memory_maximum_bytes";
	}

	public function collect(){
		$this->registry
       			->getOrRegisterGauge(Metric::PREFIX, $this->getName(), "Maximum size of system memory")
		  		->set(Utils::getMemoryUsage(true)[2]);
	}
}


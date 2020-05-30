<?php

namespace solo5star\promexporter\metrics;

use pocketmine\utils\Utils;

class MemoryTotalBytes extends Metric{

	public function getName(){
		return "memory_total_bytes";
	}

	public function collect(){
		$this->registry
       			->getOrRegisterGauge(Metric::PREFIX, $this->getName(), "Total size of memory")
		  		->set(Utils::getMemoryUsage(true)[1]);
	}
}


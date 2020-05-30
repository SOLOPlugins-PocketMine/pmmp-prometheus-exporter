<?php

namespace solo5star\promexporter\metrics;

use pocketmine\utils\Utils;

class ThreadCount extends Metric{

	public function getName(){
		return "thread_count";
	}

	public function collect(){
		$this->registry
       			->getOrRegisterGauge(Metric::PREFIX, $this->getName(), "PocketMine Thread count")
		  		->set(Utils::getThreadCount());
	}
}


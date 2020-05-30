<?php

namespace solo5star\promexporter\metrics;

class WorldTickRate extends Metric{

	public function getName(){
		return "world_tick_rate";
	}

	public function collect(){
		$gauge = $this->registry
				->getOrRegisterGauge(Metric::PREFIX, $this->getName(), "Tick rate time(millisecond) of world", ["world", "world_folder"]);
		foreach($this->server->getLevels() as $world){
			$gauge->set($world->getTickRateTime(), [ $world->getName(), $world->getFolderName() ]);
		}
	}
}


<?php

namespace solo5star\promexporter\metrics;

class WorldLoaded extends Metric{

	public function getName(){
		return "world_loaded";
	}

	public function collect(){
		$gauge = $this->registry
				->getOrRegisterGauge(Metric::PREFIX, $this->getName(), "Currently loaded world", ["world", "world_folder"]);
		foreach($this->server->getLevels() as $world){
			$gauge->set(1, [ $world->getName(), $world->getFolderName() ]);
		}
	}
}


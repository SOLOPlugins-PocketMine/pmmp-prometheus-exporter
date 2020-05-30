<?php

namespace solo5star\promexporter\metrics;

class WorldEntityCount extends Metric{

	public function getName(){
		return "world_entity_count";
	}

	public function collect(){
		$gauge = $this->registry
				->getOrRegisterGauge(Metric::PREFIX, $this->getName(), "Count of entity", ["world", "world_folder"]);
		foreach($this->server->getLevels() as $world){
			$gauge->set(count($world->getEntities()), [ $world->getName(), $world->getFolderName() ]);
		}
	}
}


<?php

namespace solo5star\promexporter\metrics;

class WorldPlayerCount extends Metric{

	public function getName(){
		return "world_player_count";
	}

	public function collect(){
		$gauge = $this->registry
				->getOrRegisterGauge(Metric::PREFIX, $this->getName(), "Count of worlds", ["world", "world_folder"]);
		foreach($this->server->getLevels() as $world){
			$gauge->set(count($world->getPlayers()), [ $world->getName(), $world->getFolderName() ]);
		}
	}
}


<?php

namespace solo5star\promexporter\metrics;

class WorldChunkLoaded extends Metric{

	public function getName(){
		return "world_chunk_loaded";
	}

	public function collect(){
		$gauge = $this->registry
				->getOrRegisterGauge(Metric::PREFIX, $this->getName(), "Loaded chunk count", ["world", "world_folder"]);
		foreach($this->server->getLevels() as $world){
			$gauge->set(count($world->getChunks()), [ $world->getName(), $world->getFolderName() ]);
		}
	}
}


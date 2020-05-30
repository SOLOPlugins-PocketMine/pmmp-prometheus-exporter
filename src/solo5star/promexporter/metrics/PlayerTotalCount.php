<?php

namespace solo5star\promexporter\metrics;

class PlayerTotalCount extends Metric{

	public function getName(){
		return "player_total_count";
	}

	public function collect(){
		$fi = new \FilesystemIterator($this->server->getDataPath() . "players/", \FilesystemIterator::SKIP_DOTS);
		$this->registry
       			->getOrRegisterGauge(Metric::PREFIX, $this->getName(), "Total count of players (Online+Offline)")
		  		->set(iterator_count($fi));
	}
}


<?php

namespace solo5star\promexporter\metrics;

class PlayerOnlineCount extends Metric{

	public function getName(){
		return "player_online_count";
	}

	public function collect(){
		$this->registry
       			->getOrRegisterGauge(Metric::PREFIX, $this->getName(), "Count of online players")
		  		->set(count($this->server->getOnlinePlayers()));
	}
}


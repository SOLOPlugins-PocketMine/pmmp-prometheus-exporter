<?php

namespace solo5star\promexporter\metrics;

class TickUsage extends Metric{

	public function getName(){
		return "tick_usage";
	}

	public function collect(){
		$this->registry
       			->getOrRegisterGauge(Metric::PREFIX, $this->getName(), "How much tick using")
		  		->set($this->server->getTickUsageAverage());
	}
}


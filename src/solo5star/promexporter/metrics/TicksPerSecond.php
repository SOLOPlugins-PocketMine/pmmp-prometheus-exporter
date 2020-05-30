<?php

namespace solo5star\promexporter\metrics;

class TicksPerSecond extends Metric{

	public function getName(){
		return "ticks_per_second";
	}

	public function collect(){
		$this->registry
       			->getOrRegisterGauge(Metric::PREFIX, $this->getName(), "Indicates how much server lag spikes.")
		  		->set($this->server->getTicksPerSecondAverage());
	}
}


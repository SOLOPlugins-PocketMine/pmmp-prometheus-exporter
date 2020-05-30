<?php

namespace solo5star\promexporter\metrics;

class NetworkUploadBytes extends Metric{

	public function getName(){
		return "network_upload_bytes";
	}

	public function collect(){
		$this->registry
       			->getOrRegisterGauge(Metric::PREFIX, $this->getName(), "Network upload traffic usage")
		  		->set($this->server->getNetwork()->getUpload());
	}
}


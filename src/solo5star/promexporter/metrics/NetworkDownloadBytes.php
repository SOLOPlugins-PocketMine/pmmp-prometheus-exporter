<?php

namespace solo5star\promexporter\metrics;

class NetworkDownloadBytes extends Metric{

	public function getName(){
		return "network_download_bytes";
	}

	public function collect(){
		$this->registry
       			->getOrRegisterGauge(Metric::PREFIX, $this->getName(), "Network download traffic usage")
		  		->set($this->server->getNetwork()->getDownload());
	}
}


<?php

namespace solo5star\promexporter;

use pocketmine\utils\Config;
use solo5star\promexporter\metrics\Metric;

final class MetricsConfig extends Config {

	private $plugin;
	private $fileName = "metrics_config.yml";

	public function __construct(PrometheusExporter $plugin){
		@mkdir($plugin->getDataFolder());
		$plugin->saveResource($this->fileName);
		parent::__construct($plugin->getDataFolder() . $this->fileName, Config::YAML);

		$this->plugin = $plugin;
	}

	public function canUseMetric(Metric $metric){
		return $this->getNested("enable_metrics." . $metric->getName(), true) == true;
	}

	public function getHost(){
		return $this->get("host", "localhost");
	}

	public function getPort(){
		return $this->get("port", 9655);
	}
}

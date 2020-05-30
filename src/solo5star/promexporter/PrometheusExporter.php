<?php

namespace solo5star\promexporter;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\snooze\SleeperNotifier;

class PrometheusExporter extends PluginBase {

	/** @var MetricsConfig */
	private $metricsConfig;
	/** @var MetricsManager */
	private $metricsManager;
	/** @var Exporter */
	private $exporter;
	/** @var string */
	private $composerAutoloaderPath;

	public function onLoad() : void{
		$this->composerAutoloaderPath = $this->getFile() . "vendor/autoload.php";
		require $this->composerAutoloaderPath;
	}

	public function onEnable() : void{
		$this->metricsConfig = new MetricsConfig($this);
		$this->metricsManager = new MetricsManager($this);

		$notifier = new SleeperNotifier();
		$this->getServer()->getTickSleeper()->addNotifier($notifier, function() : void{
			$this->requestMetricsData();
		});
		$this->exporter = new Exporter(
			$this->composerAutoloaderPath,
			$this->metricsConfig->getHost(),
			$this->metricsConfig->getPort(),
			$notifier,
			$this->getServer()->getLogger()
		);
	}

	public function onDisable() : void{
		$this->exporter->close();
	}

	public function getMetricsConfig(){
		return $this->metricsConfig;
	}

	public function getMetricsManager(){
		return $this->metricsManager;
	}

	public function getExporter(){
		return $this->exporter;
	}

	public function requestMetricsData(){
		$this->exporter->response = $this->metricsManager->render();
		$this->exporter->synchronized(function(Exporter $exporter) : void{
			$exporter->notify();
		}, $this->exporter);
	}
}

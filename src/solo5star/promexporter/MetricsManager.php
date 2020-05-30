<?php

namespace solo5star\promexporter;

use pocketmine\Server;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\InMemory;
use Prometheus\RenderTextFormat;
use solo5star\promexporter\metrics\Metric;

class MetricsManager {

	public const DEFAULT_METRICS = [
		"MemoryHeapBytes",
		"MemoryMainThreadBytes",
		"MemoryMaximumBytes",
		"MemoryTotalBytes",
		"NetworkDownloadBytes",
		"NetworkUploadBytes",
		"PlayerOnlineCount",
		"PlayerTotalCount",
		"ThreadCount",
		"TicksPerSecond",
		"TickUsage",
		"WorldChunkLoaded",
		"WorldDiskUsageBytes",
		"WorldEntityCount",
		"WorldLoaded",
		"WorldPlayerCount",
		"WorldTickRate"
	];

	/** @var PrometheusExporter */
	private $plugin;
	/** @var Server */
	private $server;
	/** @var CollectorRegistry */
	private $registry;
	/** @var MetricsConfig */
	private $metricsConfig;
	/** @var Metric[] */
	private $metrics = [];
	/** @var RenderTextFormat */
	private $renderer;

	public function __construct(PrometheusExporter $plugin){
		$this->plugin = $plugin;
		$this->server = $this->plugin->getServer();
		$this->registry = new CollectorRegistry(new InMemory());
		$this->metricsConfig = $plugin->getMetricsConfig();
		$this->renderer = new RenderTextFormat();

		$this->registerMetrics();
	}

	public function registerMetrics() : void{
		foreach(self::DEFAULT_METRICS as $metricName){
			$metricClass = "solo5star\\promexporter\\metrics\\" . $metricName;
			$this->register(new $metricClass($this));
		}
	}

	public function getServer() : Server{
		return $this->server;
	}

	public function getRegistry() : CollectorRegistry{
		return $this->registry;
	}

	public function getMetricsConfig() : MetricsConfig{
		return $this->metricsConfig;
	}

	public function register(Metric $metric) : Metric{
		if($this->metricsConfig->canUseMetric($metric)){
			$this->metrics[$metric->getName()] = $metric;
			$this->plugin->getLogger()->debug("Metric \"{$metric->getName()}\" successfully registered.");
		}else{
			$this->plugin->getLogger()->debug("Metric \"{$metric->getName()}\" register failed: disabled by metrics config.");
		}
		return $metric;
	}

	public function collectMetrics() : void{
		foreach($this->metrics as $metric){
			$metric->collect();
		}
	}

	public function getMetrics() : array{
		return $this->metrics;
	}

	public function getMetric($name) : ?Metric{
		return $this->metrics[$name] ?? null;
	}

	public function render() : string{
		// collect metrics before rendering
		$this->collectMetrics();
		return $this->renderer->render($this->registry->getMetricFamilySamples());
	}
}

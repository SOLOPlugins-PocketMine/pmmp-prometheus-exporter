<?php

namespace solo5star\promexporter\metrics;

use solo5star\promexporter\MetricsManager;

abstract class Metric {

	public const PREFIX = "pmmp";

	protected $manager;
	protected $registry;
	protected $server;

	public function __construct(MetricsManager $manager){
		$this->manager = $manager;
		$this->registry = $manager->getRegistry();
		$this->server = $manager->getServer();
	}

	public abstract function getName();

	public abstract function collect();
}

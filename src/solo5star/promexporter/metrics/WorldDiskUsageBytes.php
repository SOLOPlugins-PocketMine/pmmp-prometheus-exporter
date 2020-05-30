<?php

namespace solo5star\promexporter\metrics;

class WorldDiskUsageBytes extends Metric{

	public function getName(){
		return "world_disk_usage_bytes";
	}

	public function collect(){
		$gauge = $this->registry
				->getOrRegisterGauge(Metric::PREFIX, $this->getName(), "Disk usage of world", ["world", "world_folder"]);
		foreach($this->server->getLevels() as $world){
			$gauge->set($this->getWorldSize($world), [ $world->getName(), $world->getFolderName() ]);
		}
	}

	private function getWorldSize($world){
		$bytesTotal = 0;
		$path = \realpath($this->server->getDataPath() . "worlds/" . $world->getFolderName() . "/");
		if($path !== false && $path != "" && file_exists($path)){
			foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS)) as $object){
				$bytesTotal += $object->getSize();
			}
		}
		return $bytesTotal;
	}
}


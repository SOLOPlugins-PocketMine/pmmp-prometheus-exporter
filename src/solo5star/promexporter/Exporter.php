<?php

namespace solo5star\promexporter;

use pocketmine\Server;
use pocketmine\Thread;
use pocketmine\snooze\SleeperNotifier;
use Amp\Http\Server\RequestHandler\CallableRequestHandler;
use Amp\Http\Server\HttpServer;
use Amp\Http\Server\Response;
use Amp\Http\Server\Router;
use Amp\Http\Status;
use Amp\Socket\Server as SocketServer;
use Amp\Loop;
use Amp\Promise;
use Psr\LogLevel;
use Psr\Log\NullLogger;

class Exporter extends Thread {

	/** @var string */
	public $host;
	/** @var int */
	public $port;
	/** @var SleeperNotifier */
	public $notifier;
	/** @var \ThreadedLogger */
	public $logger;
	/** @var string */
	public $response;
	/** @var bool */
	public $stop;

	public function __construct(string $composerAutoloaderPath, string $host, int $port, SleeperNotifier $notifier, \ThreadedLogger $logger){
		$this->composerAutoloaderPath = $composerAutoloaderPath;
		$this->host = $host;
		$this->port = $port;
		$this->notifier = $notifier;
		$this->logger = $logger;

		$this->response = "";
		$this->stop = false;

		$this->start(PTHREADS_INHERIT_NONE);
		$this->logger->info("Start Prometheus HTTP Server at {$host}:{$port}");
	}

	public function setClassLoader(\ClassLoader $loader = null){
		if($loader === null){
			$loader = Server::getInstance()->getLoader();
		}
		$this->classLoader = $loader;
	}

	public function close(){
		$this->stopHttpServer();
	}

	public function run(){
		$this->registerClassLoader();

		// running http server
		$this->runHttpServer();
	}

	public function runHttpServer(){
		$exporter = $this;
		Loop::run(function() use($exporter){
			$sockets = [ SocketServer::listen($exporter->host . ":" . $exporter->port) ];

			$router = new Router;
			$router->addRoute("GET", "/", new CallableRequestHandler(function(){
				return new Response(Status::OK, [ "content-type" => "text/html" ], '<html><h1>PocketMine-MP Prometheus Exporter</h1><a href="/metrics">See Metrics</a></html>');
			}));
			$router->addRoute("GET", "/metrics", new CallableRequestHandler(function() use($exporter){
				return $exporter->handleRequest();
			}));

			$server = new HttpServer($sockets, $router, new NullLogger);

			yield $server->start();

			Loop::repeat($msInterval = 50, function($watcherId) use($server, $exporter){
				if($exporter->stop){
					Loop::cancel($watcherId);
					yield $server->stop();
				}
			});
		});
	}

	public function stopHttpServer(){
		$this->stop = true;
		$this->logger->info("Terminate Prometheus HTTP Server");
	}

	public function handleRequest(){
		$this->synchronized(function() : void{
			$this->notifier->wakeupSleeper();
			$this->wait();
		});
		return new Response(Status::OK, [
			"content-type" => "text/plain; charset=utf-8"
		], $this->response);
	}
}

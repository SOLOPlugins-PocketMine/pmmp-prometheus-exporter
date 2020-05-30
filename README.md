# pmmp-prometheus-exporter

<br>

## What is this?
pmmp-prometheus-exporter is a data exporter to monitor PocketMine-MP server.

<br>

## How it works?
Create a thread and run HTTP server. By default, server bind to address `0.0.0.0:9655`.
Prometheus request to each node(In this case pmmp-prometheus-exporter) for gathering metrics data.
Thread will request metrics data to plugin (in Main Thread) and return data which gathered by plugin.
Finally, data is send to Prometheus.

---

Reference: Prometheus architecture

![Prometheus-Architecture](https://prometheus.io/assets/architecture.png)

<br>

## So what should I do to setup monitoring system?
Plugin will work without any dependency. But it is not intended.

You have to setup [**Prometheus**](https://prometheus.io/docs/prometheus/latest/getting_started/) + [**Grafana**](https://grafana.com/docs/grafana/latest/getting-started/getting-started/) if you want to setup perfect-monitoring-system.

This is an example using [**Prometheus**](https://prometheus.io/docs/prometheus/latest/getting_started/) + [**Grafana**](https://grafana.com/docs/grafana/latest/getting-started/getting-started/).
![Grafana-Example](https://raw.githubusercontent.com/solo5star/pmmp-prometheus-exporter/master/pictures/Grafana-Example.png)

<br>

## Download
* [**Latest Phar**](https://github.com/solo5star/pmmp-prometheus-exporter/releases/latest/download/pmmp-prometheus-exporter.phar)
* [**Grafana Dashboard(JSON)**](https://raw.githubusercontent.com/solo5star/pmmp-prometheus-exporter/master/grafana-dashboard.json)

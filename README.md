
# SysInfo

## About

This library provides a simple way to get current CPU and memory usage.

## Usage

```php
<?php

$environment = \PSX\SysInfo\Environment::create();

$cpuUsage = $environment->getCpuUsage();
$memoryUsage = $environment->getMemoryUsage();

```

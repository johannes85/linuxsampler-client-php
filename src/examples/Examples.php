<?php

require __DIR__.'/../../vendor/autoload.php';

$app = new \Symfony\Component\Console\Application();
$app->add(new \Johnimedia\LinuxSampler\Client\Examples\AudioOutputDriversCommand());
$app->add(new \Johnimedia\LinuxSampler\Client\Examples\MidiInputDriversCommand());
$app->add(new \Johnimedia\LinuxSampler\Client\Examples\ChannelsCommand());
$app->add(new \Johnimedia\LinuxSampler\Client\Examples\MidiInputDevicesCommand());
$app->add(new \Johnimedia\LinuxSampler\Client\Examples\MidiDataCommand());
$app->run();
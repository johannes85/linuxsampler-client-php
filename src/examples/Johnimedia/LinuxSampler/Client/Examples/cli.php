<?php

require __DIR__.'/../../../../../../vendor/autoload.php';

$app = new \Symfony\Component\Console\Application();
$app->add(new \Johnimedia\LinuxSampler\Client\Examples\Cli\AudioOutputDriversCommand());
$app->add(new \Johnimedia\LinuxSampler\Client\Examples\Cli\MidiInputDriversCommand());
$app->add(new \Johnimedia\LinuxSampler\Client\Examples\Cli\ChannelsCommand());
$app->add(new \Johnimedia\LinuxSampler\Client\Examples\Cli\MidiInputDevicesCommand());
$app->add(new \Johnimedia\LinuxSampler\Client\Examples\Cli\MidiDataCommand());
$app->add(new \Johnimedia\LinuxSampler\Client\Examples\Cli\InstrumentsFileCommand());
$app->add(new \Johnimedia\LinuxSampler\Client\Examples\Cli\LoadInstrumentCommand());
$app->run();
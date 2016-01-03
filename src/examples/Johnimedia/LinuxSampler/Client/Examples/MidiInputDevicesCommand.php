<?php
namespace Johnimedia\LinuxSampler\Client\Examples;

use Johnimedia\LinuxSampler\Client\LinuxSampler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MidiInputDevicesCommand extends Command {

  protected function configure()
  {
    $this->setName('example:midiInputDevices');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $sampler= new LinuxSampler();
    $output->writeln('Connecting to server...');
    $sampler->connect();
    $output->writeln('Available midi input devices: ' . $sampler->getMidiInputDevices());
    $deviceList = $sampler->getMidiInputDeviceList();
    $output->writeln('List:');
    foreach ($deviceList as $deviceId) {
      $output->writeln(' ' . $deviceId);
      $deviceSettings = $sampler->getMidiInputDeviceSettings($deviceId);
      $output->writeln('  Driver: ' . $deviceSettings->driver);
      $output->writeln('  Active: ' . $deviceSettings->active);
    }
  }
}


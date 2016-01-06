<?php
namespace Johnimedia\LinuxSampler\Client\Examples\Cli;

use Johnimedia\LinuxSampler\Client\LinuxSampler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MidiInputDriversCommand extends Command {

  protected function configure()
  {
    $this->setName('example:midiInputDrivers');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $sampler= new LinuxSampler();
    $output->writeln('Connecting to server...');
    $sampler->connect();
    $output->writeln('Available midi input drivers: ' . $sampler->getAvailableMidiInputDrivers());
    $driversList = $sampler->getAvailableMidiInputDriverList();
    $output->writeln('List:');
    foreach ($driversList as $driver) {
      $output->writeln(' ' . $driver);
      $driverInfos = $sampler->getMidiInputDriverInfo($driver);
      $output->writeln('  Description: ' . $driverInfos->description);
      $output->writeln('  Version: ' . $driverInfos->version);
      $output->writeln('  Parameters: ' . implode(', ', $driverInfos->parameters));
    }
  }
}


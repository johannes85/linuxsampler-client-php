<?php
namespace Johnimedia\LinuxSampler\Client\Examples;

use Johnimedia\LinuxSampler\Client\LinuxSampler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AudioOutputDriversCommand extends Command {

  protected function configure()
  {
    $this->setName('example:audioOutputDrivers');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $sampler= new LinuxSampler();
    $output->writeln('Connecting to server...');
    $sampler->connect();
    $output->writeln('Available output drivers: ' . $sampler->getAvailableAudioOutputDrivers());
    $driversList = $sampler->getAvailableAudioOutputDriverList();
    $output->writeln('List:');
    foreach ($driversList as $driver) {
      $output->writeln(' ' . $driver);
      $driverInfos = $sampler->getAudioOutputDriverInfo($driver);
      $output->writeln('  Description: ' . $driverInfos->description);
      $output->writeln('  Version: ' . $driverInfos->version);
      $output->writeln('  Parameters: ' . implode(', ', $driverInfos->parameters));
    }
  }
}


<?php
namespace Johnimedia\LinuxSampler\Client\Examples\Cli;

use Johnimedia\LinuxSampler\Client\LinuxSampler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadInstrumentCommand extends Command {

  protected function configure()
  {
    $this->setName('example:loadInstrument');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $sampler= new LinuxSampler('192.168.178.47');
    $output->writeln('Connecting to server...');
    $sampler->connect();
    $intrumentsFile = '/home/pi/linuxsampler/telecaster.gig';
    $instrumentId = 0;
    $output->writeln(sprintf(
      'Loading instrument %s from file %s...',
      $instrumentId,
      $intrumentsFile
    ));
    $res = $sampler->loadInstrument($intrumentsFile, $instrumentId, 0, true);
    $output->writeln('done');
  }
}

